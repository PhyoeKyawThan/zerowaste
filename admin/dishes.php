<?php
include 'parts/start.php';
if(isset($_GET['dId'])){
    include 'v/view_dish.php';
}
else if (isset($_GET['res_id'])) {
    include 'v/view_restaurant.php';
} else {
    $query = mysqli_query($db, "SELECT ds.*, rs.title as rs_title, c.c_name FROM dishes as ds JOIN restaurant as rs ON rs.rs_id = ds.rs_id JOIN res_category as c ON c.c_id = rs.c_id ORDER BY d_id DESC");
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
    } else {
        ?>
        <div class="container">
            <h2 class="text-primary"><i class="fas fa-utensils"></i> Dishes From Restaurants</h2>
            <hr>
            <form action="" method="get" class="form">
                <input type="search" name="s" value="<?= $_GET['s'] ?? '' ?>" id="" class="form-control mb-1" placeholder="Search Dishes">
            </form>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Restaurant</th>
                            <th scope="col">Dish</th>
                            <th scope="col">Category</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Created</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo '<tr>';
                            echo '<th scope="row">' . $i++ . '</th>';
                            echo '<td>' . htmlspecialchars($row['rs_title']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['c_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['stock']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
                           
                            echo '<td>';
                            echo '<div class="d-flex gap-2">';
                            echo '<a href="dishes.php?dId=' . $row['d_id'] . '" class="btn btn-secondary btn-sm fw-bold">'
                                . '<i class="fas fa-eye"></i> View</a>';
                            echo '<a href="dishes.php?del=' . $row['d_id'] . '" class="btn btn-danger btn-sm fw-bold" onclick="return confirm(`Are you sure to delete?`)">'
                                . '<i class="fas fa-trash"></i> Delete</a>';
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
    }
}
include 'parts/end.php'; ?>