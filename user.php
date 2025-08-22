<?php 
$title = 'Profile';
include 'parts/start.php'; 

include 'connection/connect.php';

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    header("Location: login.php");
    exit;
}


$stmt = $db->prepare("SELECT * FROM users WHERE u_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

$msg = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $f_name   = $_POST['f_name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $address  = $_POST['address'];

    $check = $db->prepare("SELECT u_id FROM users WHERE username = ? AND u_id != ?");
    $check->bind_param("si", $username, $user_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $msg = '<div class="alert alert-warning text-center">အသုံးပြုသူအမည်ကို ယူထားပြီးဖြစ်သည်။ ကျေးဇူးပြု၍ အခြားတစ်ခုကို ရွေးပါ။</div>';
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
            $msg = '<div class="alert alert-success text-center">ပရိုဖိုင်ကို အောင်မြင်စွာ အပ်ဒိတ်လုပ်ထားသည်။</div>';
            $stmt = $db->prepare("SELECT * FROM users WHERE u_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
        } else {
            $msg = '<div class="alert alert-danger text-center">ပရိုဖိုင်ကို အပ်ဒိတ်လုပ်ရန် မအောင်မြင်ပါ။</div>';
        }
        $stmt->close();
    }
}

?>

<div class="mt-4" style="width: 90%; margin: auto; padding: 100px 0px;">
    <h2 class="mb-4">ပရိုဖိုင်ကို အပ်ဒိတ်လုပ်ရန် </h2>
    <?= $msg ?? '' ?>
    <form method="POST" class="border p-4 rounded bg-light">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">အကောင့်အမည် </label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">နာမည်</label>
                <input type="text" name="f_name" class="form-control" value="<?= htmlspecialchars($user['f_name']) ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">အီးမေးလ်လိပ်စာ</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">ဖုန်းနံပါတ်</label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">စကားဝှက်အသစ် <small class="text-muted">(အသစ် ‌မပြောင်းလိုပါက ကွက်လပ်ထားခဲ့ပါ)</small></label>
                <input type="password" name="password" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">နေရပ်လိပ်စာ အပြည့်အစုံ </label>
            <textarea name="address" class="form-control" rows="3" required><?= htmlspecialchars($user['address']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">ပရိုဖိုင် အပ်ဒိတ်လုပ်မည်</button>
    </form>
</div>

<?php include 'parts/end.php'; ?>
