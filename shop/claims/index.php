<?php
$msg = null;
$err = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
        include 'edit_claims.php';
} else {
    if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        $qry_str = "DELETE FROM users_claims WHERE id = ?";
        $del_stmt = mysqli_prepare($db, $qry_str);
        $del_stmt->bind_param('i', $_GET['id']);
        if (mysqli_execute($del_stmt)) {
            $msg = "Item Deleted";
        } else {
            $err = "Error while deleting item";
        }
    }
    ?>
    <div class="table-responsive m-t-40">
        <div class="align-center text-danger text-muted h3" style="width: fit-content; margin: auto;"><?= $msg ?></div>
        <table id="myTable" class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>User</th>
                    <th>Claim Dish</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Reg-Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT users_claims.id as claim_id, 
            users.username, users.address, dishes.title, users_claims.quantity, users_claims.status,
            users_claims.date
            FROM users_claims 
            JOIN dishes ON dishes.d_id = users_claims.d_id 
            JOIN users ON users.u_id = users_claims.u_id WHERE dishes.rs_id = ?";
                $query = mysqli_prepare($db, $sql);
                mysqli_stmt_bind_param($query, 'i', $_SESSION['rs_id']);
                mysqli_execute($query);
                $query = $query->get_result();
                if (!mysqli_num_rows($query) > 0) {
                    echo '<td colspan="8"><center>No Orders</center></td>';
                } else {
                    $no = 0;
                    while ($rows = mysqli_fetch_array($query)) {
                        $no += 1;
                        echo '<tr>
                        <td>' . $no . '</td>
                        <td>' . $rows['username'] . '</td>
                        <td>' . $rows['title'] . '</td>
                        <td>' . $rows['quantity'] . '</td>';
                        $status = $rows['status'];

                        if ($status == "" || $status == "NULL") {
                            echo '<td><button type="button" class="btn btn-info"><span class="fa fa-bars"></span> Dispatch</button></td>';
                        } elseif ($status == "in process") {
                            echo '<td><button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin"></span> On The Way!</button></td>';
                        } elseif ($status == "closed") {
                            echo '<td><button type="button" class="btn btn-primary"><span class="fa fa-check-circle"></span> Delivered</button></td>';
                        } elseif ($status == "rejected") {
                            echo '<td><button type="button" class="btn btn-danger"><i class="fa fa-close"></i> Cancelled</button></td>';
                        }

                        echo '<td>' . $rows['date'] . '</td>
                        <td>
                            <a href="' . $_SERVER['REQUEST_URI'] . '&action=delete&id=' . $rows['claim_id'] . '" onclick="return confirm(\'Are you sure?\');" class="btn btn-danger rounded"><i class="fa fa-trash-o"></i></a>
                            <a href="' . $_SERVER['REQUEST_URI'] . '&action=edit&id=' . $rows['claim_id'] . '" class="btn btn-info rounded m-l-5"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
<?php } ?>