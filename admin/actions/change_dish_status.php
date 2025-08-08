<?php
header('Content-Type: application/json');

require_once __DIR__.'/../../connection/connect.php';

$update_qry = $db->query("UPDATE dishes SET status ='".$_GET['status']."' WHERE d_id = ".$_GET['id']."");
echo json_encode([
    "status" => true,
]);
?>