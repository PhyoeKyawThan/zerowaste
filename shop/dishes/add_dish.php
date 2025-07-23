<?php
$error = "";
$success = "";

if (isset($_POST['submit'])) {
    $d_name = trim($_POST['d_name']);
    $about = trim($_POST['about']);
    $res_id = $_SESSION['rs_id'];

    if (empty($d_name) || empty($about) || empty($res_id)) {
        $error = '<strong>All fields must be filled!</strong>';
    } else {
        $upload_dir = __DIR__ . "/../uploads/dishes/";
        $target_file = "";

        if (!empty($_FILES['file']['name'])) {
            $file_name = basename($_FILES['file']['name']);
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($file_ext, $allowed_ext)) {
                $error = '<strong>Invalid image format! Allowed: jpg, jpeg, png, gif.</strong>';
            } elseif ($file_size > 1_000_000) {
                $error = '<strong>Max image size is 1MB.</strong>';
            } else {
                $unique_name = uniqid("dish_", true) . "." . $file_ext;
                $target_file = $upload_dir . $unique_name;

                if (!move_uploaded_file($file_tmp, $target_file)) {
                    $error = '<strong>Failed to upload image.</strong>';
                }
            }
        } else {
            $error = '<strong>Please select an image file.</strong>';
        }

        // If no errors, insert into DB
        if (empty($error)) {
            $query = "INSERT INTO dishes (rs_id, title, slogan, img) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'isss', $res_id, $d_name, $about, $unique_name);

            if (mysqli_stmt_execute($stmt)) {
                $success = '<strong>New dish added successfully.</strong>';
            } else {
                $error = '<strong>Database error. Please try again.</strong>';
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<div class="text-danger"><?= $error ?></div>
<div class="text-success"><?= $success ?></div>
<form action="" method="post" enctype="multipart/form-data" style="padding: 20px">
    <a href="shop.php?p=dishes" class="d-block mb-1 mt-1"><i class="fas fa-arrow-left"></i></a>
    <div class="form-body">
        <h4>Add New Menu Item</h4>
        <hr>

        <div class="mb-3">
            <label for="d_name" class="form-label">Dish Name</label>
            <input type="text" id="d_name" name="d_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="about" class="form-label">Description</label>
            <input type="text" id="about" name="about" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Dish Image</label>
            <input type="file" id="file" name="file" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Save</button>
        <a href="add_menu.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>