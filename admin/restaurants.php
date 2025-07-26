<?php
include 'parts/start.php';
if (isset($_GET['res_id'])) {
    include 'v/view_restaurant.php';
} else {
    $query = mysqli_query($db, "SELECT restaurant.*, res_category.c_name FROM restaurant JOIN res_category ON res_category.c_id = restaurant.c_id ORDER BY rs_id DESC");
    if (isset($_GET['s'])) {
        $search = mysqli_real_escape_string($db, $_GET['s']);
        $query = mysqli_query($db, "
                    SELECT restaurant.*, res_category.c_name 
                    FROM restaurant 
                    JOIN res_category ON res_category.c_id = restaurant.c_id 
                    WHERE restaurant.title LIKE '%$search%' 
                       OR res_category.c_name LIKE '%$search%' 
                    ORDER BY restaurant.rs_id DESC
                    ");
    }
    if (isset($_GET['del'])) {
        $id = (int) $_GET['del'];
        $result = mysqli_prepare($db, "DELETE FROM restaurant WHERE rs_id = ?");
        $result->bind_param('i', $id);
        mysqli_execute($result);
        header("Location: restaurants.php");
        exit();
    } else {
        ?>
        <div class="container">
            <h2 class="mb-4 bg-primary p-2 text-white rounded">Restaurants</h2>
            <form action="" method="get" class="form">
                <input type="search" name="s" id="" class="form-control mb-1" placeholder="Search Restaurant">
            </form>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Category</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Url</th>
                            <!-- <th scope="col">Open Hrs</th> -->
                            <!-- <th scope="col">Close Hrs</th> -->
                            <th scope="col">Open Days</th>
                            <!-- <th scope="col">Address</th> -->
                            <th scope="col">Dishes</th>
                            <th scope="col">Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo '<tr>';
                            echo '<th scope="row">' . $i++ . '</th>';
                            echo '<td>' . htmlspecialchars($row['c_name']) . '</td>';
                            echo '<td><img src="/zerowaste/uploads/' . htmlspecialchars($row['image']) . '" alt="image" width="50"></td>';
                            echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['url']) . '</td>';
                            // echo '<td>' . htmlspecialchars($row['o_hr']) . '</td>';
                            // echo '<td>' . htmlspecialchars($row['c_hr']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['o_days']) . '</td>';
                            // echo '<td>' . htmlspecialchars($row['address']) . '</td>';
                

                            $dish_q = mysqli_query($db, "SELECT COUNT(*) AS total FROM dishes WHERE rs_id = " . intval($row['rs_id']));
                            $dish_count = mysqli_fetch_assoc($dish_q)['total'];

                            echo '<td>' . $dish_count . '</td>';
                            echo '<td>' . htmlspecialchars($row['date']) . '</td>';
                            echo '<td>';
                            echo '<div class="d-flex gap-2">';
                            echo '<a href="/zerowaste/admin/restaurants.php?res_id=' . $row['rs_id'] . '" class="btn btn-secondary btn-sm fw-bold">'
                                . '<i class="fas fa-eye"></i> View</a>';
                            echo '<a href="/zerowaste/admin/restaurants.php?del=' . $row['rs_id'] . '" class="btn btn-danger btn-sm fw-bold">'
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