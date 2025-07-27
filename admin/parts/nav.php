<nav class="col-md-2 d-none d-md-block sidebar">
    <div class="position-sticky pt-3">
        <a href="dashboard.php" class="mb-3 d-block text-center">
            <img src="/zerowaste/images/icn.png" alt="Logo" style="width: 100px;">
        </a>
        <?php
        $current = basename($_SERVER['PHP_SELF']);
        ?>

        <a href="dashboard.php" class="<?= $current === 'dashboard.php' ? 'active' : '' ?>">
            <i class="fa fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a href="users.php" class="<?= $current === 'users.php' ? 'active' : '' ?>">
            <i class="fa fa-users me-2"></i> Users
        </a>
        <a href="restaurants.php" class="<?= $current === 'restaurants.php' ? 'active' : '' ?>">
            <i class="fa fa-utensils me-2"></i> Restaurants
        </a>
        <a href="category.php" class="<?= $current === 'category.php' ? 'active' : '' ?>">
            <i class="fa fa-tags me-2"></i> Categories
        </a>
        <a href="dishes.php" class="<?= $current === 'dishes.php' ? 'active' : '' ?>">
            <i class="fa fa-book me-2"></i> All Dishes
        </a>
        <a href="users_claims.php" class="<?= $current === 'users_claims.php' ? 'active' : '' ?>">
            <i class="fa fa-inbox me-2"></i> Users Claims
        </a>
        <a href="logout.php" class="mt-4">
            <i class="fa fa-sign-out-alt me-2"></i> Logout
        </a>

    </div>
</nav>