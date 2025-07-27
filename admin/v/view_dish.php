<?php

$d_id = (int)$_GET['dId'];

$query = $db->prepare("
    SELECT 
        ds.*, 
        rs.title AS rs_title, rs.email, rs.phone, rs.url, rs.o_hr, rs.c_hr, rs.o_days, rs.address, rs.image AS res_image,
        c.c_name
    FROM dishes ds
    JOIN restaurant rs ON rs.rs_id = ds.rs_id
    JOIN res_category c ON c.c_id = rs.c_id
    WHERE ds.d_id = ?
");
$query->bind_param('i', $d_id);
$query->execute();
$result = $query->get_result();

$dish = $result->fetch_assoc();
?>

<div class="container mt-4">
    <a href="/zerowaste/admin/dishes.php" class="btn btn-outline-secondary mb-3"><i class="fas fa-arrow-left"></i> Back to Dishes</a>
    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-utensils"></i> <?= htmlspecialchars($dish['title']) ?> <small class="text-light">(<?= htmlspecialchars($dish['slogan']) ?>)</small></h4>
        </div>
        <div class="card-body row">
            <div class="col-md-5">
                <img src="../uploads/dishes/<?= htmlspecialchars($dish['img']) ?>" class="img-fluid rounded border" alt="<?= htmlspecialchars($dish['title']) ?>">
            </div>
            <div class="col-md-7">
                <p><strong>Category:</strong> <?= htmlspecialchars($dish['c_name']) ?></p>
                <p><strong>Restaurant:</strong> <?= htmlspecialchars($dish['rs_title']) ?></p>
                <p><strong>Stock:</strong> <?= htmlspecialchars($dish['stock']) ?></p>
                <p><strong>Created At:</strong> <?= htmlspecialchars($dish['created_at']) ?></p>

                <hr>
                <h5 class="mt-3">Restaurant Details</h5>
                <img src="/zerowaste/uploads/<?= htmlspecialchars($dish['res_image']) ?>" class="img-thumbnail mt-2" width="120" alt="Restaurant Image">
                <p><strong>Email:</strong> <?= htmlspecialchars($dish['email']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($dish['phone']) ?></p>
                <p><strong>Website:</strong> <a href="<?= htmlspecialchars($dish['url']) ?>" target="_blank"><?= htmlspecialchars($dish['url']) ?></a></p>
                <p><strong>Open Hours:</strong> <?= htmlspecialchars($dish['o_hr']) ?> - <?= htmlspecialchars($dish['c_hr']) ?></p>
                <p><strong>Operating Days:</strong> <?= htmlspecialchars($dish['o_days']) ?></p>
                <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($dish['address'])) ?></p>
            </div>
        </div>
    </div>
</div>

