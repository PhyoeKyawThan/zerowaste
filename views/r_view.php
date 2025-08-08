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
        <style>
            
            .page-wrapper {
                padding-bottom: 20px;
            }
            
            .top-links .links {
                display: flex;
                flex-wrap: wrap;
                padding: 0;
                margin: 0;
                list-style: none;
            }
            
            .top-links .link-item {
                padding: 10px 5px;
                text-align: center;
                position: relative;
                font-size: 12px;
            }
            
            .top-links .link-item span {
                display: block;
                width: 25px;
                height: 25px;
                line-height: 25px;
                border-radius: 50%;
                background: #ddd;
                margin: 0 auto 5px;
                font-weight: bold;
            }
            
            .top-links .link-item.active span {
                background: #28a745;
                color: white;
            }
            
            .inner-page-hero {
                position: relative;
                padding: 15px 0;
                background-size: cover;
                background-position: center;
                /* color: white; */
            }
            
            .profile {
                padding: 10px 0;
            }
            
            .profile-img {
                margin-bottom: 15px;
            }
            
            .image-wrap img {
                width: 100%;
                max-width: 150px;
                height: auto;
                /* border-radius: 50%; */
                border: 3px solid white;
                display: block;
                margin: 0 auto;
            }
            
            .profile-desc {
                text-align: center;
            }
            
            .menu-widget {
                margin-top: 20px;
            }
            
            .food-item {
                border-bottom: 1px solid #eee;
                padding: 15px 0;
            }
            
            .rest-logo img {
                max-width: 80px;
                height: auto;
                border-radius: 5px;
            }
            
            .item-cart-info {
                margin-top: 10px;
                display: flex;
                flex-direction: column;
                align-items: flex-end;
            }
            
            .widget-cart {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                z-index: 1000;
                box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
                display: none; 
            }
            
            .cart-toggle {
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                background: #28a745;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1001;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }
            
            .cart-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                background: red;
                color: white;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                font-size: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            @media (min-width: 768px) {
                body {
                    font-size: 16px;
                }
                
                .top-links .link-item {
                    font-size: 14px;
                }
                
                .profile {
                    display: flex;
                    align-items: center;
                }
                
                .profile-img {
                    margin-bottom: 0;
                }
                
                .profile-desc {
                    text-align: left;
                }
                
                .widget-cart {
                    position: static;
                    display: block !important;
                    box-shadow: none;
                }
                
                .cart-toggle {
                    display: none;
                }
                
                .food-item .row {
                    display: flex;
                    align-items: center;
                }
                
                .item-cart-info {
                    margin-top: 0;
                    flex-direction: row;
                    align-items: center;
                    justify-content: flex-end;
                }
            }
        </style>
        <div class="page-wrapper">
            <?php
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'shop'):
            echo '';
        else:
            ?>
            <div class="top-links">
                <div class="container">
                    <ul class="row links">
                        <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose Shop</a></li>
                        <li class="col-xs-12 col-sm-4 link-item active"><span>2</span>Pick Your food</li>
                        <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Reserve & Claim</a></li>
                    </ul>
                </div>
            </div>

            <?php endif; ?>
            <section class="" style="background-image: url('images/img/restrrr.png')">
                <div class="profile">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="image-wrap">
                                    <figure><img src="/zerowaste/uploads/<?php echo htmlspecialchars($rows['image']); ?>" alt="Restaurant logo"></figure>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 profile-desc">
                                <div class="pull-left right-text white-txt">
                                    <h6><a href="#"><?php echo htmlspecialchars($rows['title']); ?></a></h6>
                                    <p><b>Address: </b><?php echo nl2br(htmlspecialchars($rows['address'])); ?></p>
                                    <p><b>Phone: </b><?= $rows['phone'] ?></p>
                                    <p><b>Opening Time: </b><?= $rows['o_hr'].' - '.$rows['c_hr'] ?></p>
                                    <p><b>Website: </b><?php
                                        $url = $rows['url'];
                                        $headers = @get_headers($url);
                                        print_r($headers);
                                        if($headers && strpos($headers[0], '200') !== false){
                                            echo '<a href="'.$rows['url'].'">'.$rows['url'].'</a>';
                                        }else{
                                            echo '---';
                                        }
                                    ?></p>
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
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3" <?= isset($_SESSION['rs_id']) ? 'style="display: none;"' : '' ?>>
                        <div class="widget widget-cart" id="mobile-cart">
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
                                                <a href="restaurants.php?res_id=<?php echo intval($_GET['res_id']); ?>&action=remove&id=<?php echo intval($item["d_id"]); ?>">
                                                    <i class="fa fa-trash pull-right"></i>
                                                </a>
                                            </div>

                                            <div class="form-group row no-gutter">
                                                <div class="col-xs-8">
                                                    <input type="text" class="form-control b-r-0" value="Quantity - " readonly>
                                                </div>
                                                <div class="col-xs-4">
                                                    <input class="form-control" type="text" readonly value='<?php echo intval($item["quantity"]); ?>'>
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
                                        <a href="restaurants.php?res_id=<?php echo intval($_GET['res_id']); ?>&action=confirm" class="btn btn-danger btn-lg disabled btn-block">Claim Now</a>
                                    <?php } else { ?>
                                        <a href="restaurants.php?res_id=<?php echo intval($_GET['res_id']); ?>&action=confirm" class="btn btn-success btn-lg active btn-block">Claim Now</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                
                    <div class="<?= isset($_SESSION['rs_id']) ? 'col-md-12' : 'col-md-8' ?>">
                        <div class="menu-widget" id="2">
                            <div class="widget-heading">
                                <h3 class="widget-title text-dark">
                                    MENU
                                    <a class="btn btn-link pull-right" data-toggle="collapse" href="#popular2" aria-expanded="true">
                                        <i class="fa fa-angle-right pull-right"></i>
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                                <div class="clearfix"></div>
                            </div>

                            <div class="collapse in" id="popular2">
                                <?php
                                $stmt = $db->prepare("SELECT * FROM dishes WHERE rs_id = ? AND status = 'Approved'");
                                $stmt->bind_param('i', $_GET['res_id']);
                                $stmt->execute();
                                $products = $stmt->get_result();

                                if ($products->num_rows > 0) {
                                    while ($product = $products->fetch_assoc()) {
                                        ?>
                                        <div class="food-item">
                                            <div class="row">
                                                <form class="w-100">
                                                    <div class="col-xs-12 col-sm-12 col-lg-8">
                                                        <div class="rest-logo pull-left">
                                                            <a class="restaurant-logo pull-left" href="#">
                                                                <img src="/zerowaste/uploads/dishes/<?php echo htmlspecialchars($product['img']); ?>" alt="Food logo" style="width: 100px; height: 100px; ">
                                                            </a>
                                                        </div>
                                                        <div class="rest-descr">
                                                            <h6><a href="#"><?php echo htmlspecialchars($product['title']); ?></a></h6>
                                                            <p><?php echo htmlspecialchars($product['slogan']); ?></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-lg-4 pull-right item-cart-info">
                                                        <span class="price pull-left" id="s-<?= $product['d_id'] ?>"><?php echo "Stock: " . $product['stock']; ?></span>
                                                        <input class="b-r-0" type="number" name="quantity" id="d-<?= $product['d_id'] ?>" min="1" max="<?= $product['stock'] ?>" value="1" style="width:60px; <?= isset($_SESSION['rs_id']) ? "display: none;" : '' ?>" />
                                                        
                                                        <button type="button" class="btn theme-btn" style="<?= isset($_SESSION['rs_id']) ? "display: none;" : '' ?>" onclick="addToCart(<?= $product['d_id'] ?>)">
                                                            Add To Cart
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <hr>
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
            
         
            <?php if(!isset($_SESSION['rs_id'])): ?>
                <div class="cart-toggle" onclick="toggleCart()">
                    <i class="fa fa-shopping-cart"></i>
                    <?php if($item_total > 0): ?>
                        <span class="cart-badge"><?= $item_total ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <script>
            function addToCart(productId) {
                const quantity = document.getElementById(`d-${productId}`);
                let stockElement = document.getElementById(`s-${productId}`);
                let stockText = stockElement.textContent.trim();
                let stock = parseInt(stockText.replace("Stock:", "").trim());
                
                if (quantity.value > stock) {
                    alert("Max Stock is " + stock);
                    return;
                }
                
                if (quantity.value < 1) {
                    alert("Minimum quantity is 1");
                    return;
                }
                
                const url = `restaurants.php?res_id=<?php echo intval($_GET['res_id']); ?>&action=add&id=${productId}&q=${quantity.value}`;
                window.location.href = url;
            }
            
            function toggleCart() {
                const cart = document.getElementById('mobile-cart');
                if (cart.style.display === 'block') {
                    cart.style.display = 'none';
                } else {
                    cart.style.display = 'block';
                }
            }
            
          
            document.addEventListener('click', function(event) {
                const cart = document.getElementById('mobile-cart');
                const toggleBtn = document.querySelector('.cart-toggle');
                
                if (cart && cart.style.display === 'block' && 
                    !cart.contains(event.target) && 
                    event.target !== toggleBtn && 
                    !toggleBtn.contains(event.target)) {
                    cart.style.display = 'none';
                }
            });
        </script>
<?php endif; ?>