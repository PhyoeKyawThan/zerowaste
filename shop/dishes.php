<div class="">
    <div class="row">
        <div class="col-12">
            <div class="col-lg-12">
                <div class="card">
                    <div class="dish-head">
                        <h3 class="dish-title">Dishes</h3>
                        <form action="" method="get" class="dish-search">
                            <input type="search" name="search" id="search" placeholder="Search..."
                                class="search-input" />
                        </form>

                        <a href="shop.php?p=ad" class="btn btn-primary add-dish-btn">
                            <i class="fas fa-plus"></i> Add New Dish
                        </a>
                    </div>

                    <div class="table-responsive m-t-40">
                        <div class="dish-cards">
                            <?php
                            if (isset($_GET['dd'])) {
                                $dID = (int) $_GET['dd'] ?? die("Required id");
                                $del_query = mysqli_prepare($db, "DELETE FROM dishes WHERE d_id = ?");
                                mysqli_stmt_bind_param($del_query, 'i', $dID);
                                $select_del_query = mysqli_prepare($db, "SELECT * FROM dishes WHERE d_id = ?");
                                mysqli_stmt_bind_param($select_del_query, 'i', $dID);
                                mysqli_execute($select_del_query);
                                $select_del_data = mysqli_fetch_assoc($select_del_query->get_result());
                                unlink(__DIR__ . '/../uploads/dishes/' . $select_del_data['img'] . '');
                                if (mysqli_execute($del_query)) {
                                    echo "<script>alert('Successfully Deleted');</script>";
                                }
                            }

                            $sql = "SELECT * FROM dishes WHERE rs_id = ? ORDER BY d_id DESC";
                            $query = mysqli_prepare($db, $sql);
                            mysqli_stmt_bind_param($query, 'i', $_SESSION['rs_id']);
                            mysqli_execute($query);
                            $query = $query->get_result();
                            if (!mysqli_num_rows($query) > 0) {
                                echo '<p class="no-data">No Menu</p>';
                            } else {
                                while ($rows = mysqli_fetch_array($query)) {
                                    $status_class = $rows['status'] == 'Pending' ? 'warning text-dark' : ($rows['status'] == 'Approved' ? 'success' : 'danger');
                                    echo '<div class="dish-card">
                                    <img src="/zerowaste/uploads/dishes/' . $rows['img'] . '" alt="' . htmlspecialchars($rows['title']) . '" class="dish-image" />
                                    <div class="dish-info">
                                        <h3 class="dish-title">' . htmlspecialchars($rows['title']) . '</h3>
                                        <p class="dish-description">' . htmlspecialchars($rows['slogan']) . '</p>
                                        <p class="dish-stock"><strong>Stock:</strong> ' . $rows['stock'] . '</p>
                                        <p><strong>Admin Approval Status: </strong><span class="badge bg-'.$status_class.' text-white rounded" style="padding: 4px 10px;">'.$rows['status'].'</span></p>
                                        <div class="dish-actions">
                                            <a href="shop.php?p=ed&d_id=' . $rows['d_id'] . '" class="btn btn-edit"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="shop.php?p=dishes&dd=' . $rows['d_id'] . '" class="btn btn-delete" onclick="return confirm(\'Are you sure you want to delete this dish?\')"><i class="fa fa-trash-o"></i> Delete</a>
                                        </div>
                                    </div>
                                    </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .dish-head {
        background-color: #f5f7fa;
        padding: 1rem;
        border-radius: 8px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .dish-title {
        flex: 1 1 100%;
        font-size: 1.5rem;
        margin: 0;
        color: #333;
        font-weight: 600;
    }

    .dish-search {
        flex: 1;
        max-width: 300px;
    }

    .search-input {
        width: 100%;
        padding: 8px 12px;
        background-color: #e9ecef;
        border: none;
        border-radius: 5px;
        color: #333;
    }

    .add-dish-btn {
        white-space: nowrap;
        padding: 10px 12px;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .dish-head {
            flex-direction: column;
            align-items: stretch;
        }

        .dish-title {
            text-align: center;
        }

        .dish-search,
        .add-dish-btn {
            width: 100%;
            text-align: center;
        }
    }


    .dish-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        padding: 1rem;
    }

    .dish-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease;
    }

    .dish-card:hover {
        transform: translateY(-5px);
    }

    .dish-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }

    .dish-info {
        padding: 1rem;
    }

    .dish-title {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .dish-description {
        color: #555;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .dish-stock {
        font-weight: bold;
        color: #333;
        margin-bottom: 1rem;
    }

    .dish-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.4rem 0.75rem;
        border: none;
        border-radius: 5px;
        color: white;
        font-size: 0.875rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn i {
        margin-right: 5px;
    }

    .btn-edit {
        background-color: #0d6efd;
    }

    .btn-delete {
        background-color: #dc3545;
    }

    .no-data {
        text-align: center;
        padding: 2rem;
        font-size: 1.2rem;
        color: #777;
    }
</style>