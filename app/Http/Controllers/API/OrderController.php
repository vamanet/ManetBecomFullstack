<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.food']);

        // Filter by user if not admin
        if ($request->user()) {
            $query->where('user_id', $request->user()->id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.food_id' => 'required|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1',
            'delivery_address' => 'nullable|string',
            'phone' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Calculate total amount
            $totalAmount = 0;
            $orderItemsData = [];

            foreach ($request->items as $item) {
                $food = Food::findOrFail($item['food_id']);
                $subtotal = $food->price * $item['quantity'];
                $totalAmount += $subtotal;

                $orderItemsData[] = [
                    'food_id' => $food->id,
                    'quantity' => $item['quantity'],
                    'price' => $food->price,
                    'subtotal' => $subtotal,
                ];
            }

            // Generate unique order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

            // Create order
            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'delivery_address' => $request->delivery_address,
                'phone' => $request->phone,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($orderItemsData as $itemData) {
                $order->orderItems()->create($itemData);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => new OrderResource($order->load(['user', 'orderItems.food']))
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Request $request, $id)
    {
        $order = Order::with(['user', 'orderItems.food'])->findOrFail($id);

        // Check if user owns this order
        if ($order->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => new OrderResource($order)
        ]);
    }

    /**
     * Update the specified order status.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,processing,completed,cancelled',
            'delivery_address' => 'nullable|string',
            'phone' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::findOrFail($id);

        // Check if user owns this order
        if ($order->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        // Only allow cancellation if order is pending
        if ($request->status === 'cancelled' && $order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending orders can be cancelled'
            ], 400);
        }

        $order->update($request->only(['status', 'delivery_address', 'phone', 'notes']));

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'data' => new OrderResource($order->load(['user', 'orderItems.food']))
        ]);
    }

    /**
     * Remove the specified order.
     */
    public function destroy(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Check if user owns this order
        if ($order->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        // Only allow deletion if order is pending or cancelled
        if (!in_array($order->status, ['pending', 'cancelled'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only pending or cancelled orders can be deleted'
            ], 400);
        }

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully'
        ]);
    }

    /**
     * Get order statistics for the authenticated user.
     */
    public function statistics(Request $request)
    {
        $userId = $request->user()->id;

        $stats = [
            'total_orders' => Order::where('user_id', $userId)->count(),
            'pending_orders' => Order::where('user_id', $userId)->where('status', 'pending')->count(),
            'processing_orders' => Order::where('user_id', $userId)->where('status', 'processing')->count(),
            'completed_orders' => Order::where('user_id', $userId)->where('status', 'completed')->count(),
            'cancelled_orders' => Order::where('user_id', $userId)->where('status', 'cancelled')->count(),
            'total_spent' => Order::where('user_id', $userId)
                ->where('status', 'completed')
                ->sum('total_amount'),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
