<?php 
 include '../config/config.php';
 include '../config/codeGen.php';
 include '../fuctions/user.php';

 
?>
<!DOCTYPE html>
<html lang="en">
<?php include('../partial/head.php') ?>

<body class="crm_body_bg">
    <section class="main_content dashboard_part">

        <div class="main_content_iner ">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="white_box mb_30">
                            <div class="row justify-content-center">
                                <div class="col-lg-6">

                                    <div class="modal-content cs_modal">
                                        <div class="modal-header">
                                        <img src="../public/img/logo.png" class="img-fluid logo" alt="Expense Tracking System">
                                            <h5 class="modal-title">Reset Password</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form method="Post">
                                             
                                                <div class="">
                                                    <input type="text" class="form-control" name="user_email" placeholder="Enter your email">
                                                </div>
                                               
                                                <button type="submit" name="reset_password" class="btn_1 full_width text-center">Reset Password</button>
                                                
                                               
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         <?php include('../partial/footer.php') ?>

          
    </section>
    <?php include('../partial/script.php') ?>
</body>

</html>