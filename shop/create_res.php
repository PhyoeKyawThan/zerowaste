<?php
$msg = ""; 

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
    $target_file = "";

    if (!empty($_FILES['file']['name'])) {
        $file_name = basename($_FILES['file']['name']);
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($file_ext, $allowed_ext)) {
            $unique_name = uniqid("res_", true) . "." . $file_ext;
            $target_file = $upload_dir . $unique_name;

            if (!move_uploaded_file($file_tmp, $target_file)) {
                $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Failed to upload the image file.
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
        $query = "INSERT INTO restaurant (title, email, phone, url, o_hr, c_hr, o_days, image, c_id, address, user_id) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);
        $img = basename($target_file);
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
            $img,
            $c_name,
            $address,
            $_SESSION['user_id']
        );

        if (mysqli_stmt_execute($stmt)) {
            $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        Restaurant added successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Database error. Please try again later.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        }

        mysqli_stmt_close($stmt);
    } elseif (!$msg) {
        $msg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    Please fill in all required fields!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}
?>

<div class="container mt-3">
    <?= $msg ?>
</div>


<form action="" method="post" enctype="multipart/form-data" style="padding: 20px">
    <div class="alert alert-warning d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <div>
            You must <strong>create a restaurant</strong> before continuing.
            <!-- <a href="add_restaurant.php" class="alert-link">Click here to add a restaurant.</a> -->
        </div>
    </div>

    <div class="form-body">
        <div class="row p-t-20">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Restaurant Name</label>
                    <input type="text" name="res_name" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-danger">
                    <label class="control-label">Business E-mail</label>
                    <input type="text" name="email" class="form-control form-control-danger">
                </div>
            </div>
        </div>

        <div class="row p-t-20">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-danger">
                    <label class="control-label">Website URL</label>
                    <input type="text" name="url" class="form-control form-control-danger">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Open Hours</label>
                    <select name="o_hr" class="form-control custom-select">
                        <option>--Select your Hours--</option>
                        <option value="6am">6am</option>
                        <option value="7am">7am</option>
                        <option value="8am">8am</option>
                        <option value="9am">9am</option>
                        <option value="10am">10am</option>
                        <option value="11am">11am</option>
                        <option value="12pm">12pm</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Close Hours</label>
                    <select name="c_hr" class="form-control custom-select">
                        <option>--Select your Hours--</option>
                        <option value="3pm">3pm</option>
                        <option value="4pm">4pm</option>
                        <option value="5pm">5pm</option>
                        <option value="6pm">6pm</option>
                        <option value="7pm">7pm</option>
                        <option value="8pm">8pm</option>
                        <option value="9pm">9pm</option>
                        <option value="10pm">10pm</option>
                        <option value="11pm">11pm</option>
                        <option value="12am">12am</option>
                        <option value="1am">1am</option>
                        <option value="2am">2am</option>
                        <option value="3am">3am</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Open Days</label>
                    <select name="o_days" class="form-control custom-select">
                        <option>--Select your Days--</option>
                        <option value="Mon-Tue">Mon-Tue</option>
                        <option value="Mon-Wed">Mon-Wed</option>
                        <option value="Mon-Thu">Mon-Thu</option>
                        <option value="Mon-Fri">Mon-Fri</option>
                        <option value="Mon-Sat">Mon-Sat</option>
                        <option value="24hr-x7">24hr-x7</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-danger">
                    <label class="control-label">Image</label>
                    <input type="file" name="file" class="form-control form-control-danger">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Select Category</label>
                    <select name="c_name" class="form-control custom-select">
                        <option>--Select Category--</option>
                        <?php
                        $ssql = "select * from res_category";
                        $res = mysqli_query($db, $ssql);
                        while ($row = mysqli_fetch_array($res)) {
                            echo '<option value="' . $row['c_id'] . '">' . $row['c_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <h3 class="box-title m-t-40">Restaurant Address</h3>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <textarea name="address" style="height:100px;" class="form-control"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <input type="submit" name="submit" class="btn btn-primary" value="Save">
        <a href="add_restaurant.php" class="btn btn-inverse">Cancel</a>
    </div>
</form>