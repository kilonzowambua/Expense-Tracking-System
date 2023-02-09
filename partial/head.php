<head>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<title>Expense Tracking System</title>
<link rel="icon" href="../public/img/logo.png" type="image/png">

<link rel="stylesheet" href="../public/css/bootstrap1.min.css" />

<link rel="stylesheet" href="../public/vendors/themefy_icon/themify-icons.css" />

<link rel="stylesheet" href="../public/vendors/swiper_slider/css/swiper.min.css" />

<link rel="stylesheet" href="../public/vendors/select2/css/select2.min.css" />

<link rel="stylesheet" href="../public/vendors/niceselect/css/nice-select.css" />

<link rel="stylesheet" href="../public/vendors/owl_carousel/css/owl.carousel.css" />

<link rel="stylesheet" href="../public/vendors/gijgo/gijgo.min.css" />

<link rel="stylesheet" href="../public/vendors/font_awesome/css/all.min.css" />
<link rel="stylesheet" href="../public/vendors/tagsinput/tagsinput.css" />

<link rel="stylesheet" href="../public/vendors/datatable/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="../public/vendors/datatable/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="../public/vendors/datatable/css/buttons.dataTables.min.css" />

<link rel="stylesheet" href="../public/vendors/text_editor/summernote-bs4.css" />

<link rel="stylesheet" href="../public/vendors/morris/morris.css">

<link rel="stylesheet" href="../public/vendors/material_icon/material-icons.css" />

<link rel="stylesheet" href="../public/css/metisMenu.css">

<link rel="stylesheet" href="../public/css/style1.css" />
<link rel="stylesheet" href="../public/css/colors/default.css" id="colorSkinCSS">
<link href="../public/css/toastr.min.css" rel="stylesheet" type="text/css" />
<?php
    /* Alert Sesion Via Alerts */
    if (isset($_SESSION['success'])) {
        $success = $_SESSION['success'];
        unset($_SESSION['success']);
    }
    ?>
</head>
