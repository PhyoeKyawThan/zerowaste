<?php
include 'parts/start.php';
$error = $success = "";

if (isset($_GET['del'])) {
    mysqli_query($db, "DELETE FROM res_category WHERE c_id = '" . $_GET['del'] . "'");
    $success = "Delete Success";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $c_name = trim($_POST['c_name']);
    $c_id = $_POST['c_id'] ?? false;
    if ($c_id) {
        $stmt = $db->prepare("UPDATE res_category SET c_name = ? WHERE c_id = ?");
        $stmt->bind_param("si", $c_name, $c_id);
        if ($stmt->execute())
            $success = "Category edited successfully.";
    } else if (empty($c_name)) {
        $error = "Category name is required.";
    } else {
        $stmt = $db->prepare("SELECT c_id FROM res_category WHERE c_name = ?");
        $stmt->bind_param("s", $c_name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Category already exists.";
        } else {
            $insert = $db->prepare("INSERT INTO res_category (c_name) VALUES (?)");
            $insert->bind_param("s", $c_name);
            $insert->execute();
            $success = "New category added successfully.";
        }
    }
}
?>

<h2 class="text-primary">Restaurant Categories</h2>
<hr>

<?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif ($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form method="post" class="mb-4">
    <input type="hidden" name="c_id" id="c_id">
    <div class="mb-3">
        <label for="c_name" class="form-label">Category Name</label>
        <input type="text" class="form-control" id="c_name" name="c_name" placeholder="Enter category name">
    </div>
    <div>
        <button type="submit" name="submit" class="btn btn-primary">Save</button>
        <a href="category.php" class="btn btn-secondary">Reset</a>
    </div>
</form>

<h4 class="mb-3">Listed Categories</h4>
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Category Name</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $db->query("SELECT * FROM res_category ORDER BY c_id DESC");
            if ($result->num_rows > 0):
                $i = 0;
                while ($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?= ++$i ?></td>
                        <td><?= htmlspecialchars($row['c_name']) ?></td>
                        <td><?= $row['date'] ?></td>
                        <td>
                            <a onclick="updateDataToForm(<?= $row['c_id'] ?>, '<?= $row['c_name'] ?>')" class="btn btn-primary">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="category.php?del=<?= $row['c_id'] ?>" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this category?');">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">No categories found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script>
    function updateDataToForm(id, name) {
        document.getElementById('c_id').value = Number(id);
        document.getElementById('c_name').value = name;
    }
</script>
<?php include 'parts/end.php'; ?>