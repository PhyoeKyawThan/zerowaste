<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'shop') {
    header("refresh:1;url=/zerowaste");
    exit;
}
?>
<style>
    .stat-card {
        transition: transform 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .nav-pills .nav-link.active {
        background-color: #0d6efd;
    }

    .dish-image-preview {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
        border-radius: 4px;
    }

    table th, td{
        color: black;
    }

    .card-body{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }

    .card-body .card-title{
        font-weight: bold;
    }
</style>
<div class="container-fluid" style="padding-top: 100px">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 text-primary">
            <i class="fas fa-store me-2"></i>My Shop Dashboard
        </h1>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown">
                <i class="fas fa-user-circle me-1"></i>Shop Account
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <h2 class="card-text">124</h2>
                    <p class="card-text"><small>+12% from last week</small></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Active Dishes</h5>
                    <h2 class="card-text">28</h2>
                    <p class="card-text"><small>5 in draft</small></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Pending Claims</h5>
                    <h2 class="card-text">7</h2>
                    <p class="card-text"><small>Need attention</small></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Today's Revenue</h5>
                    <h2 class="card-text">$1,245</h2>
                    <p class="card-text"><small>+$320 yesterday</small></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Tabs -->
    <ul class="nav nav-pills mb-4" id="shopTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="dishes-tab" data-bs-toggle="pill" data-bs-target="#dishes"
                type="button">
                <i class="fas fa-utensils me-1"></i>Manage Dishes
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="categories-tab" data-bs-toggle="pill" data-bs-target="#categories"
                type="button">
                <i class="fas fa-list me-1"></i>Menu Categories
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="claims-tab" data-bs-toggle="pill" data-bs-target="#claims" type="button">
                <i class="fas fa-comment-alt me-1"></i>Customer Claims
                <span class="badge bg-danger ms-1">7</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="shopTabsContent">
        <!-- Dishes Tab -->
        <div class="tab-pane fade show active" id="dishes" role="tabpanel">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Dishes</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDishModal">
                        <i class="fas fa-plus me-1"></i>Add New Dish
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Dish Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src="https://via.placeholder.com/50" class="dish-image-preview" alt="Dish">
                                    </td>
                                    <td>Spaghetti Carbonara</td>
                                    <td>Pasta</td>
                                    <td>$12.99</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i
                                                class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="https://via.placeholder.com/50" class="dish-image-preview" alt="Dish">
                                    </td>
                                    <td>Margherita Pizza</td>
                                    <td>Pizza</td>
                                    <td>$14.50</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i
                                                class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="https://via.placeholder.com/50" class="dish-image-preview" alt="Dish">
                                    </td>
                                    <td>Chocolate Lava Cake</td>
                                    <td>Dessert</td>
                                    <td>$6.99</td>
                                    <td><span class="badge bg-warning text-dark">Draft</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i
                                                class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Tab -->
        <div class="tab-pane fade" id="categories" role="tabpanel">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Menu Categories</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="fas fa-plus me-1"></i>Add Category
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Appetizers
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary me-1"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i
                                                class="fas fa-trash"></i></button>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Main Courses
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary me-1"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i
                                                class="fas fa-trash"></i></button>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Desserts
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary me-1"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i
                                                class="fas fa-trash"></i></button>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Beverages
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary me-1"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i
                                                class="fas fa-trash"></i></button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Claims Tab -->
        <div class="tab-pane fade" id="claims" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Customer Claims</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Order #12345 - Missing item</h6>
                                <small class="text-danger">Pending</small>
                            </div>
                            <p class="mb-1">Customer reported missing garlic bread from their order</p>
                            <small>Received 2 hours ago</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Order #12342 - Food quality</h6>
                                <small class="text-success">Resolved</small>
                            </div>
                            <p class="mb-1">Pizza was cold when delivered</p>
                            <small>Resolved yesterday</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Order #12338 - Wrong item</h6>
                                <small class="text-warning">In Progress</small>
                            </div>
                            <p class="mb-1">Received vegetarian pizza instead of pepperoni</p>
                            <small>Received 1 day ago</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addDishModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Dish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="dishName" class="form-label">Dish Name</label>
                            <input type="text" class="form-control" id="dishName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dishCategory" class="form-label">Category</label>
                            <select class="form-select" id="dishCategory" required>
                                <option value="">Select Category</option>
                                <option>Appetizers</option>
                                <option>Main Courses</option>
                                <option>Desserts</option>
                                <option>Beverages</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="dishPrice" class="form-label">Price ($)</label>
                            <input type="number" step="0.01" class="form-control" id="dishPrice" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dishStatus" class="form-label">Status</label>
                            <select class="form-select" id="dishStatus" required>
                                <option value="active">Active</option>
                                <option value="draft">Draft</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="dishDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="dishDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="dishImage" class="form-label">Dish Image</label>
                        <input class="form-control" type="file" id="dishImage" accept="image/*">
                        <div class="form-text">Upload a high-quality image of your dish (max 2MB)</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save Dish</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoryDescription" class="form-label">Description (Optional)</label>
                        <textarea class="form-control" id="categoryDescription" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Add Category</button>
            </div>
        </div>
    </div>
</div>