<style>
    .sidebar {
        position: sticky;
        top: 80px;
        height: fit-content;
    }

    .main-content {
        /* max-height: calc(100vh - 120px); */
        /* overflow-y: auto; */
    }

    .nav-buttons {
        padding: 20px 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .nav-buttons .nav-btn {
        color: black;
        padding: 8px 10px;
    }

    .nav-btn.active {
        background-color: #7b7c7eff;
        color: white;
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
<div class="container-fluid" style="box-sizing: border-box; padding-top: 80px;">
    <?php if (isset($_SESSION['rs_name'])): ?>
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 style="text-align: center; text-secondary"><i class="fas fa-store me-2 text-primary"></i>
                    <?= $_SESSION['rs_name'] ?> <i class="fas fa-store me-2 text-primary"></i></h1>
            </div>
        </div>
        <?php
    endif;
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'shop') {
        header("refresh:1;url=/zerowaste");
        exit;
    }
    $check_restaurant = $db->query("SELECT * FROM restaurant WHERE user_id = " . (int) $_SESSION['user_id'] . "");
    if (mysqli_num_rows($check_restaurant) > 0):
        if (!isset($_SESSION['rs_id'])) {
            $res = mysqli_fetch_assoc($check_restaurant);
            $_SESSION['rs_id'] = $res['rs_id'];
            $_SESSION['rs_name'] = $res['title'];
        }
        ?>
        <div class="container">
            <div class="sidebar">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="nav-buttons">
                            <a href="?p=dashboard"
                                class="nav-btn rounded <?= ($_GET['p'] ?? 'dashboard') == 'dashboard' ? 'active' : '' ?>">
                                <i class="fas fa-tachometer-alt"></i> ထိန်းချုပ်ဘုတ်
                            </a>
                            <a href="?p=dishes"
                                class="nav-btn rounded <?= ($_GET['p'] ?? '') == 'dishes' ? 'active' : '' ?>">
                                <i class="fas fa-utensils"></i> အစားအသောက်များ 
                            </a>
                            <a href="?p=claims"
                                class="nav-btn rounded <?= ($_GET['p'] ?? '') == 'claims' ? 'active' : '' ?>">
                                <i class="fas fa-inbox"></i> စားသုံးသူ၏ အော်ဒါများ
                            </a>
                            <a href="?p=my"
                                class="nav-btn rounded <?= ($_GET['p'] ?? '') == 'my' ? 'active' : '' ?>">
                                <i class="fas fa-store"></i> မိမိ ဆိုင်
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content w-100" style="">
                <div class="card shadow">
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
                            case 'my':
                                include 'myshop.php';
                                break;
                            case 'ad':
                                include 'dishes/add_dish.php';
                                break;
                            case 'ed':
                                include 'dishes/edit_dish.php';
                                break;
                            case 'claims':
                                include 'claims/index.php';
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