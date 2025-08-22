<header id="header" class="header-scroll top-header headrom">
    <nav class="navbar navbar-dark">
        <div class="container">
            <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
                data-target="#mainNavbarCollapse">&#9776;</button>
            <a class="navbar-brand" href="index.php"> ZeroWaste Food Ordering & Sharing Platform</a>
            <div class="collapse navbar-toggleable-md float-lg-right" id="mainNavbarCollapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item"> <a class="nav-link active" href="index.php">ပင်မစာမျက်နှာ <span
                                class="sr-only">(current)</span></a> </li>
                    <li class="nav-item"> <a class="nav-link active" href="restaurants.php">စားသောက်ဆိုင်များ<span
                                class="sr-only"></span></a> </li>
                    <?php
                    if (empty($_SESSION["user_id"])) {
                        echo '<li class="nav-item"><a href="login.php" class="nav-link active">အကောင့်ဝင်မယ်</a> </li>
                                <li class="nav-item"><a href="registration.php" class="nav-link active">စာရင်းသွင်းမယ်</a> </li>';
                    } else {
                        if ($_SESSION['user_role'] == 'user') {
                            $username = $_SESSION['user_name'];
                            $prefix_show = strtoupper($username[0]);
                            echo '<li class="nav-item"><a href="claims.php" class="nav-link active">အော်ဒါများ</a> </li>';
                            echo '<li class="nav-item" style="width: 40px; text-align: center"><a href="user.php" class="nav-link active bg-primary text-weight-bold" style="padding: 3px; border-radius: 50%;">'.$prefix_show.'</a> </li>';
                        } else
                            echo '<li class="nav-item"><a href="shop.php" class="nav-link active">စားသုံးသူ၏ အော်ဒါများ</a> </li>';
                        echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>