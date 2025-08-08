<?php
include 'parts/start.php';

$query = mysqli_query($db, "SELECT 
                                    uc.*,
                                    dishes.title,
                                    res.rs_id, res.title as rs_title,
                                    users.username
                                    FROM users_claims as uc 
                                    JOIN users ON users.u_id = uc.u_id
                                    JOIN dishes ON uc.d_id = dishes.d_id
                                    JOIN restaurant as res ON dishes.rs_id = res.rs_id
                                    ORDER BY id DESC");
if (isset($_GET['s'])) {
    $search = mysqli_real_escape_string($db, $_GET['s']);
    $query = mysqli_query($db, "
                    SELECT ds.*, rs.title as rs_title,
                    c.c_name FROM dishes as ds 
                    JOIN restaurant as rs ON rs.rs_id = ds.rs_id 
                    JOIN res_category as c ON c.c_id = rs.c_id 
                    WHERE ds.title LIKE '%$search%' 
                    OR rs.title LIKE '%$search%' 
                    OR c.c_name LIKE '%$search%' 
                    ORDER BY d_id DESC
                    ");
}
if (isset($_GET['del'])) {
    $id = (int) $_GET['del'];
    $result = mysqli_prepare($db, "DELETE FROM users WHERE u_id = ?");
    $result->bind_param('i', $id);
    mysqli_execute($result);
    header("Location: users.php");
    exit();
} else { ?>
    <h2 class="text-primary">Users Claims</h2>
    <hr>

    <form action="" method="get" class="form">
        <input type="search" name="s" value="<?= $_GET['s'] ?? '' ?>" id="" class="form-control mb-1"
            placeholder="Search Dishes">
    </form>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User</th>
                    <th scope="col">Restaurant</th>
                    <th scope="col">Claimed Dish</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Status</th>
                    <th scope="col">Claimed Date</th>
                    <!-- <th scope="col">Actions</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                    echo '<tr>';
                    echo '<th scope="row">' . $i++ . '</th>';
                    echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                    echo '<td><a class="text-decoration-none" href="restaurants.php?res_id='.$row['rs_id'].'">' . htmlspecialchars($row['rs_title']) . '</a></td>';
                    echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
                    $status = $row['status'];

                    if ($status == "Pending") {
                        echo '<td><button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin"></span> Pending</button></td>';
                    } elseif ($status == "Delivered") {
                        echo '<td><button type="button" class="btn btn-primary"><span class="fa fa-check-circle"></span> Delivered</button></td>';
                    } elseif ($status == "Rejected") {
                        echo '<td><button type="button" class="btn btn-danger"><i class="fa fa-close"></i> Cancelled</button></td>';
                    }
                    echo '<td>' . htmlspecialchars($row['date']) . '</td>';
                    // echo '<td>';
                    // echo '<div class="d-flex gap-2">';
                    // echo '<a href="dishes.php?dId=' . $row['d_id'] . '" class="btn btn-secondary btn-sm fw-bold">'
                    //     . '<i class="fas fa-eye"></i> View</a>';
                    // echo '<a href="dishes.php?del=' . $row['d_id'] . '" class="btn btn-danger btn-sm fw-bold" onclick="return confirm(`Are you sure to delete?`)">'
                    //     . '<i class="fas fa-trash"></i> Delete</a>';
                    // echo '</div>';
                    // echo '</td>';
                    // echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
}
include 'parts/end.php';
?>