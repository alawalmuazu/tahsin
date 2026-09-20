(function($) {
	'use strict';
	$(document).ready(function () {
		$(document).on('change', '#branch_id', function() {
			var branchID = $(this).val();
			
			$.ajax({
				url: base_url + "ajax/getLoginAuto",
				type: 'POST',
				dataType: 'json',
				data: { branch_id: branchID },
				success: function (data) {
					if(data.student == 1){
						$('#stuLogin').hide(300);
					} else {
						$('#stuLogin').show(300);
					}
					if(data.guardian == 1){
						$('#grdLogin').hide();
						$('#grdAutoLogin').show(300);
					} else {
						$('#grdLogin').hide(300);
						$('#grdAutoLogin').hide();
					}
				}
			});

			$.ajax({
				url: base_url + "ajax/getDataByBranch",
				type: 'POST',
				data: {
					branch_id: branchID,
					table: 'section'
				},
				success: function (data) {
					$('#section_id').html(data);
					$('#class_id').html('<option value="">Select Section First</option>');
				}
			});

			$.ajax({
				url: base_url + "ajax/getDataByBranch",
				type: 'POST',
				data: {
					branch_id: branchID,
					table: 'student_category'
				},
				success: function (data) {
					$('#category_id').html(data);
				}
			});
			
			$.ajax({
				url: base_url + "ajax/getDataByBranch",
				type: 'POST',
				data: {
					branch_id: branchID,
					table: 'transport_route'
				},
				success: function (data) {
					$('#route_id').html(data);
				}
			});
			
			$.ajax({
				url: base_url + "ajax/getDataByBranch",
				type: 'POST',
				data: {
					branch_id: branchID,
					table: 'hostel'
				},
				success: function (data) {
					$('#hostel_id').html(data);
				}
			});
			
			$.ajax({
				url: base_url + "ajax/getDataByBranch",
				type: 'POST',
				data: {
					branch_id: branchID,
					table: 'parent'
				},
				success: function (data) {
					$('#parent_id').html(data);
				}
			});

			$.ajax({
				url: base_url + "custom_field/getFieldsByBranch",
				type: 'POST',
				data: {
					branch_id: branchID,
					belongs_to: 'student'
				},
				success: function (data) {
					$('#customFields').html(data).hide(0).show(300);
					$('#customFields [data-plugin-selecttwo]').each(function() {
						var $this = $(this);
						$this.themePluginSelect2({});
					});
					$('#customFields [data-plugin-datepicker]').each(function() {
						var $this = $(this);
						$this.themePluginDatePicker({});
					});
				}
			});
		});
		
		$(document).on('change', '#route_id', function() {
			var routeID = $(this).val();
			$.ajax({
				url: base_url + "transport/get_vehicle_by_route",
				type: 'POST',
				data: {
					routeID: routeID
				},
		        beforeSend: function () {
		            $('#select2-vehicle_id-container').parent().addClass('select2loading');
		        },
		        success: function (data){
		            $('#vehicle_id').html(data);
		        },
		        complete: function () {
		            $('#select2-vehicle_id-container').parent().removeClass('select2loading');
		        }
			});

			$.ajax({
				url: base_url + "transport/getStoppagePoinByRoute",
				type: 'POST',
				data: {
					routeID: routeID
				},
		        beforeSend: function () {
		            $('#select2-stoppage_point_id-container').parent().addClass('select2loading');
		        },
		        success: function (data){
		            $('#stoppage_point_id').html(data);
		        },
		        complete: function () {
		            $('#select2-stoppage_point_id-container').parent().removeClass('select2loading');
		        }
			});
		});
		
		$(document).on('change', '#hostel_id', function() {
			var hostelID = $(this).val();
			$.ajax({
				url: base_url + "hostels/getRoomByHostel",
				type: 'POST',
				data: {
					hostel_id: hostelID
				},
				success: function (data) {
					$('#room_id').html(data);
				}
			});
		});

		function refreshSelect2($el) {
			if ($el && $el.length && $el.data('select2')) {
				$el.trigger('change.select2');
			}
		}

		var lgaRequests = {};

		function loadLgasForState(state, $target, selected) {
			if (!$target || !$target.length) {
				return;
			}
			var key = $target.attr('id') || $target.attr('name') || 'lga';
			if (lgaRequests[key] && lgaRequests[key].abort) {
				lgaRequests[key].abort();
			}
			lgaRequests[key] = $.ajax({
				url: base_url + 'ajax/getLgaByState',
				type: 'POST',
				data: {
					state: state || '',
					selected: selected || ''
				},
				success: function (html) {
					$target.html(html);
					if (!selected) {
						$target.val('');
					}
					refreshSelect2($target);
				}
			});
		}

		$(document).on('change', '[data-lga-target]', function () {
			var $target = $($(this).attr('data-lga-target'));
			loadLgasForState($(this).val(), $target, '');
		});

		$(document).on('change', '[data-class-target]', function () {
			var sectionId = $(this).val();
			var $class = $($(this).attr('data-class-target'));
			if (!$class.length) {
				return;
			}
			if (!sectionId) {
				$class.html('<option value="">Select Section First</option>');
				refreshSelect2($class);
				return;
			}
			$.ajax({
				url: base_url + 'ajax/getClassBySection',
				type: 'POST',
				data: { section_id: sectionId },
				beforeSend: function () {
					$('#select2-class_id-container').parent().addClass('select2loading');
				},
				success: function (html) {
					$class.html(html);
					refreshSelect2($class);
				},
				complete: function () {
					$('#select2-class_id-container').parent().removeClass('select2loading');
				}
			});
		});

		function tuitionFeeAmount() {
			var $amt = $('#tuition_amount');
			if (!$amt.length) {
				return 2500000;
			}
			return parseFloat($amt.data('school-fee')) || parseFloat($amt.attr('max')) || 2500000;
		}

		function tuitionAlreadyPaid() {
			var $amt = $('#tuition_amount');
			if (!$amt.length) {
				return 0;
			}
			return parseFloat($amt.data('already-paid')) || 0;
		}

		function formatTuitionMoney(n) {
			var value = Number(n) || 0;
			return value.toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2});
		}

		function updateTuitionUI() {
			var $amt = $('#tuition_amount');
			if (!$amt.length) {
				return;
			}
			var fee = tuitionFeeAmount();
			var paid = tuitionAlreadyPaid();
			var remainingCap = Math.max(0, fee - paid);
			var plan = $('#tuition_plan').length ? $('#tuition_plan').val() : 'installment';
			if (paid > 0) {
				plan = 'installment';
				$amt.prop('readonly', false).attr('max', remainingCap);
			} else if (plan === 'full') {
				$amt.val(fee).prop('readonly', true).attr('max', fee);
			} else {
				$amt.prop('readonly', false).attr('max', fee);
				if (parseFloat($amt.val()) >= fee) {
					$amt.val('');
				}
			}
			var now = parseFloat($amt.val()) || 0;
			if (plan !== 'full' && now > remainingCap) {
				now = remainingCap;
				$amt.val(now > 0 ? now : '');
			}
			var balance = Math.max(0, remainingCap - (plan === 'full' ? remainingCap : now));
			if (plan === 'full' && paid <= 0) {
				balance = 0;
			}
			$('#tuition_balance_hint').text('Balance: \u20A6' + formatTuitionMoney(balance));
		}

		$(document).on('change', '#tuition_plan', updateTuitionUI);
		$(document).on('input change', '#tuition_amount', function () {
			if (!$('#tuition_plan').length || $('#tuition_plan').val() === 'installment' || tuitionAlreadyPaid() > 0) {
				updateTuitionUI();
			}
		});

		function refreshSchoolFeeFromSettings() {
			var $amt = $('#tuition_amount');
			if (!$amt.length) {
				return;
			}
			$.ajax({
				url: base_url + 'school_fees/resolve',
				type: 'POST',
				dataType: 'json',
				data: {
					section_id: $('#section_id').val() || 0,
					category_id: $('#category_id').val() || 0,
					branch_id: $('input[name="branch_id"]').val() || 0
				},
				success: function (res) {
					if (!res || res.status !== 'success') {
						return;
					}
					var fee = parseFloat(res.amount) || 0;
					$amt.data('school-fee', fee).attr('max', fee);
					$('#school_fee_display').val(res.formatted || fee);
					updateTuitionUI();
				}
			});
		}

		$(document).on('change', '#section_id, #category_id', refreshSchoolFeeFromSettings);

		if ($('#tuition_amount').length) {
			updateTuitionUI();
		}
	});
})(jQuery);

function studentQuickView(id, elem) {
	var btn = $(elem);
    $.ajax({
        url: base_url + 'student/quickDetails',
        type: 'POST',
        data: {enroll_id: id},
        dataType: 'json',
        beforeSend: function () {
            btn.button('loading');
        },
        success: function (res) {
            $("#quick_image").attr("src", res.photo);
            $('#quick_full_name').html(res.full_name);
            $('#quick_category').html(res.student_category);
            $('#quick_gender').html(res.gender);
            $('#quick_register_no').html(res.register_no);
            $('#quick_roll').html(res.roll);
            $('#quick_admission_date').html(res.admission_date);
            $('#quick_date_of_birth').html(res.birthday);
            $('#quick_blood_group').html(res.blood_group);
            $('#quick_religion').html(res.religion);
            $('#quick_email').html(res.email);
            $('#quick_mobile_no').html(res.mobileno);
            $('#quick_state').html(res.state);
            $('#quick_address').html(res.address);
            mfp_modal('#quickView');
            btn.tooltip("hide");
        },
        error: function (xhr) {
            btn.button('reset');
        },
        complete: function () {
            btn.button('reset');

        }
    });
}
