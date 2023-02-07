<?php
session_start();
include '../config/config.php';
include '../config/codeGen.php';
include '../config/checklogin.php';
include '../fuctions/expense.php';
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
                            <!-- Button trigger modal -->
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Add New Expense
                                </button>
                            </div>


                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">New Expense</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="post">
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label">Expense Name</label>
                                                    <input type="hidden" class="form-control" id="exampleFormControlInput1" name="user_id" value="<?php echo $user_id ?>">
                                                    <input type="text" required class="form-control" id="exampleFormControlInput1" name="category_name" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label">Expense Budget</label>
                                                    <input type="number" min="1" required class="form-control" id="exampleFormControlInput1" required name="category_init_expense" value="">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label">Expense Category</label>
                                                    <select class="form-select" id="floatingSelect" name="category_status" aria-label="Floating label select example">

                                                        <option value="daily">Daily</option>
                                                        <option value="weekly">Weekly</option>
                                                        <option value="monthly">Monthly</option>
                                                        <option value="yearly">Yearly</option>
                                                    </select>

                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label">Expense Amount</label>
                                                    <input type="number" required class="form-control" required id="exampleFormControlInput1" min="1" name="expense_cost">
                                                </div>
                                                <?php
                                                $sql = "SELECT * FROM  fiscal_month AS fm   WHERE fm.fm_status='Active'";
                                                $result = mysqli_query($mysqli, $sql);
                                                if (mysqli_num_rows($result) > 0) { ?>
                                                    <div class="d-flex mb-3 justify-content-md-left">
                                                        <button type="submit" class="btn btn-outline-primary" name="add_expense">Add Expense</button>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="d-flex mb-3 justify-content-md-left">
                                                        <button type="submit" class="btn btn-outline-primary" name="add_expense_first">Add First Expense</button>
                                                    </div>
                                                <?php } ?>


                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Expense Name</th>
                                        <th>Expense Type</th>
                                        <th>Expense Date</th>
                                        <th>Expense Budget</th>
                                        <th>Expense cost</th>

                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    $user_id = mysqli_escape_string($mysqli, $_SESSION['user_id']);
                                    $user_sql = mysqli_query($mysqli, "SELECT * FROM expenses AS ex INNER JOIN fiscal_month AS fm ON fm.fm_id=ex.expense_fm_id INNER JOIN categories AS ca ON ca.category_id=ex.expense_category_id  WHERE ex.expense_user_id = '{$user_id}' ORDER BY ex.expense_date DESC");
                                    if (mysqli_num_rows($user_sql) > 0) {
                                        while ($user = mysqli_fetch_array($user_sql)) { ?>
                                            <tr>
                                                <td>
                                                    <?php echo $count ?>
                                                </td>
                                                <td>
                                                    <?php echo $user['category_name'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $user['category_status'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $user['expense_date'] ?>
                                                </td>
                                                <td>
                                                    Ksh.<?php echo number_format($user['category_init_expense'], 2) ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($user['expense_cost'], 2) ?>
                                                </td>



                                                <td>
                                                    <a data-bs-toggle="modal" data-bs-target="#update_<?php echo $user['expense_id'] ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <a data-bs-toggle="modal" data-bs-target="#delete_<?php echo $user['expense_id'] ?>" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i> Edit</a>
                                                </td>
                                            </tr>
                                            <?php $count = $count + 1; ?>

                                            <!--Edit  Modal -->
                                            <div class="modal fade" id="update_<?php echo $user['expense_id'] ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Expense</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" method="post">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput1" class="form-label">Expense Name</label>
                                                                    <input type="hidden" class="form-control" id="exampleFormControlInput1" name="expense_category_id" value="<?php echo $user['expense_category_id'] ?>">
                                                                    <input type="text" required class="form-control" id="exampleFormControlInput1" name="category_name" value="<?php echo $user['category_name'] ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput1" class="form-label">Expense Budget</label>
                                                                    <input type="number" min="1" required class="form-control" id="exampleFormControlInput1" required name="category_init_expense" value="<?php echo $user['category_init_expense'] ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput1" class="form-label">Expense Category</label>
                                                                    <select class="form-select" id="floatingSelect" name="category_status" aria-label="Floating label select example">
                                                                        <option selected value="<?php echo $user['category_status'] ?>"><?php echo $user['category_status'] ?></option>
                                                                        <option value="daily">Daily</option>
                                                                        <option value="weekly">Weekly</option>
                                                                        <option value="monthly">Monthly</option>
                                                                        <option value="yearly">Yearly</option>
                                                                    </select>

                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput1" class="form-label">Expense Amount</label>
                                                                    <input type="number" required class="form-control" required id="exampleFormControlInput1" min="1" name="expense_cost" value="<?php echo $user['expense_cost'] ?>">
                                                                </div>

                                                                <div class="d-flex mb-3 justify-content-md-left">
                                                                    <button type="submit" class="btn btn-outline-primary" name="update_expense">Update Expense</button>
                                                                </div>



                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!--Delete  Modal -->
                                            <div class="modal fade" id="delete_<?php echo $user['expense_id'] ?>" tabindex="-2" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p></p>
                                                            <form action="" method="post">
                                                                <div class="mb-3">

                                                                    <input type="hidden" class="form-control" id="exampleFormControlInput1" name="expense_category_id" value="<?php echo $user['expense_category_id'] ?>">

                                                                </div>
                                                                <p class="lead d-flex text-danger mb-4 fs-8">
                                                                    Do you want to Delete <?php echo $user['category_name'] ?> ?
                                                                </p>

                                                                <div class="d-flex mb-3 justify-content-md-left">
                                                                   
                                                                    <button type="submit" class="btn btn-outline-danger" name="delete_expense">Yes</button>
                                                                </div>



                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                    <?php

                                        }
                                    } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <?php include('../partial/footer.php') ?>
            </section>
            <?php include('../partial/script.php') ?>
    <?php }
    } ?>
</body>

</html>