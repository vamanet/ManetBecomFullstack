# Order Management System - API Documentation

## Overview
A complete order management system for the food ordering application with full CRUD operations, order tracking, and statistics.

## Database Schema

### Orders Table
- `id` - Primary key
- `user_id` - Foreign key to users table
- `order_number` - Unique order identifier (e.g., ORD-20260306-ABC123)
- `total_amount` - Total order amount (decimal)
- `status` - Order status (pending, processing, completed, cancelled)
- `delivery_address` - Delivery address (nullable)
- `phone` - Contact phone number (nullable)
- `notes` - Additional notes (nullable)
- `created_at` - Order creation timestamp
- `updated_at` - Order update timestamp

### Order Items Table
- `id` - Primary key
- `order_id` - Foreign key to orders table
- `food_id` - Foreign key to foods table
- `quantity` - Item quantity
- `price` - Item price at time of order
- `subtotal` - Calculated subtotal (price × quantity)
- `created_at` - Creation timestamp
- `updated_at` - Update timestamp

## API Endpoints

All order endpoints require authentication using Laravel Sanctum (`auth:sanctum` middleware).

### 1. List Orders
**GET** `/api/orders`

Get a paginated list of orders for the authenticated user.

**Query Parameters:**
- `status` (optional) - Filter by order status (pending, processing, completed, cancelled)
- `page` (optional) - Page number for pagination

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "order_number": "ORD-20260306-ABC123",
      "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
      },
      "total_amount": "150.00",
      "status": "pending",
      "delivery_address": "123 Main St",
      "phone": "1234567890",
      "notes": "Please ring doorbell",
      "items": [
        {
          "id": 1,
          "food": {
            "id": 1,
            "name": "Pizza",
            "image": "pizza.jpg"
          },
          "quantity": 2,
          "price": "50.00",
          "subtotal": "100.00"
        }
      ],
      "created_at": "2026-03-06 10:30:00",
      "updated_at": "2026-03-06 10:30:00"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

### 2. Create Order
**POST** `/api/orders`

Create a new order with multiple items.

**Request Body:**
```json
{
  "items": [
    {
      "food_id": 1,
      "quantity": 2
    },
    {
      "food_id": 3,
      "quantity": 1
    }
  ],
  "delivery_address": "123 Main St",
  "phone": "1234567890",
  "notes": "Please ring doorbell"
}
```

**Validation Rules:**
- `items` - Required, array, minimum 1 item
- `items.*.food_id` - Required, must exist in foods table
- `items.*.quantity` - Required, integer, minimum 1
- `delivery_address` - Optional, string
- `phone` - Optional, string
- `notes` - Optional, string

**Success Response (201):**
```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "id": 1,
    "order_number": "ORD-20260306-ABC123",
    "user": {...},
    "total_amount": "150.00",
    "status": "pending",
    "items": [...]
  }
}
```

**Error Response (422):**
```json
{
  "success": false,
  "errors": {
    "items": ["The items field is required."],
    "items.0.food_id": ["The selected food id is invalid."]
  }
}
```

### 3. Get Order Details
**GET** `/api/orders/{id}`

Get detailed information about a specific order.

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "order_number": "ORD-20260306-ABC123",
    "user": {...},
    "total_amount": "150.00",
    "status": "pending",
    "delivery_address": "123 Main St",
    "phone": "1234567890",
    "notes": "Please ring doorbell",
    "items": [...],
    "created_at": "2026-03-06 10:30:00",
    "updated_at": "2026-03-06 10:30:00"
  }
}
```

**Error Response (403):**
```json
{
  "success": false,
  "message": "Unauthorized access"
}
```

### 4. Update Order
**PUT/PATCH** `/api/orders/{id}`

Update order details. Users can only update their own orders.

**Request Body:**
```json
{
  "status": "cancelled",
  "delivery_address": "456 New St",
  "phone": "0987654321",
  "notes": "Updated notes"
}
```

**Validation Rules:**
- `status` - Required, must be one of: pending, processing, completed, cancelled
- `delivery_address` - Optional, string
- `phone` - Optional, string
- `notes` - Optional, string

**Business Rules:**
- Only pending orders can be cancelled by users
- Users can only update their own orders

**Success Response:**
```json
{
  "success": true,
  "message": "Order updated successfully",
  "data": {...}
}
```

**Error Response (400):**
```json
{
  "success": false,
  "message": "Only pending orders can be cancelled"
}
```

### 5. Delete Order
**DELETE** `/api/orders/{id}`

Delete an order. Only pending or cancelled orders can be deleted.

**Success Response:**
```json
{
  "success": true,
  "message": "Order deleted successfully"
}
```

**Error Response (400):**
```json
{
  "success": false,
  "message": "Only pending or cancelled orders can be deleted"
}
```

### 6. Order Statistics
**GET** `/api/orders-statistics`

Get order statistics for the authenticated user.

**Response:**
```json
{
  "success": true,
  "data": {
    "total_orders": 25,
    "pending_orders": 3,
    "processing_orders": 5,
    "completed_orders": 15,
    "cancelled_orders": 2,
    "total_spent": "2500.00"
  }
}
```

## Models and Relationships

### Order Model
**Location:** [`app/Models/Order.php`](app/Models/Order.php:1)

**Relationships:**
- `user()` - BelongsTo User
- `orderItems()` - HasMany OrderItem

**Fillable Fields:**
- user_id, order_number, total_amount, status, delivery_address, phone, notes

### OrderItem Model
**Location:** [`app/Models/OrderItem.php`](app/Models/OrderItem.php:1)

**Relationships:**
- `order()` - BelongsTo Order
- `food()` - BelongsTo Food

**Fillable Fields:**
- order_id, food_id, quantity, price, subtotal

### User Model
**Updated with:**
- `orders()` - HasMany Order relationship

### Food Model
**Updated with:**
- `orderItems()` - HasMany OrderItem relationship

## Resources

### OrderResource
**Location:** [`app/Http/Resources/OrderResource.php`](app/Http/Resources/OrderResource.php:1)

Transforms order data for API responses with user information and order items.

### OrderItemResource
**Location:** [`app/Http/Resources/OrderItemResource.php`](app/Http/Resources/OrderItemResource.php:1)

Transforms order item data with food information.

## Controller

### OrderController
**Location:** [`app/Http/Controllers/API/OrderController.php`](app/Http/Controllers/API/OrderController.php:1)

**Methods:**
- `index()` - List orders with filtering and pagination
- `store()` - Create new order with transaction handling
- `show()` - Get order details with authorization check
- `update()` - Update order with business rule validation
- `destroy()` - Delete order with status validation
- `statistics()` - Get user order statistics

## Features

### 1. Order Creation
- Automatic order number generation (ORD-YYYYMMDD-XXXXXX)
- Automatic total calculation based on food prices
- Transaction handling for data integrity
- Multiple items per order support

### 2. Order Management
- View all orders with pagination
- Filter orders by status
- Update order details
- Cancel pending orders
- Delete pending/cancelled orders

### 3. Security
- Authentication required for all endpoints
- Users can only access their own orders
- Authorization checks on all operations

### 4. Order Tracking
- Four status levels: pending, processing, completed, cancelled
- Status transition validation
- Order history tracking

### 5. Statistics
- Total orders count
- Orders by status
- Total amount spent on completed orders

## Usage Examples

### Creating an Order with cURL
```bash
curl -X POST http://localhost:8000/api/orders \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "items": [
      {"food_id": 1, "quantity": 2},
      {"food_id": 3, "quantity": 1}
    ],
    "delivery_address": "123 Main St",
    "phone": "1234567890",
    "notes": "Please ring doorbell"
  }'
```

### Filtering Orders by Status
```bash
curl -X GET "http://localhost:8000/api/orders?status=pending" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Getting Order Statistics
```bash
curl -X GET http://localhost:8000/api/orders-statistics \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## Database Migrations

Run the following commands to create the order tables:

```bash
php artisan migrate --path=database/migrations/2026_03_06_022051_create_orders_table.php
php artisan migrate --path=database/migrations/2026_03_06_022052_create_order_items_table.php
```

Or simply run:
```bash
php artisan migrate
```

## Testing Checklist

- [ ] Create order with single item
- [ ] Create order with multiple items
- [ ] View order list
- [ ] Filter orders by status
- [ ] View order details
- [ ] Update order information
- [ ] Cancel pending order
- [ ] Try to cancel non-pending order (should fail)
- [ ] Delete pending order
- [ ] Try to delete processing order (should fail)
- [ ] View order statistics
- [ ] Try to access another user's order (should fail)
- [ ] Create order with invalid food_id (should fail)
- [ ] Create order with zero quantity (should fail)

## Future Enhancements

1. **Payment Integration**
   - Add payment method field
   - Payment status tracking
   - Payment gateway integration

2. **Order Notifications**
   - Email notifications on order status changes
   - SMS notifications for delivery updates

3. **Admin Features**
   - Admin dashboard for order management
   - Bulk order status updates
   - Order analytics and reports

4. **Delivery Tracking**
   - Real-time delivery tracking
   - Estimated delivery time
   - Delivery person assignment

5. **Order Reviews**
   - Customer reviews and ratings
   - Food item ratings
   - Review moderation

## Notes

- All monetary values are stored as DECIMAL(10,2)
- Order numbers are unique and auto-generated
- Soft deletes can be added if needed
- Consider adding order history/audit trail for production
