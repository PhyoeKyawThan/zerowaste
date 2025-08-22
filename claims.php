<?php
include "connection/connect.php";
include 'parts/start.php';
?>

<div class="page-wrapper">
    <section class="restaurants-page p-2">
        <div class="container">
            <h2 class="mb-4">အော်ဒါ၏ အသေးစိတ်အချက်အလက်များ</h2>

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
                            <th class="text-primary">ဆိုင်နာမည်</th>
                            <th class="text-primary">အစားအသောက်</th>
                            <th class="text-primary">အရေအတွက်</th>
                            <th class="text-primary">အော်ဒါ အခြေအနေ </th>
                            <th class="text-primary">အော်ဒါလာယူရန်အချိန်</th>
                            <th class="text-primary d-none d-md-table-cell">ရက်စွဲ</th>
                            <th class="text-primary d-none d-lg-table-cell">ဆိုင် လိပ်စာ </th>
                            <th class="text-primary">ဆိုင်မှ လုပ်ဆောင်ချက်</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_res = mysqli_query($db, "SELECT dishes.title, users_claims.*, restaurant.title as res_title,
                        restaurant.address,
                        remark.remark
                        FROM users_claims JOIN dishes ON dishes.d_id = users_claims.d_id 
                        JOIN restaurant ON dishes.rs_id = restaurant.rs_id 
                        LEFT JOIN remark ON remark.users_claims_id = users_claims.id
                        WHERE u_id = '" . $_SESSION['user_id'] . "' ORDER BY users_claims.id DESC");
                        if (mysqli_num_rows($query_res) == 0) {
                            echo '<tr><td colspan="8" class="text-center">သင့်တွင် အော်ဒါများ မတင်ရသေးပါ။</td></tr>';
                        } else {
                            while ($row = mysqli_fetch_assoc($query_res)) {
                                $status = $row['status'];
                                $statusBtn = '';
                                if ($status == "Pending" || $status == null) {
                                    $statusBtn = '<span class="badge p-1 rounded bg-warning text-white" style="display: block; width: 150px;"><i class="fa fa-cog fa-spin"></i> စောင့်ဆိုင်းဆဲ</span>';
                                } elseif ($status == "Approved") {
                                    $statusBtn = '<span class="badge p-1 rounded bg-primary text-white" style="display: block; width: 150px;"><i class="fa fa-check-circle"></i> အတည်ပြုပြီး</span>';
                                } elseif ($status == 'Finished') {
                                    $statusBtn = '<span class="badge p-1 rounded bg-success text-white" style="display: block; width: 150px;"><i class="fa fa-check-circle"></i> Finished</span>';
                                } elseif ($status == "Rejected") {
                                    $statusBtn = '<span class="badge p-1 rounded bg-danger text-white" style="display: block; width: 150px;"><i class="fa fa-close"></i> မအောင်မြင်ပါ</span>';
                                }

                                $remark = $row['remark'] ?? 'Not viewd yet';
                                echo '<tr>
                                    <td data-label="Restaurant">' . htmlspecialchars($row['res_title']) . '</td>
                                    <td data-label="Item">' . htmlspecialchars($row['title']) . '</td>
                                    <td data-label="Qty">' . intval($row['quantity']) . '</td>
                                    <td class="p-2" data-label="Status">' . $statusBtn . '</td>
                                    
                                    <td data-label="Pickup">' . htmlspecialchars($row['pickup_period'] ? 'Within ' . $row['pickup_period'] . ' Minutes' : ' - ') . '</td>
                                    <td class="d-none d-md-table-cell" data-label="Date">' . htmlspecialchars($row['date']) . '</td>
                                    <td class="d-none d-lg-table-cell" data-label="Restaurant Address">' . htmlspecialchars($row['address']) . '</td>
                                    <td data-label="Actions">
                                        <button type="button" class="btn-primary" onclick="openModal('.$row['id'].')">
                                            <i class="fas fa-comment"></i> Message
                                        </button>
                                        <div class="modal-backdrop" id="userMessageModal-'.$row['id'].'">
                                            <div class="modal-box">
                                              <div class="modal-header">
                                                <h5 class="text-white"><i class="fas fa-comment-dots"></i> User Message</h5>
                                               <!--<button class="close-btn" onclick="closeModal()">&times;</button>-->
                                              </div>
                                              <div class="modal-body">
                                                ' . $remark . '
                                              </div>
                                              <div class="modal-footer">
                                                <button class="btn-secondary" onclick="closeModal('.$row['id'].')">OK</button>
                                              </div>
                                            </div>
                                        </div>
                                        <a href="claims.php?action=delete&id=' . intval($row['id']) . '" onclick="return confirm(\'သင့်မှာယူမှုကို ပယ်ဖျက်လိုသည်မှာ သေချာပါသလား?\');" class="btn btn-danger rounded">
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
<script>
    function openModal(id) {
        document.getElementById(`userMessageModal-${id}`).classList.add('active');
    }

    function closeModal(id) {
        document.getElementById(`userMessageModal-${id}`).classList.remove('active');
    }

    // document.getElementById('userMessageModal').addEventListener('click', function (e) {
    //     if (e.target === this) closeModal();
    // });
</script>
<style>
    .modal-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        justify-content: center;
        align-items: center;
    }

    .modal-backdrop.active {
        display: flex;
    }

    .modal-box {
        background: #fff;
        width: 400px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        background-color: #007bff;
        color: white;
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h5 {
        margin: 0;
        font-size: 18px;
    }

    .modal-header .close-btn {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
    }

    .modal-body {
        padding: 16px;
        font-size: 16px;
    }

    .modal-footer {
        padding: 12px 16px;
        text-align: right;
    }

    .modal-footer .btn-secondary {
        background-color: #6c757d;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

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

        .modal-box {
            margin: auto;
            width: 90%;
            max-width: 100%;
            border-radius: 6px;
        }

        .modal-body {
            padding: 12px;
            font-size: 15px;
        }

        .modal-footer {
            padding: 10px 12px;
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