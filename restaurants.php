<?php
include 'parts/start.php';
include 'connection/connect.php'
?>
<div class="page-wrapper">
    <div class="top-links">
        <div class="container">
            <ul class="row links">

                <li class="col-xs-12 col-sm-4 link-item active"><span>1</span><a href="#">Choose Shop</a></li>
                <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Pick Your food</a></li>
                <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Reserve & Claim</a></li>
            </ul>
        </div>
    </div>
    <div class="inner-page-hero bg-image" data-image-src="images/img/pimg.jpg">
        <div class="container"> </div>
    </div>
    <div class="result-show">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>
    <section class="restaurants-page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-9">
                    <div class="bg-gray restaurant-entry">
                        <div class="row">
                            <?php $ress = mysqli_query($db, "select * from restaurant");
                            while ($rows = mysqli_fetch_array($ress)) {


                                echo ' <div class="col-sm-12 col-md-12 col-lg-8 text-xs-center text-sm-left">
															<div class="entry-logo">
																<a class="img-fluid" href="dishes.php?res_id=' . $rows['rs_id'] . '" > <img src="admin/Res_img/' . $rows['image'] . '" alt="Food logo"></a>
															</div>
															<!-- end:Logo -->
															<div class="entry-dscr">
																<h5><a href="dishes.php?res_id=' . $rows['rs_id'] . '" >' . $rows['title'] . '</a></h5> <span>' . $rows['address'] . '</span>
																
															</div>
															<!-- end:Entry description -->
														</div>
														
														 <div class="col-sm-12 col-md-12 col-lg-4 text-xs-center">
																<div class="right-content bg-white">
																	<div class="right-review">
																		
																		<a href="dishes.php?res_id=' . $rows['rs_id'] . '" class="btn btn-purple">View Menu</a> </div>
																</div>
																<!-- end:right info -->
															</div>';
                            }


                            ?>

                        </div>

                    </div>



                </div>



            </div>
        </div>
</div>
</section>

<?php include 'parts/end.php'; ?>