<?php
include "connection/connect.php";
include 'parts/start.php';
?>

<div class="page-wrapper">

    <section class="restaurants-page p-2">
        <div class="container">
            <h2 class="mb-4">My Claim Requests</h2>
            
            <table class="table table-bordered table-hover">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="text-primary">Item</th>
                        <th class="text-primary">Quantity</th>
                        <th class="text-primary">Status</th>
                        <th class="text-primary">Pickup Time</th>
                        <th class="text-primary">Date</th>
                        <th class="text-primary">Cancel Order</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $query_res = mysqli_query($db, "SELECT dishes.title, users_claims.* FROM users_claims JOIN dishes ON dishes.d_id = users_claims.d_id WHERE u_id = '" . $_SESSION['user_id'] . "'");
                    if (mysqli_num_rows($query_res) == 0) {
                        echo '<tr><td colspan="6" class="text-center">You have no orders placed yet.</td></tr>';
                    } else {
                        while ($row = mysqli_fetch_assoc($query_res)) {
                            $status = $row['status'];
                            $statusBtn = '';
                            if ($status == "" || $status == "NULL") {
                                $statusBtn = '<button class="btn btn-info"><i class="fa fa-bars"></i> Dispatch</button>';
                            } elseif ($status == "in process") {
                                $statusBtn = '<button class="btn btn-warning"><i class="fa fa-cog fa-spin"></i> On The Way!</button>';
                            } elseif ($status == "closed") {
                                $statusBtn = '<button class="btn btn-success"><i class="fa fa-check-circle"></i> Delivered</button>';
                            } elseif ($status == "rejected") {
                                $statusBtn = '<button class="btn btn-danger"><i class="fa fa-close"></i> Cancelled</button>';
                            }
                            echo '<tr>
                                <td>' . htmlspecialchars($row['title']) . '</td>
                                <td>' . intval($row['quantity']) . '</td>
                                <td>' . $statusBtn . '</td>
                                <td>' . htmlspecialchars($row['pickup_time']) . '</td>
                                <td>' . htmlspecialchars($row['date']) . '</td>
                                <td>
                                    <a href="delete_orders.php?order_del=' . intval($row['o_id']) . '" onclick="return confirm(\'Are you sure you want to cancel your order?\');" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

</div>

<?php include 'parts/end.php'; ?>