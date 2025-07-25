<?php
include "connection/connect.php";
include 'parts/start.php';
?>

<div class="page-wrapper">
    <section class="restaurants-page p-2">
        <div class="container">
            <h2 class="mb-4">My Claim Requests</h2>

            <div class="table-responsive">
                <?php

                $msg = null;
                if (isset($_GET['action']) && $_GET['action'] == 'delete') {
                    $delete = mysqli_query($db, "DELETE FROM users_claims WHERE id = " . mysqli_real_escape_string($db, $_GET['id']) . "");
                    if ($delete) {
                        $msg = "Deleted!";
                    }
                } ?>
                <div class="text-danger h3" style="width: fit-content; margin: auto"><?= $msg ?? '' ?></div>
                <table class="table table-bordered table-hover">
                    <thead class="bg-white text-white">
                        <tr>
                            <th class="text-primary">Restaurant</th>
                            <th class="text-primary">Item</th>
                            <th class="text-primary">Quantity</th>
                            <th class="text-primary">Status</th>
                            <th class="text-primary">Pickup Time</th>
                            <th class="text-primary d-none d-md-table-cell">Date</th>
                            <th class="text-primary d-none d-lg-table-cell">Restaurant Address</th>
                            <th class="text-primary">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_res = mysqli_query($db, "SELECT dishes.title, users_claims.*, restaurant.title as res_title,
                        restaurant.address
                        FROM users_claims JOIN dishes ON dishes.d_id = users_claims.d_id 
                        JOIN restaurant ON dishes.rs_id = restaurant.rs_id WHERE u_id = '" . $_SESSION['user_id'] . "' ORDER BY users_claims.id DESC");
                        if (mysqli_num_rows($query_res) == 0) {
                            echo '<tr><td colspan="8" class="text-center">You have no orders placed yet.</td></tr>';
                        } else {
                            while ($row = mysqli_fetch_assoc($query_res)) {
                                $status = $row['status'];
                                $statusBtn = '';
                                if ($status == "" || $status == "NULL") {
                                    $statusBtn = '<span class="badge p-1 rounded bg-info"><i class="fa fa-bars"></i> Dispatch</span>';
                                } elseif ($status == "in process") {
                                    $statusBtn = '<span class="badge p-1 rounded bg-warning"><i class="fa fa-cog fa-spin"></i> On The Way!</span>';
                                } elseif ($status == "closed") {
                                    $statusBtn = '<span class="badge p-1 rounded bg-success"><i class="fa fa-check-circle"></i> Delivered</span>';
                                } elseif ($status == "rejected") {
                                    $statusBtn = '<span class="badge p-1 rounded bg-danger"><i class="fa fa-close"></i> Cancelled</span>';
                                }
                                echo '<tr>
                                    <td data-label="Restaurant">' . htmlspecialchars($row['res_title']) . '</td>
                                    <td data-label="Item">' . htmlspecialchars($row['title']) . '</td>
                                    <td data-label="Qty">' . intval($row['quantity']) . '</td>
                                    <td class="p-2" data-label="Status">' . $statusBtn . '</td>
                                    
                                    <td data-label="Pickup">' . htmlspecialchars($row['pickup_time']) . '</td>
                                    <td class="d-none d-md-table-cell" data-label="Date">' . htmlspecialchars($row['date']) . '</td>
                                    <td class="d-none d-lg-table-cell" data-label="Restaurant Address">' . htmlspecialchars($row['address']) . '</td>
                                    <td data-label="Actions">
                                        <a href="claims.php?action=delete&id=' . intval($row['id']) . '" onclick="return confirm(\'Are you sure you want to cancel your order?\');" class="btn btn-danger btn-sm">
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
        </div>
    </section>
</div>

<style>
    @media (max-width: 768px) {
        .table-responsive {
            border: 0;
        }

        .table-responsive table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-responsive thead {
            display: none;
        }

        .table-responsive tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }

        .table-responsive td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            text-align: right;
            border-bottom: 1px solid #dee2e6;
        }

        .table-responsive td::before {
            content: attr(data-label);
            font-weight: bold;
            margin-right: 1rem;
            text-align: left;
        }

        .table-responsive td:last-child {
            border-bottom: 0;
        }

        .badge p-1 rounded {
            font-size: 0.875rem;
            padding: 0.35em 0.65em;
        }
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.03);
    }

    .bg-dark {
        background-color: #343a40 !important;
    }

    .text-primary {
        color: #007bff !important;
    }
</style>

<?php include 'parts/end.php'; ?>