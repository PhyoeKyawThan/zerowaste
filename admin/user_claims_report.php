<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'parts/start.php';

$month = $_GET['month'] ?? date('m');
$year = $_GET['year'] ?? date('Y');

$query = mysqli_query($db, "
    SELECT 
        uc.*,
        dishes.title,
        res.rs_id, res.title as rs_title,
        users.username
    FROM users_claims as uc 
    JOIN users ON users.u_id = uc.u_id
    JOIN dishes ON uc.d_id = dishes.d_id
    JOIN restaurant as res ON dishes.rs_id = res.rs_id
    WHERE MONTH(uc.date) = '$month' AND YEAR(uc.date) = '$year'
    ORDER BY status DESC
");
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Monthly User Claims Report - <?= $month ?>/<?= $year ?></h2>
        <button onclick="window.print()" class="btn btn-secondary">
            <i class="fa fa-print"></i> Print Report
        </button>
    </div>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="month" class="form-label">Month</label>
            <select name="month" id="month" class="form-select">
                <?php
                for ($m = 1; $m <= 12; $m++) {
                    $selected = ($m == $month) ? "selected" : "";
                    echo "<option value='$m' $selected>" . date("F", mktime(0, 0, 0, $m, 1)) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="year" class="form-label">Year</label>
            <select name="year" id="year" class="form-select">
                <?php
                for ($y = date('Y'); $y >= 2020; $y--) {
                    $selected = ($y == $year) ? "selected" : "";
                    echo "<option value='$y' $selected>$y</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa fa-search"></i> Filter
            </button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Restaurant</th>
                    <th>Dish</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>
                        <td>{$i}</td>
                        <td>" . htmlspecialchars($row['username']) . "</td>
                        <td>" . htmlspecialchars($row['rs_title']) . "</td>
                        <td>" . htmlspecialchars($row['title']) . "</td>
                        <td>" . htmlspecialchars($row['quantity']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>" . htmlspecialchars($row['date']) . "</td>
                    </tr>";
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    @media print {
    nav, .navbar, header, .sidebar, .topbar {
        display: none !important;
    }
    button, form {
        display: none !important;
    }
    h2 {
        text-align: center;
    }
    table {
        border-collapse: collapse !important;
    }
}

</style>

<?php include 'parts/end.php'; ?>
