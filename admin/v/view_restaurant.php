<?php
$restaurant = [];
$sql = "SELECT restaurant.*, res_category.c_name FROM restaurant JOIN res_category ON res_category.c_id = restaurant.c_id WHERE rs_id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $_GET['res_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$restaurant = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

?>
<form action="" method="post" enctype="multipart/form-data" style="padding: 20px">
    <a href="/zerowaste/admin/restaurants.php" class="fas fa-arrow-left text-decoration-none fs-4"></a>
    <h3>Details</h3>
    <div class="form-body">
        <div class="row p-t-20">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Restaurant Name</label>
                    <input type="text" name="res_name" class="form-control" required
                        value="<?= htmlspecialchars($restaurant['title'] ?? '') ?>" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-danger">
                    <label class="control-label">Business E-mail</label>
                    <input type="email" name="email" class="form-control" required
                        value="<?= htmlspecialchars($restaurant['email'] ?? '') ?>" readonly>
                </div>
            </div>
        </div>

        <div class="row p-t-20">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Phone</label>
                    <input type="text" name="phone" class="form-control" required
                        value="<?= htmlspecialchars($restaurant['phone'] ?? '') ?>" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-danger">
                    <label class="control-label">Website URL</label>
                    <input type="text" name="url" class="form-control form-control-danger"
                        value="<?= htmlspecialchars($restaurant['url'] ?? '') ?>" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Open Hours</label>
                    <input type="text" class="form-control" value="<?= $restaurant['o_hr'] ?? '' ?>" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Close Hours</label>
                    <input type="text" class="form-control" value="<?= $restaurant['c_hr'] ?>" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Open Days</label>
                    <input type="text" class="form-control" value="<?= $restaurant['o_days'] ?>" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-danger">
                    <label class="d-block control-label">Image</label>
                    <?php if (!empty($restaurant['image'])): ?>
                        <img src="/zerowaste/uploads/<?= htmlspecialchars($restaurant['image']) ?>" alt="Current Image"
                            style="max-height:100px; margin-top:10px;" class="border border-2 rounded border-primary">
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Select Category</label>
                    <input type="text" class="form-control" value="<?= $restaurant['c_name'] ?>" readonly>
                </div>
            </div>
        </div>
        <h3 class="box-title m-t-40">Restaurant Address</h3>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <textarea name="address" style="height:100px;" class="form-control"
                        required readonly><?= htmlspecialchars($restaurant['address'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    </div>
</form>