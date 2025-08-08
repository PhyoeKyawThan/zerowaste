<?php
function showSuccessAlert()
{
    echo "<script>
        alert('Thank you. Your Order has been placed!');
        window.location.replace('claims.php');
    </script>";
}

if (empty($_SESSION["user_id"])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit'])) {


    foreach ($_SESSION["cart_item"] as $item) {
        $d_id = intval($item['d_id']);
        $quantity = intval($item["quantity"]);
        $user_id = intval($_SESSION["user_id"]);

        $SQL = "INSERT INTO users_claims (u_id, d_id, quantity)
                    VALUES ('$user_id', '$d_id', '$quantity')";
        $update_dishes_stock = "UPDATE dishes set stock = stock - ? WHERE d_id = ?";
        $prepare_dish_stock_update = mysqli_prepare($db, $update_dishes_stock);
        $prepare_dish_stock_update->bind_param('ii', $quantity, $d_id);
        if (mysqli_query($db, $SQL)) {
            $prepare_dish_stock_update->execute();
        }
    }
    unset($_SESSION["cart_item"]);
    showSuccessAlert();
}

?>

<div class="page-wrapper">
    <div class="top-links">
        <div class="container">
            <ul class="row links">
                <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose Shop</a></li>
                <li class="col-xs-12 col-sm-4 link-item"><span>2</span>Pick Your food</li>
                <li class="col-xs-12 col-sm-4 link-item active"><span>3</span>Reserve & Claim</li>
            </ul>
        </div>
    </div>

    <div class="container m-t-30">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="widget clearfix">
                <div class="widget-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="cart-totals margin-b-20">
                                <div class="cart-totals-title">
                                    <h4>Claim Summary</h4>
                                </div>
                                <div class="cart-totals-fields">
                                    <table class="table">
                                        <tbody>
                                            <?php
                                            $item_total = 0;
                                            if (!empty($_SESSION["cart_item"])) {
                                                foreach ($_SESSION["cart_item"] as $item) {
                                                    $item_total += intval($item["quantity"]);
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <div class="title-row">
                                                                <?php echo htmlspecialchars($item["title"]); ?>
                                                            </div>
                                                            <div class="form-group row no-gutter">
                                                                <div class="col-xs-8">
                                                                    <input type="text" class="form-control b-r-0"
                                                                        value="Quantity" readonly>
                                                                </div>
                                                                <div class="col-xs-4">
                                                                    <input class="form-control" type="text" readonly
                                                                        value="<?php echo intval($item['quantity']); ?>">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>

                                            <tr>
                                                <td class="text-color"><strong>Total Quantity</strong></td>
                                                <td class="text-color"><strong><?php echo $item_total; ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="payment-option">
                                <p class="text-xs-center">
                                    <input type="submit" onclick="return confirm('Do you want to confirm the order?');"
                                        name="submit" class="btn btn-success btn-block" value="Claim Now">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>