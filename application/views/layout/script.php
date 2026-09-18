<script src="<?php echo base_url('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js');?>"></script>
<?php if (is_student_loggedin()) {?>
<script src="<?php echo base_url('assets/vendor/fuelux/js/fuelux.min.js')?>"></script>
<?php } ?>
<script src="<?php echo base_url('assets/vendor/nanoscroller/nanoscroller.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery-placeholder/jquery-placeholder.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/select2/js/select2.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/fuelux/js/spinner.js');?>"></script>

<!-- Jquery Datatables JS -->
<script src="<?php echo base_url('assets/vendor/datatables/media/js/jquery.dataTables.min.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/datatables/media/js/dataTables.bootstrap.min.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap.min.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.colVis.min.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/datatables/extras/TableTools/RowGroup-1.0.2/js/dataTables.rowGroup.min.js');?>"></script>

<script src="<?php echo base_url('assets/vendor/jquery-appear/jquery-appear.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery-validation/jquery.validate.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/magnific-popup/jquery.magnific-popup.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/screenfull/screenfull.min.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/sweetalert/sweetalert.min.js?v=' . version_combine());?>"></script>
<script src="<?php echo base_url('assets/js/custom.js?v=' . version_combine());?>"></script>
<script src="<?php echo base_url('assets/js/plug.init.js?v=' . version_combine());?>"></script>
<script src="<?php echo base_url('assets/js/app.js?v=' . version_combine())?>"></script>
<script src="<?php echo base_url('assets/js/offline-queue.js?v=' . version_combine())?>"></script>
<script src="<?php echo base_url('assets/js/app.fn.js?v=' . (is_file(FCPATH . 'assets/js/app.fn.js') ? filemtime(FCPATH . 'assets/js/app.fn.js') : version_combine()))?>"></script>

<script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('<?php echo base_url('sw.js'); ?>')
  .catch(function(error) {
    console.log('Service worker registration failed, error:', error);
  });
}
</script>

<script type="text/javascript">
	jQuery.extend(jQuery.validator.messages, {
		required: "<?=translate('this_value_is_required')?>",
		email: "<?=translate('enter_valid_email')?>",
		url: "Please enter a valid URL.",
		date: "Please enter a valid date.",
		dateISO: "Please enter a valid date (ISO).",
		number: "Please enter a valid number.",
		digits: "Please enter only digits.",
		remote: "Please fix this field.",
		creditcard: "Please enter a valid credit card number.",
		equalTo: "Please enter the same value again.",
		accept: "Please enter a value with a valid extension.",
		maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
		minlength: jQuery.validator.format("Please enter at least {0} characters."),
		rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
		range: jQuery.validator.format("Please enter a value between {0} and {1}."),
		max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
		min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
	});
</script>

<!-- Tahsin Notification Audio & Realtime Polling -->
<script type="text/javascript">
(function() {
    var notifAudioUrl = '<?php echo base_url("assets/mp3/ring_2.mp3"); ?>';
    
    // Global notification sound player: repeats 3 times
    window.playTahsinNotification = function(repeats) {
        if (typeof repeats === 'undefined') repeats = 3;
        var playIndex = 0;
        
        function playStep() {
            if (playIndex >= repeats) return;
            var sound = new Audio(notifAudioUrl);
            sound.addEventListener('ended', function() {
                playIndex++;
                if (playIndex < repeats) {
                    setTimeout(playStep, 250); // slight pause between repeats
                }
            });
            var promise = sound.play();
            if (promise !== undefined) {
                promise.catch(function(error) {
                    console.log('Audio autoplay awaiting user gesture:', error);
                    $(document).one('click touchstart keydown', function() {
                        playStep();
                    });
                });
            }
        }
        playStep();
    };

    <?php if (is_director_loggedin() || is_admin_loggedin() || is_superadmin_loggedin()): ?>
    // Background polling for new staff registrations (Director / Admin)
    var lastPendingCount = parseInt(sessionStorage.getItem('tahsin_pending_staff_count') || '-1', 10);
    var checkUrl = '<?php echo base_url("credential_approvals/check_pending_ajax"); ?>';

    function checkNewRegistrations() {
        $.ajax({
            url: checkUrl,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res && typeof res.count !== 'undefined') {
                    // Update badges
                    if (res.count > 0) {
                        $('.header-menu .fa-bell').parent().find('.badge').text(res.count).show();
                    }
                    
                    // If count increased, alert the Director and play sound 3 times!
                    if (lastPendingCount !== -1 && res.count > lastPendingCount) {
                        window.playTahsinNotification(3);
                        var latestApplicant = (res.pending && res.pending[0]) ? res.pending[0] : null;
                        var notifText = latestApplicant ? (latestApplicant.user_name + ' (' + latestApplicant.role_name + ')') : 'New applicant';
                        
                        if (typeof swal !== 'undefined') {
                            swal({
                                toast: true,
                                position: 'top-end',
                                type: 'warning',
                                title: '🔔 New Staff Registration: ' + notifText + ' awaiting your approval!',
                                showConfirmButton: true,
                                confirmButtonText: 'Review Now',
                                confirmButtonClass: 'btn btn-success btn-xs',
                                timer: 12000
                            }).then(function(result) {
                                if (result.value) {
                                    window.location.href = '<?php echo base_url("credential_approvals"); ?>';
                                }
                            });
                        }
                    }
                    lastPendingCount = res.count;
                    sessionStorage.setItem('tahsin_pending_staff_count', res.count);
                }
            },
            error: function() {
                // Ignore transient network errors
            }
        });
    }

    // Run first check after 3 seconds, then poll every 20 seconds
    setTimeout(checkNewRegistrations, 3000);
    setInterval(checkNewRegistrations, 20000);
    <?php endif; ?>
})();
</script>