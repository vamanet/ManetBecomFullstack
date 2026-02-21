<template>
  <div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <h2 class="mb-0">Dashboard Overview</h2>
                <button class="btn btn-primary">Create Report</button>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <p class="text-muted mb-1">Total Sales</p>
                            <h3 class="mb-0">$24,580</h3>
                            <small class="text-success">+12% this month</small>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <p class="text-muted mb-1">Active Users</p>
                            <h3 class="mb-0">1,294</h3>
                            <small class="text-success">+8% this month</small>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <p class="text-muted mb-1">Open Tickets</p>
                            <h3 class="mb-0">38</h3>
                            <small class="text-danger">+5 today</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                        <h5 class="mb-0">Recent Activity</h5>
                        <a class="btn btn-outline-secondary btn-sm" href="#">View all</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">User</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Date</th>
                                    <th scope="col" class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Amara Lee</td>
                                    <td>Created a new report</td>
                                    <td>Feb 20, 2026</td>
                                    <td class="text-end"><span class="badge text-bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>Javier Soto</td>
                                    <td>Updated billing info</td>
                                    <td>Feb 19, 2026</td>
                                    <td class="text-end"><span class="badge text-bg-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>Nia Brooks</td>
                                    <td>Invited a new member</td>
                                    <td>Feb 18, 2026</td>
                                    <td class="text-end"><span class="badge text-bg-info">In Review</span></td>
                                </tr>
                                <tr>
                                    <td>Marcus Reed</td>
                                    <td>Closed a ticket</td>
                                    <td>Feb 17, 2026</td>
                                    <td class="text-end"><span class="badge text-bg-secondary">Resolved</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</template>

<script setup lang="ts">
</script>

<style scoped>
.container-fluid{
    margin-left: 265px;
    width: 80%;
    margin-top: 10px;
}
</style>