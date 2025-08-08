<?php 
session_start();
include 'connection/connect.php';

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    header("Location: login.php");
    exit;
}

$title = 'Profile';
include 'parts/start.php'; 

$stmt = $db->prepare("SELECT * FROM users WHERE u_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

$msg = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $f_name   = $_POST['f_name'];
    $l_name   = $_POST['l_name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $address  = $_POST['address'];

    $check = $db->prepare("SELECT u_id FROM users WHERE username = ? AND u_id != ?");
    $check->bind_param("si", $username, $user_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $msg = '<div class="alert alert-warning text-center">Username is already taken. Please choose another one.</div>';
        $check->close();
    } else {
        $check->close();

        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET username=?, f_name=?, l_name=?, email=?, phone=?, password=?, address=? WHERE u_id=?";
            $stmt = $db->prepare($update_sql);
            $stmt->bind_param("sssssssi", $username, $f_name, $l_name, $email, $phone, $password, $address, $user_id);
        } else {
            $update_sql = "UPDATE users SET username=?, f_name=?, l_name=?, email=?, phone=?, address=? WHERE u_id=?";
            $stmt = $db->prepare($update_sql);
            $stmt->bind_param("ssssssi", $username, $f_name, $l_name, $email, $phone, $address, $user_id);
        }

        if ($stmt->execute()) {
            $msg = '<div class="alert alert-success text-center">Profile updated successfully!</div>';
            $stmt = $db->prepare("SELECT * FROM users WHERE u_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
        } else {
            $msg = '<div class="alert alert-danger text-center">Failed to update profile.</div>';
        }
        $stmt->close();
    }
}

?>

<div class="mt-4" style="width: 90%; margin: auto; padding: 100px 0px;">
    <h2 class="mb-4">Profile</h2>
    <?= $msg ?? '' ?>
    <form method="POST" class="border p-4 rounded bg-light">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">First Name</label>
                <input type="text" name="f_name" class="form-control" value="<?= htmlspecialchars($user['f_name']) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Last Name</label>
                <input type="text" name="l_name" class="form-control" value="<?= htmlspecialchars($user['l_name']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                <input type="password" name="password" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="3" required><?= htmlspecialchars($user['address']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<?php include 'parts/end.php'; ?>
