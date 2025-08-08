<?php
include 'parts/start.php';
if (isset($_GET['res_id'])) {
    include 'v/view_restaurant.php';
} else {
    $query = mysqli_query($db, "SELECT users.*, res.rs_id  FROM users LEFT JOIN restaurant as res ON res.user_id = users.u_id");
    if (isset($_GET['s'])) {
        $search = mysqli_real_escape_string($db, $_GET['s']);
        $query = mysqli_query($db, "
                    SELECT * FROM users
                    WHERE username LIKE '%$search%' 
                    OR f_name LIKE '%$search%' 
                    OR l_name LIKE '%$search%' 
                    ORDER BY u_id DESC
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
            <h2 class="text-primary"><i class="fas fa-user"></i> Users</h2>
            <hr>
            <form action="" method="get" class="form">
                <input type="search" name="s" id="" class="form-control mb-1" placeholder="Search User">
            </form>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Firstname</th>
                            <th scope="col">Lastname</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Role</th>
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
                            echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['f_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['l_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                            $role = $row['role'] == 'shop' ?
                             isset($row['rs_id']) ?
                              '<a class="badge bg-primary rounded-pill text-decoration-none" href="restaurants.php?res_id='.$row['rs_id'].'&from=users.php">'.htmlspecialchars($row['role']).'</a>'
                              : '<span class="badge bg-secondary rounded-pill">'.$row['role'].'</span>'
                             : '<span class="badge bg-primary rounded-pill">'.$row['role'].'</span>';
                            echo '<td>' . $role .'</td>';
                            echo '<td>' . htmlspecialchars($row['date']) . '</td>';
                            echo '<td>';
                            echo '<div class="d-flex gap-2">';
                            $status_class = $row['account_status'] == 'Pending' ? 'warning text-dark' : 'success';
                            $pend_selected = $row['account_status'] == 'Pending' ? 'selected' : '';
                            $approv_selected = $row['account_status'] == 'Approved' ? 'selected' : '';
                            echo '<select class="badge bg-'.$status_class.'  rounded" onchange="changeStatus(event, '.$row['u_id'].')">
                                <option value="Pending" '.$pend_selected.'>Pending</option>
                                <option value="Approved" '.$approv_selected.'>Approved</option>
                            </select>';
                            echo '<a href="'.$_SERVER['REQUEST_URI'].'?del=' . $row['u_id'] . '" class="btn btn-danger btn-sm fw-bold" onclick="return confirm(`Are you sure to delete?`)">'
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
        <script>
            async function changeStatus(e, u_id){
                const response = await fetch(`/zerowaste/admin/actions/change_status.php?status=${e.target.value}&id=${u_id}`,
                    {
                        method: "POST"
                    }
                );
                const response_ = await response.json();
                if(response_.status){
                    window.location.href = "<?= $_SERVER['REQUEST_URI'] ?>";
                }
            }
        </script>
        <?php
    }
}
include 'parts/end.php'; ?>