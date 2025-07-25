<?php
function getProductDetails($db, $productId) {
    $stmt = $db->prepare("SELECT * FROM dishes WHERE d_id = ?");
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}

function addToCart($db, $productId, $quantity) {
    if (empty($quantity)) return;

    $product = getProductDetails($db, $productId);
    if (!$product) return;

    $item = [
        $product->d_id => [
            'title' => $product->title,
            'd_id' => $product->d_id,
            'quantity' => $quantity,
            'stock' => $product->stock
        ]
    ];

    if (!empty($_SESSION['cart_item'])) {
        if (array_key_exists($product->d_id, $_SESSION['cart_item'])) {
            if($_SESSION['cart_item'][$product->d_id]['quantity'] == 0){
                $_SESSION['cart_item'][$product->d_id]['quantity'] = $quantity;
            }else
            $_SESSION['cart_item'][$product->d_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart_item'] += $item;
        }
    } else {
        $_SESSION['cart_item'] = $item;
    }
}

function removeFromCart($productId) {
    if (!empty($_SESSION["cart_item"])) {
        foreach ($_SESSION["cart_item"] as $k => $v) {
            if ($productId == $v['d_id']) {
                unset($_SESSION["cart_item"][$k]);
            }
        }
    }
}

function emptyCart() {
    unset($_SESSION["cart_item"]);
}

function proceedToCheckout() {
    include __DIR__.'/../views/confirm_dish_claim.php';
    exit;
}

$action = $_GET["action"] ?? '';
$productId = isset($_GET['id']) ? (int) $_GET['id'] : null;
$quantity = isset($_GET['q']) ? (int) $_GET['q'] : 1;
switch ($action) {
    case "add":
        if ($productId && $quantity > 0) {
            addToCart($db, $productId, $quantity);
        }
        break;

    case "remove":
        if ($productId) {
            removeFromCart($productId);
        }
        break;

    case "empty":
        emptyCart();
        break;

    case "confirm":
        proceedToCheckout();
        break;
}
?>
