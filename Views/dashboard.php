<?php
include '../config/config.php';
include '../config/codeGen.php';
include '../config/checklogin.php';
include '../fuctions/user.php';
check_login()
?>
<!DOCTYPE html>
<html lang="en">
<?php include('../partial/head.php') ?>

<body class="crm_body_bg">
<?php
    /* Load This Page With Logged In User Session */
    $user_id = mysqli_escape_string($mysqli, $_SESSION['user_id']);
    $user_sql = mysqli_query($mysqli, "SELECT * FROM users WHERE user_id = '{$user_id}'");
    if (mysqli_num_rows($user_sql) > 0) {
        while ($user = mysqli_fetch_array($user_sql)) {
            /* Global Usernames */
            $user_names = $user['user_first_name'] . ' ' . $user['user_last_name'];
            global $user_names;
    ?>
    <?php include('../partial/nav.php'); ?>
    <?php include('../partial/analysical.php'); ?>
    <section class="main_content dashboard_part">

        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-lg-12 p-0">
                    <div class="header_iner d-flex justify-content-between align-items-center">
                        <div class="sidebar_icon d-lg-none">
                            <i class="ti-menu"></i>
                        </div>
                        <div class="serach_field-area">
                            <div class="search_inner">
                                <form action="#">
                                    <div class="search_field">
                                        <input type="text" placeholder="Search here...">
                                    </div>
                                    <button type="submit"> <img src="../public/img/icon/icon_search.svg" alt=""> </button>
                                </form>
                            </div>
                        </div>
                        <div class="header_right d-flex justify-content-between align-items-center">
                            <div class="header_notification_warp d-flex align-items-center">
                                <li>
                                    <a href="#"> <img src="../public/img/icon/bell.svg" alt=""> </a>
                                </li>
                                <li>
                                    <a href="#"> <img src="../public/img/icon/msg.svg" alt=""> </a>
                                </li>
                            </div>
                            <div class="profile_info">
                                <img src="../public/img/user.png" alt="#">
                                <div class="profile_info_iner">
                                    <p>Welcome</p>
                                    <h5><?php echo $user_names ?></h5>
                                    <div class="profile_info_details">
                                        <a href="profile">My Profile <i class="ti-user"></i></a>
                                        <a href="settings">Settings <i class="ti-settings"></i></a>
                                        <a href="logout">Log Out <i class="ti-shift-left"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main_content_iner ">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="single_element">
                            <div class="quick_activity">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="quick_activity_wrap">
                                            <div class="single_quick_activity">
                                                <h4>Total Income</h4>
                                                <h3>Ksh. <span class="counter"><?php echo number_format($total_income,2)?></span> </h3>
                                                
                                            </div>
                                            <div class="single_quick_activity">
                                                <h4>Total Monthly Expences</h4>
                                                <h3>Ksh. <span class="counter"><?php echo number_format($total_expenses,2)?></span> </h3>
                                               
                                            </div>
                                            <div class="single_quick_activity">
                                                <h4>Monthly Expences</h4>
                                                <h3>Ksh. <span class="counter"><?php echo number_format($monthly_expenses,2)?></span> </h3>
                                                
                                            </div>
                                            <div class="single_quick_activity">
                                                <h4>Monthly Net Balance</h4>
                                                <h3>Ksh. <span class="counter"><?php echo number_format($Net_Monthly_Balance,2)?></span> </h3>
                                                <p>Saved <?php echo$Net_Monthly_Balance_percentage?>%</p>
                                            </div>
                                        </div>
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
    <?php }} ?>
</body>

</html>