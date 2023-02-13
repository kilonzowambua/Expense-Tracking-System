<?php
#Create a New Expense With No Existing Fiscal Month
if (isset($_POST['add_expense_first']) || isset($_POST['add_expense'])) {
    #Declare all required variables
    $fm_year = date('Y');
    $fm_month = date('n');
    $user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);
    #Get user Salary
    $user_sql = mysqli_query($mysqli, "SELECT * FROM users WHERE user_id = '{$user_id}'");
    if (mysqli_num_rows($user_sql) > 0) {
        while ($user = mysqli_fetch_array($user_sql)) {
            $salary = $user['user_current_salary'];
            global  $salary;
            $category_name = mysqli_real_escape_string($mysqli, $_POST['category_name']);
            $category_init_expense = mysqli_real_escape_string($mysqli, $_POST['category_init_expense']);
            $category_status = mysqli_real_escape_string($mysqli, $_POST['category_status']);
            $expense_cost = mysqli_real_escape_string($mysqli, $_POST['expense_cost']);

            #Check wherether Its first Time and add Month and Year
            if (isset($_POST['add_expense_first'])) {
                #First Statement
                $First_query = mysqli_query($mysqli, "INSERT INTO `fiscal_month`( `fm_year`, `fm_month`, `salary`) VALUES ('{$fm_year}','{$fm_month}','{$salary}')");
                #Second Statement
                $Second_query = mysqli_query($mysqli, "INSERT INTO `categories`(`category_name`, `category_init_expense`, `category_status`) VALUES ('{$category_name}','{$category_init_expense}','{$category_status}')");
                #IF this two Queries are True Precuud to Add Expense
                if ($First_query && $Second_query) {
                    $user_sql = mysqli_query($mysqli, "SELECT *FROM categories AS cat CROSS JOIN fiscal_month AS fm WHERE fm.fm_status='Active' AND fm.fm_year='{$fm_year}'AND fm.fm_month='{$fm_month}' AND cat.category_name='{$category_name}' AND cat.Category_init_expense='{$category_init_expense}' AND cat.category_status='{$category_status}'");
                    if (mysqli_num_rows($user_sql) > 0) {
                        while ($id = mysqli_fetch_array($user_sql)) {
                            #ids for Category and Fiscial Year
                            $fm_id = $id['fm_id'];
                            $category_id = $id['category_id'];
                            #Third Statements
                            $Second_query = mysqli_query($mysqli, "INSERT INTO `expenses`(`expense_category_id`, `expense_fm_id`, `expense_user_id`, `expense_cost`) VALUES ('{$category_id}','{$fm_id}','{$user_id}','{$expense_cost}')");
                            #Display Alert After That
                            if ($Second_query) {
                                $_SESSION['success'] = 'First Expense Is Added';
                            } else {
                                $err = "Failed !Try Again";
                            }
                        }
                    }
                }
            } elseif (isset($_POST['add_expense'])) {

                #Second Statement
                $first_query = mysqli_query($mysqli, "INSERT INTO `categories`(`category_name`, `category_init_expense`, `category_status`) VALUES ('{$category_name}','{$category_init_expense}','{$category_status}')");
                #IF this two Queries are True Precuud to Add Expense
                if ($first_query) {
                    $user_sql = mysqli_query($mysqli, "SELECT *FROM categories AS cat CROSS JOIN fiscal_month AS fm WHERE fm.fm_status='Active' AND fm.fm_year='{$fm_year}'AND fm.fm_month='{$fm_month}' AND cat.category_name='{$category_name}' AND cat.Category_init_expense='{$category_init_expense}' AND cat.category_status='{$category_status}'");
                    if (mysqli_num_rows($user_sql) > 0) {
                        while ($id = mysqli_fetch_array($user_sql)) {
                            #ids for Category and Fiscial Year
                            $fm_id = $id['fm_id'];
                            $category_id = $id['category_id'];
                            #Third Statements
                            $Second_query = mysqli_query($mysqli, "INSERT INTO `expenses`(`expense_category_id`, `expense_fm_id`, `expense_user_id`, `expense_cost`) VALUES ('{$category_id}','{$fm_id}','{$user_id}','{$expense_cost}')");
                            #Display Alert After That
                            if ($Second_query) {
                                $_SESSION['success'] = 'First Expense Is Added';
                            } else {
                                $err = "Failed !Try Again";
                            }
                        }
                    }
                }
            }
        }
    }
}

#Update Expense 
if(isset($_POST['update_expense'])){
 #Declare all required variables
 $expense_category_id = mysqli_real_escape_string($mysqli, $_POST['expense_category_id']);
 $category_name = mysqli_real_escape_string($mysqli, $_POST['category_name']);
 $category_init_expense = mysqli_real_escape_string($mysqli, $_POST['category_init_expense']);
 $category_status = mysqli_real_escape_string($mysqli, $_POST['category_status']);
 $expense_cost = mysqli_real_escape_string($mysqli, $_POST['expense_cost']);

 $query=mysqli_query($mysqli,"UPDATE  categories AS cat JOIN expenses AS ex
ON cat.category_id = ex.expense_category_id
SET cat.category_name = '{$category_name}',
cat.category_init_expense = '{$category_init_expense}',
cat.category_status = '{$category_status}',
ex.expense_cost = '{$expense_cost}'
WHERE ex.expense_category_id='{$expense_category_id}'");
if ($query) {
    $_SESSION['success'] = 'Expense Is Updated';
   
}else{
    $err = "Failed !Try Again";
}

}

#Delete Expense
if(isset($_POST['delete_expense'])){

    #Declare Category Id
    $category_id =mysqli_real_escape_string($mysqli,$_POST['expense_category_id']);
    #Run Query
    $query=mysqli_query($mysqli,"DELETE  cat,ex  FROM categories AS cat JOIN expenses AS ex
    ON cat.category_id = ex.expense_category_id WHERE ex.expense_category_id='{$category_id}'");
if ($query) {
    $_SESSION['success'] = 'Expense Is Deleted';
   
}else{
    $err = "Failed !Try Again";
}

}

