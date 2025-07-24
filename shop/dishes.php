<div class="">
    <div class="row">
        <div class="col-12">
            <div class="col-lg-12">
                <div class="card">
                    <div class="d-flex justify-content-end w-100"
                        style="display: flex;justify-content: end; align-items: center; padding: 10px">

                        <h3 class="m-b-0 text-black w-100">All Menu</h3>
                        <form action="" method="get" style="padding: 0 20px;">
                            <input type="search" class=""
                                style="border: none; background-color: #b7bdb8; padding: 8px 10px;" name="search"
                                id="search" placeholder="Search..">
                            <!-- <label for="search" style="border: none; background-color: #b7bdb8; padding: 8px 10px;"><i
                                    class="fas fa-search text-primary"></i></label> -->
                        </form>
                        <a href="shop.php?p=ad" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Dish
                        </a>
                    </div>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered"
                            cellspacing="0" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <!-- <th>Restaurant</th> -->
                                    <th>Dish</th>
                                    <th>Description</th>
                                    <th>Stocks</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_GET['dd'])) {
                                    $dID = (int) $_GET['dd'] ?? die("Required id");
                                    $del_query = mysqli_prepare($db, "DELETE FROM dishes WHERE d_id = ?");
                                    mysqli_stmt_bind_param($del_query, 'i', $dID);
                                    $select_del_query = mysqli_prepare($db, "SELECT * FROM dishes WHERE d_id = ?");
                                    mysqli_stmt_bind_param($select_del_query, 'i', $dID);
                                    mysqli_execute($select_del_query);
                                    $select_del_data = mysqli_fetch_assoc($select_del_query->get_result());
                                    unlink(__DIR__.'/../uploads/dishes/'.$select_del_data['img'].'');
                                    if (mysqli_execute($del_query)) {
                                        echo "<script>alert('Successfully Deleted');</script>";

                                    }
                                }
                                $sql = "SELECT * FROM dishes ORDER BY d_id DESC";
                                $query = mysqli_query($db, $sql);
                                if (!mysqli_num_rows($query) > 0) {
                                    echo '<tr><td colspan="6"><center>No Menu</center></td></tr>';
                                } else {
                                    while ($rows = mysqli_fetch_array($query)) {
                                        echo '<tr>
                                                <td>' . $rows['title'] . '</td>
                                                <td>' . $rows['slogan'] . '</td>
                                                <td>' . $rows['stock'] . '</td>
                                                <td>
                                                    <div class="col-md-3 col-lg-8 m-b-10">
                                                        <center><img src="/zerowaste/uploads/dishes/' . $rows['img'] . '" class="img-responsive radius" style="max-height:100px;max-width:150px;" /></center>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="shop.php?p=dishes&dd=' . $rows['d_id'] . '" class="btn btn-danger"><i class="fa fa-trash-o" style="font-size:16px"></i></a> 
                                                    <a href="shop.php?p=ed&d_id=' . $rows['d_id'] . '" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>