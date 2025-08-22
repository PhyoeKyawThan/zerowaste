<?php
$msg = "";

$user_id = $_SESSION['user_id'] ?? 0;

$shop = [];
if ($user_id) {
    $sql = "SELECT * FROM restaurant WHERE user_id = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $shop = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $res_name = trim($_POST['res_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $url = trim($_POST['url']);
    $o_hr = trim($_POST['o_hr']);
    $c_hr = trim($_POST['c_hr']);
    $o_days = trim($_POST['o_days']);
    $c_name = trim($_POST['c_name']);
    $address = trim($_POST['address']);

    $upload_dir = __DIR__ . "/../uploads/";
    $new_image_name = $shop['image'] ?? ''; 
    if (!empty($_FILES['file']['name'])) {
        $file_name = basename($_FILES['file']['name']);
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($file_ext, $allowed_ext)) {
            $unique_name = uniqid("res_", true) . "." . $file_ext;
            $target_file = $upload_dir . $unique_name;

            if (move_uploaded_file($file_tmp, $target_file)) {
                if (!empty($shop['image']) && file_exists($upload_dir . $shop['image'])) {
                    unlink($upload_dir . $shop['image']);
                }
                $new_image_name = $unique_name;
            } else {
                $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Failed to upload the new image file.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            }
        } else {
            $msg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        Invalid image format. Only JPG, JPEG, PNG, GIF, WEBP allowed.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        }
    }

    if (!$msg && $res_name && $email && $phone && $c_name && $address) {
        if ($shop) {
            $query = "UPDATE restaurant SET title = ?, email = ?, phone = ?, url = ?, o_hr = ?, c_hr = ?, o_days = ?, image = ?, c_id = ?, address = ? WHERE user_id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param(
                $stmt,
                'ssssssssssi',
                $res_name,
                $email,
                $phone,
                $url,
                $o_hr,
                $c_hr,
                $o_days,
                $new_image_name,
                $c_name,
                $address,
                $user_id
            );

            if (mysqli_stmt_execute($stmt)) {
                $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            Restaurant updated successfully!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                $shop = array_merge($shop, [
                    'title' => $res_name,
                    'email' => $email,
                    'phone' => $phone,
                    'url' => $url,
                    'o_hr' => $o_hr,
                    'c_hr' => $c_hr,
                    'o_days' => $o_days,
                    'image' => $new_image_name,
                    'c_id' => $c_name,
                    'address' => $address,
                ]);
                $_SESSION['rs_name'] = $res_name;
            } else {
                $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Database error. Please try again later.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            }
            mysqli_stmt_close($stmt);
        } else {
            $msg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        No restaurant found for update.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        }
    } elseif (!$msg) {
        $msg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    Please fill in all required fields!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}

?>
<form action="" method="post" enctype="multipart/form-data" style="padding: 20px">
    <h3>Details</h3>
    <div class="form-body">
        <div class="row p-t-20">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">ဆိုင်နာမည်</label>
                    <input type="text" name="res_name" class="form-control" required
                        value="<?= htmlspecialchars($shop['title'] ?? '') ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-danger">
                    <label class="control-label">အီးမေးလ်လိပ်စာ</label>
                    <input type="email" name="email" class="form-control" required
                        value="<?= htmlspecialchars($shop['email'] ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="row p-t-20">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">ဖုန်းနံပါတ်</label>
                    <input type="text" name="phone" class="form-control" required
                        value="<?= htmlspecialchars($shop['phone'] ?? '') ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-danger">
                    <label class="control-label">Facebook စာမျက်နှာ</label>
                    <input type="text" name="url" class="form-control form-control-danger"
                        value="<?= htmlspecialchars($shop['url'] ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">ဆိုင်ဖွင့်ချိန်</label>
                    <select name="o_hr" class="form-control custom-select" required>
                        <option disabled <?= empty($shop['o_hr']) ? 'selected' : '' ?>>--ဆိုင်ဖွင့်ချိန်ကို ရွေးချယ်ပါ--</option>
                        <?php
                        $hours_open = ['6am', '7am', '8am', '9am', '10am', '11am', '12pm'];
                        foreach ($hours_open as $hour) {
                            $sel = ($shop['o_hr'] ?? '') === $hour ? 'selected' : '';
                            echo "<option value=\"$hour\" $sel>$hour</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">ဆိုင်ပိတ်ချိန်</label>
                    <select name="c_hr" class="form-control custom-select" required>
                        <option disabled <?= empty($shop['c_hr']) ? 'selected' : '' ?>>--ဆိုင်ပိတ်ချိန်ကို ရွေးချယ်ပါ--</option>
                        <?php
                        $hours_close = ['3pm', '4pm', '5pm', '6pm', '7pm', '8pm', '9pm', '10pm', '11pm', '12am', '1am', '2am', '3am'];
                        foreach ($hours_close as $hour) {
                            $sel = ($shop['c_hr'] ?? '') === $hour ? 'selected' : '';
                            echo "<option value=\"$hour\" $sel>$hour</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">ဆိုင်ဖွင့်ရက်များ</label>
                    <select name="o_days" class="form-control custom-select" required>
                        <option disabled <?= empty($shop['o_days']) ? 'selected' : '' ?>>--ဆိုင်ဖွင့်ရက်များကို ရွေးချယ်ပါ--</option>
                        <?php
                        $days_options = ['Mon-Tue', 'Mon-Wed', 'Mon-Thu', 'Mon-Fri', 'Mon-Sat', '24hr-x7'];
                        foreach ($days_options as $days) {
                            $sel = ($shop['o_days'] ?? '') === $days ? 'selected' : '';
                            echo "<option value=\"$days\" $sel>$days</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-danger">
                    <label class="control-label">ဓါတ်ပုံ</label>
                    <input type="file" name="file" class="form-control form-control-danger">
                    <?php if (!empty($shop['image'])): ?>
                        <img src="/zerowaste/uploads/<?= htmlspecialchars($shop['image']) ?>" alt="Current Image"
                            style="max-height:100px; margin-top:10px;">
                    <?php endif; ?>
                </div>
            </div>

           
        </div>
        <h3 class="box-title m-t-40">ဆိုင်လိပ်စာ</h3>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <textarea name="address" style="height:100px;" class="form-control"
                        required><?= htmlspecialchars($shop['address'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <input type="submit" name="submit" class="btn btn-primary" value="သိမ်းမည်">
    </div>
</form>