<div class="modal-append-to"></div>

<div class="black-over">

<div class="overlay"></div>

</div>

<div id="Popup" class="popup-wrapper" style="display: none;">

    <div class="popup-loading">

        <div class="loading-container">

            ĐANG XỬ LÝ DỮ LIỆU...

        </div>

    </div>

</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!--<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"

integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.25/daterangepicker.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" >

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.js"></script>

<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<!--<script src="https://js.pusher.com/6.0/pusher.min.js"></script>-->

<!--<script src="<?php echo base_url(); ?>style/js/dropzone/dropzone.min.js"></script>-->

<script src="<?php echo base_url(); ?>style/js/common/shortcut.min.js" type="text/javascript"></script>
<!--jQuery Custom Scroller CDN -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#dismiss, .overlay').on('click', function () {
            $('#sidebar').removeClass('active');
            $('.overlay').fadeOut();
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').addClass('active');
            $('.overlay').fadeIn();
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>

<!--<script src="<?php echo base_url(); ?>style/js/common_view/filter_tbl_set_equal_height.min.js" type="text/javascript"></script>-->

<!--<script src="<?php echo base_url(); ?>vendors/build/js/custom.min.js" type="text/javascript"></script>-->

<!--<script src="<?php echo base_url(); ?>style/js/common_view/view_contact_star.min.js" type="text/javascript"></script>-->

<?php if (ENVIRONMENT == 'production') { ?>

<!--    <script src="<?php echo base_url(); ?>style/js3/built_obfuscated.min.js?ver=<?php echo _VER_CACHED_; ?>" type="text/javascript"></script>-->

    <script src="<?php echo base_url(); ?>style/js3/built.js?ver=<?php echo _VER_CACHED_; ?>" type="text/javascript"></script>

<?php } else { ?>

    <script src="<?php echo base_url(); ?>style/js3/built.js?<?php echo time(); ?>" type="text/javascript"></script>

<?php } ?>

<?php if ($this->controller == 'sale') { ?>

    <?php if ($time_remaining > 0) { ?>

        <div class="flip-clock"></div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.min.js"></script>

        <script type="text/javascript">

            var distance = <?php echo $time_remaining; ?>;

            var clock = $('.flip-clock').FlipClock(distance, {

                clockFace: 'DailyCounter',

                countdown: true

            });

        </script>

    <?php } ?>

<?php } ?>

<?php if ($this->role_id == 12) { ?>
    <?php if ($this->controller != 'student') { ?>
        <script type="text/javascript">
            $('.show-with-contact').css("display", "none");

            $(document).on('show.bs.modal', '.modal_with_contact', function () {
                $('.show-with-contact').css("display", "block");
                $('.show-with-item').css("display", "none");
            });
            $(document).on('hide.bs.modal', '.modal_with_contact', function () {
                $('.show-with-item').css("display", "block");
                $('.show-with-contact').css("display", "none");
            });
        </script>
    <?php } ?>
<?php } ?>



