<script src="../public/js/jquery1-3.4.1.min.js"></script>

<script src="../public/js/popper1.min.js"></script>

<script src="../public/js/bootstrap1.min.js"></script>

<script src="../public/js/metisMenu.js"></script>

<script src="../public/vendors/count_up/jquery.waypoints.min.js"></script>

<script src="../public/vendors/chartlist/Chart.min.js"></script>

<script src="../public/vendors/count_up/jquery.counterup.min.js"></script>

<script src="../public/vendors/swiper_slider/js/swiper.min.js"></script>

<script src="../public/vendors/niceselect/js/jquery.nice-select.min.js"></script>

<script src="../public/vendors/owl_carousel/js/owl.carousel.min.js"></script>

<script src="../public/vendors/gijgo/gijgo.min.js"></script>

<script src="../public/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="../public/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="../public/vendors/datatable/js/dataTables.buttons.min.js"></script>
<script src="../public/vendors/datatable/js/buttons.flash.min.js"></script>
<script src="../public/vendors/datatable/js/jszip.min.js"></script>
<script src="../public/vendors/datatable/js/pdfmake.min.js"></script>
<script src="../public/vendors/datatable/js/vfs_fonts.js"></script>
<script src="../public/vendors/datatable/js/buttons.html5.min.js"></script>
<script src="../public/vendors/datatable/js/buttons.print.min.js"></script>
<script src="../public/js/chart.min.js"></script>

<script src="../public/vendors/progressbar/jquery.barfiller.js"></script>

<script src="../public/vendors/tagsinput/tagsinput.js"></script>

<script src="../public/vendors/text_editor/summernote-bs4.js"></script>
<script src="../public/vendors/apex_chart/apexcharts.js"></script>

<script src="../public/js/custom.js"></script>


<script src="../public/js/active_chart.js"></script>
<script src="../public/vendors/apex_chart/radial_active.js"></script>
<script src="../public/vendors/apex_chart/stackbar.js"></script>
<script src="../public/vendors/apex_chart/area_chart.js"></script>
<script src="../public/vendors/apex_chart/bar_active_1.js"></script>
<script src="../public/vendors/chartjs/chartjs_active.js"></script>
<!-- Sweet Alerts -->
<script src="../public/js/toastr.min.js"></script>
<!-- Init  Alerts -->
<?php if (isset($success)) { ?>
    <!-- Pop Success Alert -->
    <script>
        toastr.success('<?php echo $success; ?>')
    </script>

<?php }
if (isset($err)) { ?>
    <script>
        toastr.error('<?php echo $err; ?>')
    </script>
<?php }
if (isset($info)) { ?>
    <script>
        toastr.warning('<?php echo $info; ?>')
    </script>
<?php }
?>
