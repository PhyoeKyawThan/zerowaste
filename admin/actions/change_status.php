<?php
header('Content-Type: application/json');

require_once __DIR__.'/../../connection/connect.php';

$update_qry = $db->query("UPDATE users SET account_status ='".$_GET['status']."' WHERE u_id = ".$_GET['id']."");
echo json_encode([
    "status" => true,
]);
?>