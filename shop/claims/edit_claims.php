<div class="page-wrapper w-100">
    <div class="container-fluid w-100">
        <div class="row justify-content-center w-100">
            <div class="col-lg-8 w-100">
                <div class="card shadow-sm" style="margin: auto; width: 75vw;">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0 text-white">အော်ဒါ အသေးစိတ်</h4>
                    </div>
                    
                    <div class="card-body">
                        <?php
                        $sql = "SELECT users.*, users_claims.* , dishes.title, dishes.stock, dishes.price, dishes.discount
                                FROM users 
                                INNER JOIN users_claims ON users.u_id = users_claims.u_id JOIN dishes ON dishes.d_id = users_claims.d_id
                                WHERE id='".mysqli_real_escape_string($db, $_GET['id'])."'";
                        $query = mysqli_query($db, $sql);
                        $row = mysqli_fetch_array($query);
                        
                        if (!$row) {
                            echo '<div class="alert alert-warning">အော်ဒါမှာယူမှု မတွေ့ပါ။</div>';
                        } else {
                        ?>
                        
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th width="30%">အကောင့်အမည် :</th>
                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                                        <td class="text-end">
                                            <?php if($row['status'] != 'rejected'): ?>
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    onclick="popUpWindow('shop/claims/forms/update_form.php?id=<?= $row['id'] ?>&qty=<?= $row['quantity'] ?>&d_id=<?= $row['d_id'] ?>')">
                                                <i class="fas fa-edit"></i> အော်ဒါအခြေအနေ ပြင်မည်
                                            </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th>အစားအသောက်စာရင်း : </th>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-info btn-sm" 
                                                    onclick="popUpWindow('shop/claims/forms/claim_user.php?id=<?php echo htmlentities($row['id']); ?>')">
                                                <i class="fas fa-user"></i> စားသုံးသူကို ကြည့်မည်
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th>အရေအတွက် :</th>
                                        <td colspan="2"><?php echo intval($row['quantity']); ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <th>ရနိုင်သော လက်ကျန်စာရင်း : </th>
                                        <td colspan="2"><?php echo $row['stock'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>စျေးနှုန်း : </th>
                                        <td colspan="2"><?php echo $row['price'] ?></td>
                                    </tr>
                                    <?php if($row['discount'] > 0): ?>
                                    <tr>
                                        <th>လျှော့စျေး : </th>
                                        <td colspan="2"><?php echo $row['discount'] ?>%</td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <th>စုစုပေါင်း စျေးနှုန်း : </th>
                                        <td colspan="2"><?php
                                        $price = $row["price"] - ($row["price"] * ($row["discount"] / 100));
                                        echo $price * $row['quantity'] ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <th>လိပ်စာ :</th>
                                        <td colspan="2"><?php echo htmlspecialchars($row['address']); ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <th>အော်ဒါမှာသောရက်စွဲ :</th>
                                        <td colspan="2"><?php echo htmlspecialchars($row['date']); ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <th>မှာယူမှု အခြေအနေ:</th>
                                        <td colspan="2">
                                            <?php 
                                            $status = $row['status'];
                                            if($status == "Pending") {
                                                echo '<span class="badge bg-warning"><i class="fas fa-truck"></i> စောင့်ဆိုင်းဆဲ</span>';
                                            } elseif($status == "Approved") {
                                                echo '<span class="badge bg-success text-white"><i class="fas fa-check-circle"></i> အတည်ပြုပြီး</span>';
                                            } elseif($status == "Rejected") {
                                                echo '<span class="badge bg-danger text-white"><i class="fas fa-times"></i> မအောင်မြင်ပါ</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <?php } ?>
                    </div>
                    
                    <div class="card-footer text-end">
                        <a href="shop.php?p=claims" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 10px;
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
        padding: 1.25rem;
    }
    
    .table-borderless tbody tr td,
    .table-borderless tbody tr th {
        border: none;
        padding: 0.75rem 0.5rem;
        vertical-align: middle;
    }
    
    .table-borderless tbody tr:not(:last-child) {
        border-bottom: 1px solid #eee;
    }
    
    .badge {
        padding: 0.5em 0.75em;
        font-size: 0.9em;
        font-weight: 500;
    }
</style>

<script>
function popUpWindow(url) {
    var w = window.open(url, "_blank", "width=800,height=600,scrollbars=yes");
    w.focus();
}
</script>