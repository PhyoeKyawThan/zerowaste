<?php

$ress = mysqli_query($db, "SELECT * FROM restaurant WHERE rs_id='" . intval($_GET['res_id']) . "'");
$rows = mysqli_fetch_assoc($ress);

if (isset($_GET['action']) && $_GET['action'] == 'confirm'):
    include __DIR__ . '/confirm_dish_claim.php';
else:
    if (isset($_GET['action'])) {
        include __DIR__ . '/../actions/cart.php';
    }
    ?>

    <div class="page-wrapper">
        <div class="top-links">
            <div class="container">
                <ul class="row links">
                    <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose Shop</a></li>
                    <li class="col-xs-12 col-sm-4 link-item active"><span>2</span>Pick Your food</li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Reserve & Claim</a></li>
                </ul>
            </div>
        </div>

        <section class="inner-page-hero bg-image" data-image-src="images/img/restrrr.png">
            <div class="profile">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 profile-img">
                            <div class="image-wrap">
                                <figure><img src="/zerowaste/uploads/<?php echo htmlspecialchars($rows['image']); ?>"
                                        alt="Restaurant logo"></figure>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 profile-desc">
                            <div class="pull-left right-text white-txt">
                                <h6><a href="#"><?php echo htmlspecialchars($rows['title']); ?></a></h6>
                                <p><?php echo nl2br(htmlspecialchars($rows['address'])); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="breadcrumb">
            <div class="container"></div>
        </div>

        <div class="container m-t-30">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                    <div class="widget widget-cart">
                        <div class="widget-heading">
                            <h3 class="widget-title text-dark">Your Cart</h3>
                            <div class="clearfix"></div>
                        </div>

                        <div class="order-row bg-white">
                            <div class="widget-body">
                                <?php
                                $item_total = 0;
                                if (!empty($_SESSION["cart_item"])) {
                                    foreach ($_SESSION["cart_item"] as $item) {
                                        $item_total += intval($item["quantity"]);
                                        ?>
                                        <div class="title-row">
                                            <?php echo htmlspecialchars($item["title"]); ?>
                                            <a
                                                href="restaurants.php?res_id=<?php echo intval($_GET['res_id']); ?>&action=remove&id=<?php echo intval($item["d_id"]); ?>">
                                                <i class="fa fa-trash pull-right"></i>
                                            </a>
                                        </div>

                                        <div class="form-group row no-gutter">
                                            <div class="col-xs-8">
                                                <input type="text" class="form-control b-r-0" value="Quantity - " readonly
                                                    id="exampleSelect1">
                                            </div>
                                            <div class="col-xs-4">
                                                <input class="form-control" type="text" readonly
                                                    value='<?php echo intval($item["quantity"]); ?>' id="example-number-input">
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo "<p>Your cart is empty.</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="price-wrap text-xs-center">
                                <p>TOTAL CLAIM FOOD</p>
                                <h3 class="value"><strong><?php echo $item_total; ?></strong></h3>

                                <?php if ($item_total == 0) { ?>
                                    <a href="restaurants.php?res_id=<?php echo intval($_GET['res_id']); ?>&action=confirm"
                                        class="btn btn-danger btn-lg disabled">Claim Now</a>
                                <?php } else { ?>
                                    <a href="restaurants.php?res_id=<?php echo intval($_GET['res_id']); ?>&action=confirm"
                                        class="btn btn-success btn-lg active">Claim Now</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="menu-widget" id="2">
                        <div class="widget-heading">
                            <h3 class="widget-title text-dark">
                                MENU
                                <a class="btn btn-link pull-right" data-toggle="collapse" href="#popular2"
                                    aria-expanded="true">
                                    <i class="fa fa-angle-right pull-right"></i>
                                    <i class="fa fa-angle-down pull-right"></i>
                                </a>
                            </h3>
                            <div class="clearfix"></div>
                        </div>

                        <div class="collapse in" id="popular2">
                            <?php
                            $stmt = $db->prepare("SELECT * FROM dishes WHERE rs_id = ?");
                            $stmt->bind_param('i', $_GET['res_id']);
                            $stmt->execute();
                            $products = $stmt->get_result();

                            if ($products->num_rows > 0) {
                                while ($product = $products->fetch_assoc()) {
                                    ?>
                                    <div class="food-item">
                                        <div class="row">
                                            <form method="post" action=''>
                                                <div class="col-xs-12 col-sm-12 col-lg-8">
                                                    <div class="rest-logo pull-left">
                                                        <a class="restaurant-logo pull-left" href="#">
                                                            <img src="/zerowaste/uploads/dishes/<?php echo htmlspecialchars($product['img']); ?>"
                                                                alt="Food logo">
                                                        </a>
                                                    </div>

                                                    <div class="rest-descr">
                                                        <h6><a href="#"><?php echo htmlspecialchars($product['title']); ?></a></h6>
                                                        <p><?php echo htmlspecialchars($product['slogan']); ?></p>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-lg-3 pull-right item-cart-info">
                                                    <span class="price pull-left"
                                                        id="s-<?= $product['d_id'] ?>"><?php echo "Stock: " . $product['stock']; ?></span>
                                                    <input class="b-r-0" type="number" name="quantity"
                                                        id="d-<?= $product['d_id'] ?>" min="1" max="<?= $product['stock'] ?>"
                                                        value="1" style="margin-left:30px; width:60px;" />

                                                    <a href="#" class="btn theme-btn" style="margin-left:40px;"
                                                        onclick="addToCart(<?= $product['d_id'] ?>)">
                                                        Add To Cart
                                                    </a>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "<p>No dishes available.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<script>
    function addToCart(productId) {
        const quantity = document.getElementById(`d-${productId}`);
        let stockElement = document.getElementById(`s-${productId}`);
        let stockText = stockElement.textContent.trim();
        let stock = parseInt(stockText.replace("Stock:", "").trim());
        if (stock < quantity.value) {
            alert("Max Stock is " + stock);
            return;
        }
        const url = `restaurants.php?res_id=<?php echo intval($_GET['res_id']); ?>&action=add&id=${productId}&q=${quantity.value}`;
        window.location.href = url;
    }
</script>