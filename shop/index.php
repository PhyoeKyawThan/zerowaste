<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'shop') {
    header("refresh:1;url=/zerowaste");
    exit;
}
?>

  <style>
    body {
        /* background-image: url('images/img/pimg.jpg'); */
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        color: #fff;
    }

    .shop-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        padding: 40px 0;
    }

    .nav-tabs .nav-link.active {
        background-color: #0d6efd;
        color: #fff;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.9);
    }
  </style>

<div class="container shop-wrapper">
  <div class="text-center mb-4">
    <h2 class="fw-bold text-light">👨‍🍳 Welcome, Restaurant Owner</h2>
    <p class="text-primary">Manage your menu, categories, and customer claims here.</p>
  </div>

  <!-- Nav Tabs -->
  <ul class="nav nav-tabs mb-4" id="shopTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button">Dashboard</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="dishes-tab" data-bs-toggle="tab" data-bs-target="#dishes" type="button">Dishes</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button">Categories</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="claims-tab" data-bs-toggle="tab" data-bs-target="#claims" type="button">User Claims</button>
    </li>
  </ul>

  <!-- Tab Content -->
  <div class="tab-content" id="shopTabContent">
    
    <!-- Dashboard Section -->
    <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card shadow-sm text-center">
            <div class="card-body">
              <h5>Total Dishes</h5>
              <h2>12</h2>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm text-center">
            <div class="card-body">
              <h5>Categories</h5>
              <h2>4</h2>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm text-center">
            <div class="card-body">
              <h5>New Claims</h5>
              <h2>3</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Dishes Section -->
    <div class="tab-pane fade" id="dishes" role="tabpanel">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-light">📋 Manage Dishes</h4>
        <a href="add_dish.php" class="btn btn-success btn-sm"><i class="fas fa-plus-circle me-1"></i> Add Dish</a>
      </div>
      <!-- Replace below with a PHP loop -->
      <div class="card mb-2">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h5 class="mb-0">Fried Rice</h5>
            <small class="text-muted">"Spicy and delicious"</small>
          </div>
          <div>
            <a href="edit_dish.php?id=1" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
            <a href="delete_dish.php?id=1" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
          </div>
        </div>
      </div>
    </div>

    <!-- Categories Section -->
    <div class="tab-pane fade" id="categories" role="tabpanel">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-light">🍽️ Menu Categories</h4>
        <a href="add_category.php" class="btn btn-success btn-sm"><i class="fas fa-plus-circle me-1"></i> Add Category</a>
      </div>
      <!-- Replace below with PHP loop -->
      <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Drinks
          <div>
            <a href="edit_category.php?id=2" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
            <a href="delete_category.php?id=2" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
          </div>
        </li>
      </ul>
    </div>

    <!-- User Claims Section -->
    <div class="tab-pane fade" id="claims" role="tabpanel">
      <h4 class="text-light mb-3">🛎️ User Claims</h4>
      <!-- Replace below with PHP loop -->
      <div class="card mb-2">
        <div class="card-body">
          <strong>User:</strong> john@example.com <br>
          <strong>Message:</strong> My order was delayed.
          <div class="mt-2">
            <a href="#" class="btn btn-sm btn-secondary">Mark as Resolved</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>