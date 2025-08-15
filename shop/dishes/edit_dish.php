<?php
$error = "";
$success = "";

$dish_id = $_GET['d_id'] ?? null;
if (!$dish_id) {
    die("Dish ID is required.");
}

// Fetch existing dish data
$dish = $db->prepare("SELECT * FROM dishes WHERE d_id = ?");
mysqli_stmt_bind_param($dish, 'i', $dish_id);
mysqli_execute($dish);
$d = mysqli_fetch_assoc(mysqli_stmt_get_result($dish));


if (isset($_POST['submit'])) {
    $d_name = trim($_POST['d_name']);
    $about = trim($_POST['about']);
    $stock = (int)$_POST['stock'];
    $price = (int) $_POST['price'];
    $discount = (int) $_POST['discount'];
    $res_id = $_SESSION['rs_id'];
    $image_filename = $d['img'];

    if (empty($d_name) || empty($about)) {
        $error = '<strong>All fields must be filled!</strong>';
    } else {
        $upload_dir = __DIR__ . "/../../uploads/dishes/";

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

                if (move_uploaded_file($file_tmp, $target_file)) {
                    $image_filename = $unique_name;
                } else {
                    $error = '<strong>Failed to upload image.</strong>';
                }
            }
        }

       
        if (empty($error)) {
            $query = "UPDATE dishes SET title = ?, slogan = ?, stock = ?, price = ?, discount = ?, img = ?, rs_id = ? WHERE d_id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ssiiissi', $d_name, $about, $stock, $price, $discount, $image_filename, $res_id, $dish_id);

            if (mysqli_stmt_execute($stmt)) {
                $success = '<strong>Dish updated successfully.</strong>';
                $d['title'] = $d_name;
                $d['slogan'] = $about;
                $d['stock'] = $stock;
                $d['img'] = $image_filename;
                $d['price'] = $price;
                $d['discount'] = $discount;
            } else {
                $error = '<strong>Database error. Please try again.</strong>';
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<div class="text-danger text-center"><?= $error ?></div>
<div class="text-success text-center"><?= $success ?></div>

<form action="" method="post" enctype="multipart/form-data" style="padding: 20px">
    <a href="shop.php?p=dishes" class="d-block mb-1 mt-1"><i class="fas fa-arrow-left"></i></a>
    <div class="form-body">
        <h4>Edit Menu Item</h4>
        <hr>

        <div class="mb-3">
            <label for="d_name" class="form-label">Dish Name</label>
            <input type="text" id="d_name" name="d_name" value="<?= htmlspecialchars($d['title']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="about" class="form-label">Description</label>
            <input type="text" id="about" name="about" value="<?= htmlspecialchars($d['slogan']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stocks</label>
            <input type="number" id="stock" name="stock" value="<?= (int)($d['stock'] ?? 0) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" id="price" value="<?= $d['price'] ?>" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="discount" class="form-label">Discount</label>
            <input type="number" id="discount" value="<?= $d['discount'] ?>" name="discount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Dish Image</label>
            <input type="file" id="file" name="file" class="form-control" accept="image/*">
            <?php if (!empty($d['img'])): ?>
                <div class="mt-2">
                    <img src="/zerowaste/uploads/dishes/<?= htmlspecialchars($d['img']) ?>" alt="Current Dish Image" style="max-width: 150px;">
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Save</button>
        <a href="shop.php?p=dishes" class="btn btn-secondary">Cancel</a>
    </div>
</form>
