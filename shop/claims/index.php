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

    if(isset($_GET['action']) && $_GET['action'] == 'make_finished'){
        $id = $_GET['id'];
        mysqli_query($db, "UPDATE users_claims SET status = 'Finished' WHERE id = $id");
    }

    $status_filter = isset($_GET['status']) && $_GET['status'] !== '' ? $_GET['status'] : null;
    $date_filter   = isset($_GET['date']) && $_GET['date'] !== '' ? $_GET['date'] : null;
    ?>
    
    <div id="filter-form" class="mb-3 pt-2 pl-2">
        <form method="get" class="form-inline">
            <input type="hidden" name="p" value="<?= $_GET['p'] ?? '' ?>"> 
            
            <div class="form-group mr-2">
                <label for="date" class="mr-2">Date:</label>
                <input type="date" id="date" name="date" value="<?= htmlspecialchars($date_filter) ?>" class="form-control">
            </div>
            
            <div class="form-group mr-2">
                <label for="status" class="mr-2">Status:</label>
                <select id="status" name="status" class="form-control">
                    <option value="">-- All --</option>
                    <option value="Pending"   <?= $status_filter=="Pending" ? "selected" : "" ?>>Pending</option>
                    <option value="Approved"  <?= $status_filter=="Approved" ? "selected" : "" ?>>Approved</option>
                    <option value="Finished"  <?= $status_filter=="Finished" ? "selected" : "" ?>>Finished</option>
                    <option value="Rejected"  <?= $status_filter=="Rejected" ? "selected" : "" ?>>Rejected</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="?p=<?= $_GET['p'] ?? '' ?>" class="btn btn-secondary ml-2">Reset</a>
        </form>
    </div>

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
                        users.username, users.address, dishes.title, 
                        users_claims.quantity, users_claims.status,
                        users_claims.date
                        FROM users_claims 
                        JOIN dishes ON dishes.d_id = users_claims.d_id 
                        JOIN users ON users.u_id = users_claims.u_id 
                        WHERE dishes.rs_id = ?";

                $params = [$_SESSION['rs_id']];
                $types  = "i";

                if ($status_filter) {
                    $sql .= " AND users_claims.status = ?";
                    $params[] = $status_filter;
                    $types .= "s";
                }
                if ($date_filter) {
                    $sql .= " AND DATE(users_claims.date) = ?";
                    $params[] = $date_filter;
                    $types .= "s";
                }

                $sql .= " ORDER BY users_claims.id DESC";

                $query = mysqli_prepare($db, $sql);
                mysqli_stmt_bind_param($query, $types, ...$params);
                mysqli_execute($query);
                $result = $query->get_result();

                if ($result->num_rows === 0) {
                    echo '<td colspan="7"><center>No Orders</center></td>';
                } else {
                    $no = 0;
                    while ($rows = $result->fetch_assoc()) {
                        $no++;
                        echo '<tr>
                            <td>' . $no . '</td>
                            <td>' . $rows['username'] . '</td>
                            <td>' . $rows['title'] . '</td>
                            <td>' . $rows['quantity'] . '</td>';

                        $status = $rows['status'];
                        $c_status = $rows['status'] == 'Approved' ? 'Waiting' : 'Finished';
                        $make_finished = '<a href="?p=claims&action=make_finished&id='.$rows['claim_id'].'" class="btn btn-success rounded ml-2"> '.$c_status.'</a>';
                        if ($status == "Pending") {
                            echo '<td><button class="btn btn-warning"><span class="fa fa-cog fa-spin"></span> Pending</button></td>';
                        } elseif ($status == "Approved") {
                            echo '<td><button class="btn btn-primary"><span class="fa fa-check-circle"></span> Approved</button></td>';
                        } elseif ($status == "Finished") {
                            echo '<td><button class="btn btn-success"><span class="fa fa-check-circle"></span> Finished</button></td>';
                        } elseif ($status == "Rejected") {
                            echo '<td><button class="btn btn-danger"><i class="fa fa-close"></i> Rejected</button></td>';
                        }

                        echo '<td>' . $rows['date'] . '</td>
                        <td>
                            <a href="' . $_SERVER['REQUEST_URI'] . '&action=delete&id=' . $rows['claim_id'] . '" onclick="return confirm(\'Are you sure?\');" class="btn btn-danger rounded"><i class="fa fa-trash-o"></i></a>
                            <a href="' . $_SERVER['REQUEST_URI'] . '&action=edit&id=' . $rows['claim_id'] . '" class="btn btn-info rounded m-l-5"><i class="fa fa-edit"></i></a>';
                            if($status != "Pending" && $status != "Rejected"){
                                echo $make_finished;
                            }
                    echo '</td>
                    </tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
<?php } ?>
