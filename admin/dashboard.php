<?php
include 'parts/start.php';
// echo md5('admin@123');
?>
<h2 class="text-primary"><i class="fa fa-tachometer-alt me-2"></i> Admin Dashboard</h2>
<hr>

<div class="row g-4 mb-4 justify-content-center">
    <div class="col-md-6">
        <div class="card p-3 shadow-sm border-0 h-100">
            <h5 class="mb-3 text-primary text-center">Claims Status</h5>
            <div class="d-flex justify-content-center align-items-center h-100">
                <canvas id="claimsPieChart" style="max-width: 400px;"></canvas>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row g-4">
    <?php
    $cards = [
        [
            'title' => 'Restaurants',
            'icon' => 'fa-home',
            'query' => 'SELECT * FROM restaurant',
            'link' => 'restaurants.php'
        ],
        [
            'title' => 'Dishes',
            'icon' => 'fa-utensils',
            'query' => 'SELECT * FROM dishes',
            'link' => 'all_dishes.php'
        ],
        [
            'title' => 'Users',
            'icon' => 'fa-users',
            'query' => 'SELECT * FROM users',
            'link' => 'users.php'
        ],
        [
            'title' => 'Food Categories',
            'icon' => 'fa-th-large',
            'query' => 'SELECT * FROM res_category'
        ],
        [
            'title' => 'Delivered Orders',
            'icon' => 'fa-check',
            'query' => "SELECT * FROM users_claims WHERE status = 'Delivered'"
        ],
        [
            'title' => 'Cancelled Orders',
            'icon' => 'fa-times',
            'query' => "SELECT * FROM users_claims WHERE status = 'Rejected'"
        ],
        [
            'title' => 'Pending Orders',
            'icon' => 'fa-spinner',
            'query' => "SELECT * FROM users_claims WHERE status = 'Pending'"
        ],
    ];

    foreach ($cards as $card) {
        $result = mysqli_query($db, $card['query']);
        $count = mysqli_num_rows($result);
        echo "<div class='col-md-4 col-sm-6'>
                <div class='card p-3 dashboard-card shadow-sm border-0 h-100'>
                    <div class='d-flex align-items-center'>
                        <div class='icon-circle bg-primary text-white me-3'>
                            <i class='fa {$card['icon']} fa-lg'></i>
                        </div>
                        <div>
                            <h4 class='mb-1 text-left fw-bold'>{$count}</h4>
                            <p class='mb-0 text-muted'>" . htmlspecialchars($card['title']) . "</p>
                        </div>
                    </div>" . (isset($card['link']) ? "<a href='{$card['link']}' class='stretched-link'></a>" : '') . "
                </div>
              </div>";
    }
    ?>
</div>

<?php

$open_claims_query = "SELECT COUNT(*) AS open_count FROM users_claims WHERE status = 'Pending'";
$closed_claims_query = "SELECT COUNT(*) AS closed_count FROM users_claims WHERE status = 'Delivered'";
$rejected_claims_query = "SELECT COUNT(*) AS rejected_count FROM users_claims WHERE status = 'Rejected'";

$open_result = mysqli_query($db, $open_claims_query);
$closed_result = mysqli_query($db, $closed_claims_query);
$rejected_result = mysqli_query($db, $rejected_claims_query);

$open_count = mysqli_fetch_assoc($open_result)['open_count'];
$closed_count = mysqli_fetch_assoc($closed_result)['closed_count'];
$rejected_count = mysqli_fetch_assoc($rejected_result)['rejected_count'];
?>

<script>
    const ctx = document.getElementById('claimsPieChart');
    const claimsData = {
        labels: ['Pending', 'Delivered', 'Rejected'],
        datasets: [{
            label: 'Claim Status',
            data: [<?php echo $open_count; ?>, <?php echo $closed_count; ?>, <?php echo $rejected_count; ?>],
            backgroundColor: [
                'rgba(255, 159, 64, 0.8)',
                'rgba(75, 192, 192, 0.8)', 
                'rgba(255, 99, 132, 0.8)'
            ],
            hoverBackgroundColor: [
                'rgba(255, 159, 64, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderColor: '#fff',
            borderWidth: 2
        }]
    };
    new Chart(ctx, {
        type: 'pie',
        data: claimsData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            let label = tooltipItem.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.raw;
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>

<?php
include 'parts/end.php';
?>
<style>
    /* Custom CSS for a cleaner, modern look */
    .dashboard-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .text-primary {
        color: #0d6efd !important; 
    }
    .text-muted {
        color: #6c757d !important;
    }
    h2, h4, h5 {
        font-family: 'Poppins', sans-serif;
    }
</style>