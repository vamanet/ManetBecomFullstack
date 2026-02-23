<template>
  <div class="mb-4">
    <h1 class="display-6 fw-bold text-dark">Users List</h1>
    <p class="text-muted">Manage your application users</p>

  <div class="card shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th scope="col" class="fw-semibold">ID</th>
              <th scope="col" class="fw-semibold">Name</th>
              <th scope="col" class="fw-semibold">Email</th>
              <th scope="col" class="fw-semibold">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td class="fw-medium">Sample User</td>
              <td>user@example.com</td>
              <td>
                <button class="btn btn-sm btn-outline-primary me-1">Edit</button>
                <button class="btn btn-sm btn-outline-danger">Delete</button>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td class="fw-medium">John Doe</td>
              <td>john@example.com</td>
              <td>
                <button class="btn btn-sm btn-outline-primary me-1">Edit</button>
                <button class="btn btn-sm btn-outline-danger">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
</template>