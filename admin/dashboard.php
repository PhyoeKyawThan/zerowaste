<?php
include 'parts/start.php';
?>
<h2 class="text-primary"><i class="fa fa-tachometer-alt me-2"></i> Admin Dashboard</h2>
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
            'query' => "SELECT * FROM users_claims WHERE status = 'closed'"
        ],
        [
            'title' => 'Cancelled Orders',
            'icon' => 'fa-times',
            'query' => "SELECT * FROM users_claims WHERE status = 'rejected'"
        ],
        [
            'title' => 'Scheduled Pickups',
            'icon' => 'fa-clock',
            'query' => "SELECT COUNT(*) AS total_pickups FROM users_claims WHERE pickup_time IS NOT NULL AND pickup_time != '00:00:00'",
            'is_count' => true
        ]
    ];

    foreach ($cards as $card) {
        $result = mysqli_query($db, $card['query']);
        $count = isset($card['is_count']) ? mysqli_fetch_assoc($result)['total_pickups'] : mysqli_num_rows($result);
        echo "<div class='col-md-4'>
                            <div class='card p-3 dashboard-card'>
                                <div class='d-flex align-items-center'>
                                    <i class='fa {$card['icon']} text-primary me-3'></i>
                                    <div>
                                        <h4 class='mb-1 text-left'>{$count}</h4>
                                        <p class='mb-0'>" . htmlspecialchars($card['title']) . "</p>
                                    </div>
                                </div>
                                " . (isset($card['link']) ? "<a href='{$card['link']}' class='stretched-link'></a>" : '') . "
                            </div>
                        </div>";
    }
    ?>
</div>
<?php
include 'parts/end.php';
?>