<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title><?= $title ?? '' ?></title>
    <link href="/zerowaste/css/bootstrap.min.css" rel="stylesheet">
    <link href="/zerowaste/css/font-awesome.min.css" rel="stylesheet">
    <link href="/zerowaste/css/animsition.min.css" rel="stylesheet">
    <link href="/zerowaste/css/animate.css" rel="stylesheet">
    <link href="/zerowaste/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<form name="updateticket" id="userProfileForm" method="post">
    <div class="container">
        <div class="card shadow-sm">
            <?php 
            include '../../../connection/connect.php';
            $ret1 = mysqli_query($db, "SELECT * FROM users_claims WHERE id='".mysqli_real_escape_string($db, $_GET['id'])."'");
            $ro = mysqli_fetch_array($ret1);
            $ret2 = mysqli_query($db, "SELECT * FROM users WHERE u_id ='".mysqli_real_escape_string($db, $ro['u_id'])."'");
            
            if($row = mysqli_fetch_array($ret2)): 
            ?>
            
            <div class="card-header text-white">
                <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i> <?php echo htmlspecialchars($row['f_name']); ?>'s Profile</h4>
            </div>
            
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Registration Date</label>
                            <div class="form-control-plaintext"><?php echo htmlspecialchars($row['date']); ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold ">Account Status</label>
                            <div>
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge bg-primary text-white"><i class="fas fa-check-circle me-1"></i> Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger text-white"><i class="fas fa-times-circle me-1"></i> Blocked</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">First Name</label>
                            <div class="form-control-plaintext"><?php echo htmlspecialchars($row['f_name']); ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Last Name</label>
                            <div class="form-control-plaintext"><?php echo htmlspecialchars($row['l_name']); ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <div class="form-control-plaintext"><?php echo htmlspecialchars($row['email']); ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone Number</label>
                            <div class="form-control-plaintext"><?php echo htmlspecialchars($row['phone']); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer text-end">
                <button type="button" onclick="window.close();" class="btn btn-danger">
                    <i class="fas fa-times me-2"></i> Close Window
                </button>
            </div>
            
            <?php else: ?>
            <div class="card-body">
                <div class="alert alert-warning">User not found</div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</form>

<style>
    .card {
        border-radius: 10px;
        border: none;
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    .form-control-plaintext {
        padding: 0.375rem 0;
        border-bottom: 1px solid #eee;
    }
    
    .badge {
        padding: 0.5em 0.75em;
        font-size: 0.9em;
        font-weight: 500;
    }
</style>

<script>
function f2() {
    window.close();
    return false;
}
</script>
<script src="/zerowaste/js/jquery.min.js"></script>
<script src="/zerowaste/js/tether.min.js"></script>
<script src="/zerowaste/js/bootstrap.min.js"></script>
<script src="/zerowaste/js/animsition.min.js"></script>
<script src="/zerowaste/js/bootstrap-slider.min.js"></script>
<script src="/zerowaste/js/jquery.isotope.min.js"></script>
<script src="/zerowaste/js/headroom.js"></script>
<script src="/zerowaste/js/foodpicky.min.js"></script>
<script src="/zerowaste/js/bootstrap.bundle.js"></script>