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
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $status = trim($_POST['status']);
        $claim_id = (int) $_GET['id'];
        $remark = trim($_POST['remark']);
        if($claim_id && $status){
            include '../../../connection/connect.php';
            $query_str = "INSERT INTO remark(users_claims_id, status, remark) VALUES(?, ?, ?)";
            $update_sts = "UPDATE users_claims SET status = ? WHERE id = ?";
            $update = mysqli_prepare($db, $update_sts);
            mysqli_stmt_bind_param($update, "si", $status, $claim_id);
            if(mysqli_execute($update)){
                $remark_insert = mysqli_prepare($db, $query_str);
                mysqli_stmt_bind_param($remark_insert, 'iss', $claim_id, $status, $remark);
                if(mysqli_execute($remark_insert)){
                    echo "<script>alert('Form Details Updated Successfully'); window.close();</script>";
                }
            }
        }
    }
?>
<form name="updateticket" id="updatecomplaint" method="post" class="needs-validation" novalidate>
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header text-dark">
                <h5 class="mb-0">Update Order Status</h5>
            </div>

            <div class="card-body">
                <!-- <div class="mb-3 row">
                    <label class="col-md-3 col-form-label fw-bold">Form Number</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control"
                            value="<?php //echo htmlentities($_GET['form_id']); ?>" readonly>
                    </div>
                </div> -->

                <div class="mb-3 row">
                    <label for="status" class="col-md-3 col-form-label fw-bold">Status</label>
                    <div class="col-md-9">
                        <select name="status" id="status" class="form-control" required>
                            <option value="" selected disabled>Select Status</option>
                            <option value="in process">On the way</option>
                            <option value="closed">Delivered</option>
                            <option value="rejected">Cancelled</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a status
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="remark" class="col-md-3 col-form-label fw-bold">Message</label>
                    <div class="col-md-9">
                        <textarea name="remark" id="remark" class="form-control" rows="5" required></textarea>
                        <div class="invalid-feedback">
                            Please enter a message
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between">
                    <button type="submit" name="update" class="btn btn-primary px-4">
                        <i class="fas fa-check me-2"></i> Submit
                    </button>
                    <button type="button" onclick="window.close();" class="btn btn-danger px-4">
                        <i class="fas fa-times me-2"></i> Close Window
                    </button>
                </div>
            </div>
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

    textarea.form-control {
        min-height: 120px;
    }

    .form-select,
    .form-control {
        border-radius: 5px;
    }
</style>

<script>
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var form = document.getElementById('updatecomplaint');
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }, false);
    })();
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