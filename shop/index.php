<style>
    .sidebar {
        position: sticky;
        top: 80px;
        height: fit-content;
    }

    .main-content {
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }

    @media (max-width: 768px) {
        .sidebar {
            position: static;
            margin-bottom: 20px;
        }

        .main-content {
            max-height: none;
            overflow-y: visible;
        }
    }
</style>
<div class="container-fluid" style=" padding-top: 80px;">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-6"><i class="fas fa-store me-2"></i>My Shop</h1>
        </div>
    </div>
    <?php
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'shop') {
        header("refresh:1;url=/zerowaste");
        exit;
    }
    $check_restaurant = $db->query("SELECT * FROM restaurant WHERE user_id = " . (int) $_SESSION['user_id'] . "");
    if (mysqli_num_rows($check_restaurant) > 0):
            if(!isset($_SESSION['rs_id']))
                $_SESSION['rs_id'] = mysqli_fetch_assoc($check_restaurant)['rs_id'];
        ?>
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3 col-md-4 mb-4 mb-md-0">
                <div class="card sidebar shadow-sm">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="?p=dashboard"
                                class="btn btn-outline-primary text-start <?= ($_GET['p'] ?? 'dashboard') == 'dashboard' ? 'active' : '' ?>">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                            <!-- <a href="?p=category"
                                class="btn btn-outline-primary text-start <?= ($_GET['p'] ?? '') == 'category' ? 'active' : '' ?>">
                                <i class="fas fa-list me-2"></i>Category
                            </a> -->
                            <a href="?p=dishes"
                                class="btn btn-outline-primary text-start <?= ($_GET['p'] ?? '') == 'dishes' ? 'active' : '' ?>">
                                <i class="fas fa-utensils me-2"></i> Dishes
                            </a>
                            <a href="?p=setting"
                                class="btn btn-outline-primary text-start <?= ($_GET['p'] ?? '') == 'setting' ? 'active' : '' ?>">
                                <i class="fas fa-cog me-2"></i> Shop Setting
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-8">
                <div class="card main-content shadow-sm">
                    <div class="card-body">
                        <?php
                        $p = $_GET['p'] ?? 'dashboard';
                        switch ($p) {
                            case 'dashboard':
                                include 'dashboard.php';
                                break;
                            case 'category':
                                include 'category.php';
                                break;
                            case 'dishes':
                                include 'dishes.php';
                                break;
                            case 'setting':
                                include 'setting.php';
                                break;
                            case 'ad':
                                include 'dishes/add_dish.php';
                                break;
                            case 'ed':
                                include 'dishes/edit_dish.php';
                                break;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: 
        include 'create_res.php';
    ?>
    <?php endif; ?>
</div>