<script src="https://cdnjs.cloudflare.com/ajax/libs/Faker/3.1.0/faker.min.js"></script>
<link href="https://bimabuy.in/uat/assets/front//css/four_wheeler.css" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />


<section class="main-wrapper">
	<h2 class="text-center basic_heading">FOUR WHEELER INSURANCE </h2>
	<div class="container">
		<div class="row">

			<div class="col-md-12 right-area">

				<form method="POST" action="<?php echo base_url(); ?>tata/fw_controller/car_all_policies_re">
					<input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
					<div class="main-form-content">
						<div class="top-form-content">
							<div class="text-center row">
								<div class="col-md-12">
									<div class="form-check box-icon four_wheeler">
										<label class="form-check-label  icon-lab icon-lab-hover <?php if ($this->session->userdata('car_customer_type') && ($this->session->userdata('car_customer_type') == "Individual")) {
																									echo "icon-lab-hover";
																								} ?>" id="box-icon3" for="exampleRadios3">
											<input class="form-check-input" name="car_customer_type" type="radio" id="exampleRadios3" value="Individual" checked>
											<span>Individual</span>
										</label>
									</div>
									<div class="form-check box-icon four_wheeler" onclick="document.querySelector('#fullname').setAttribute('name', 'org_name'); document.querySelector('#fullname').setAttribute('placeholder', 'Company Name');">
										<label class="form-check-label  icon-lab <?php if ($this->session->userdata('car_customer_type') && ($this->session->userdata('car_customer_type') == "Organization")) {
																						echo "icon-lab-hover";
																					} ?>" id="box-icon4" for="exampleRadios4">
											<input class="form-check-input" name="car_customer_type" type="radio" id="exampleRadios4" value="Organization">
											<span>Non Individual / Organization</span>
										</label>
									</div>
								</div>

							</div>
							<div class="text-center" style="width: 100%;">
								<label for="rtoChange"><input type="checkbox" name="rtoChange" id="rtoChange" class="mr-2">I Have New Vehicle</label>
							</div>
							<!-- <div class="row padding_class">
                                            <div class="col-md-12 text-center">
                                               <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="check_proceed_without_car_no" type="checkbox" id="inlineCheckbox1" value="option1">
                                                    <label class="form-check-label" for="inlineCheckbox1">Proceed Without Car Number</label>
                                                </div> 
                                                
                                            </div>
                                    </div> -->
							<div class="row padding_class ds">
								<!--    <div class="col-md-1"></div>
                                 <div class="col-md-5">
                                   <div class="form-group">
                                      <label>RTO City</label>
   										 <select class="form-control" name="rto_city" id="exampleFormControlSelectrtocity" required>
   										   <option value="">Select RTO City</option>
											  <?php foreach ($rto_city as $rto_data) : ?>
												<option value="<?php echo $rto_data->rto_code; ?>"><?php echo $rto_data->registration_city; ?></option>
												<?php endforeach; ?>
   										 </select>
  									</div>
                                  </div>
                                  <div class="col-md-5">
                                   <div class="form-group">
                                      <label>RTO Code</label>
   										 <option class="form-control" name="rto_code" id="exampleFormControlSelectrtocode" required>
   										   <option value="">Select RTO Code</option>
											  <option value="MH01">MH01</option>
   										 </select>
  									</div>
                                  </div>
                                  <div class="col-md-1"></div> -->

							</div>
							<div class="row padding_class">
								<div class="col-md-4" id="registernosec">
									<div class="form-group">
										<label id="4wLabel">CAR REGISTRATION NUMBER</label>
										<input type="text" class="form-control" name="four_wheeler_registration_number" id="four_wheeler_registration_number" placeholder="REGISTRATION NUMBER" oninput="fourne(this.value);" required>
										<select name="rtoSelect" id="rtoSelect" style="display:none;" class="form-control">
											<option value="">Select RTO</option>
											<?php foreach ($rtos as $rto) : ?>
												<option value="<?= $rto->rto_code?>"><?= $rto->rto_code?> - <?= $rto->rto_location?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<?php
								$today = date("Y-m-d");
								$backdate = date("Y-m-d", strtotime($today . '-15 years -8 months -25 days'));
								// echo $backdate;
								?>
								<div class="col-md-4">
									<div class="form-group">
										<label>REGISTRATION YEAR </label>
										<input type="date" class="form-control" name="car_register_date" max="<?= date('Y-m-d', strtotime("-1 year"))?>" min="<?php echo $backdate; ?>" value="" placeholder="REGISTRATION YEAR DD/MM/YYYY" required="">
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Policy Type</label>
										<select class="form-control" name="car_product_code" id="exampleFormControlSelect2" required>
											<option value="">Select Policy Type</option>
											<option value="PACKAGE">Comprehensive</option>
											<option value="LIABILITY">Liability</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">

										<select class="form-control selectpicker" id="car_make" name="car_make" data-live-search="true" required>
											<option selected="" disabled data-tokens="....">Choose Car</option>
											<?php foreach ($make as $item) { ?>
												<option value="<?php echo $item->make; ?>"><?php echo $item->make; ?> </option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<select class="form-control" id="car_model" name="car_model" required>
											<option disabled data-tokens="">Choose Model</option>
										</select>
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group">

										<select class="form-control " id="car_variant" name="car_variant" data-live-search="true" required>
											<option disabled data-tokens="">Choose Variant</option>
										</select>
									</div>

								</div>
								<div class="col-md-3">
									<div class="form-group">

										<select class="form-control" id="car_fuel_type" name="car_fuel_type" required="">
											<option disabled selected="" value=""> Fuel Type</option>
										</select>
									</div>
								</div>

							</div>
						</div>
						<div class="bottom-form-content row">
							<div class="col-md-3">
								<div class="image-box">
									<img src="https://bimabuy.in/uat/assets/front//img/car.gif">
								</div>
							</div>
							<div class="col-md-6 row">
								<div class="col-md-12">
									<div class="form-group">

										<input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name" required="" >
									</div>
								</div>
								<div class="col-md-12">

									<div class="input-group margin_bottom">
										<div class="input-group-prepend">
											<div class="input-group-text">+91</div>
										</div>
										<input type="tel" placeholder="Mobile Number" name="number" maxlength="10" class="form-control" required="">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">

										<input type="email" class="form-control" id="exampleInputEmail" name="emailuser" aria-describedby="emailHelp" placeholder="Email - Id" required="">

									</div>
								</div>

							</div>
							<div class="col-md-3">
								<button type="submit" class="btn btn-primary form-btn arrow_icon_btn">Proceed To Next Step<i class="fa fa-arrow-right" aria-hidden="true"></i></button>
							</div>
						</div>



					</div>

				</form>

			</div>

		</div>
	</div>
</section>


<script src="<?php echo FRONT_CSSJS_PATH; ?>/js/bajaj_fw.js"></script>
<script>
	var newurl = "<?php echo base_url(); ?>";
	$("#car_make").change(function() {
		// var csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
		var make = $("#car_make").val();
		var data = {
			'make': make
		};
		data[csrf_token_name] = getCookie(csrf_cookie_name);
		if (make == 0) {
			$("#car_model").html('<option value="">No Model for this Make</option>');
		} else {
			$.ajax({
				type: "post",
				url: newurl + "tata/fw_controller/get_fw_model",
				data: data,
				success: function(data) {
					// alert(data);
					$("#car_model").html(data);
				}
			});
		}
	});
</script>
<script>
	var newurl = "<?php echo base_url(); ?>";
	$("#car_model").change(function() {
		// var csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
		var make = $("#car_make").val();
		var model = $("#car_model").val();
		var data = {
			'make': make,
			'model': model
		};
		data[csrf_token_name] = getCookie(csrf_cookie_name);
		if (model == 0) {
			$("#car_variant").html('<option value="">No Variant for this Model</option>');
		} else {
			$.ajax({
				type: "post",
				url: newurl + "tata/fw_controller/get_fw_variant",
				data: data,
				success: function(data) {
					// alert(data);
					$("#car_variant").html(data);
				}
			});
		}
	});
</script>
<script>
	var newurl = "<?php echo base_url(); ?>";
	$("#car_variant").change(function() {
		var make = $("#car_make").val();
		var model = $("#car_model").val();
		var car_variant = $("#car_variant").val();
		car_variant = car_variant.replace("\n", '');
		var data = {
			'make': make,
			'model': model,
			'variant': car_variant
		};
		console.log(data);
		data[csrf_token_name] = getCookie(csrf_cookie_name);
		if (car_variant == 0) {
			$("#car_fuel_type").html('<option value="">No fuel type for this Variant</option>');
		} else {
			$.ajax({
				type: "post",
				url: newurl + "tata/fw_controller/get_fw_fuel",
				data: data,
				success: function(data) {
					// alert(data);
					$("#car_fuel_type").html(data);
				}
			});
		}
	});

	$('#rtoChange').change(function() {
		if ($(this).is(':checked')) {
			$('[name="car_register_date"]').attr('min', '<?= date('Y-m-d', strtotime("-15 days")) ?>');
			$('[name="car_register_date"]').attr('max', '<?= date('Y-m-d') ?>');
			$('#four_wheeler_registration_number').hide();
			$('#four_wheeler_registration_number').val('');
			$('#rtoSelect').show();
			$('#rtoSelect').attr('required', '');
			$('#4wLabel').text('Select RTO');
			$('#four_wheeler_registration_number').removeAttr('required');
			$('option[value="LIABILITY"]').hide();
		} else {
			
			$('[name="car_register_date"]').attr('max', '<?= date('Y-m-d', strtotime("-1 year")) ?>');
			$('[name="car_register_date"]').attr('min', '<?= date('Y-m-d', strtotime("-15 years -8 months -25 days")) ?>');
			$('#rtoSelect').hide();
			$('#rtoSelect').val('');
			$('#rtoSelect').removeAttr('required');
			$('#four_wheeler_registration_number').show();
			$('#4wLabel').text('four WHEELER REGISTRATION NUMBER');
			$('#four_wheeler_registration_number').attr('required', '');
			$('option[value="LIABILITY"]').show();


		}
	});
</script>
<script>
	var text2 = document.getElementById('four_wheeler_registration_number');
	var isprevnumeric = false;
	var len = 0;
	function fourne(val) {

		if (val.length == 0) {
			return len = 0;
		}

		if (len > val.length) {

			len = val.length;
			return 'jbk';
		}
		len = val.length;

		let lstCharecter = val.slice(len - 1, len);

		function isNumeric(num) {
			return !isNaN(num)
		}

		if (isNumeric(lstCharecter)) {
			if (isprevnumeric) {
				var newStr = val.slice(0, -1);
				text2.value = newStr + lstCharecter;
			} else {
				var newStr = val.slice(0, -1);
				text2.value = newStr + "-" + lstCharecter;

				if (text2.value.charAt(0) == '-') {
					text2.value = '';

				}
			}
			isprevnumeric = true;
		} else {
			if (isprevnumeric) {
				var newStr = val.slice(0, -1);
				text2.value = newStr + "-" + lstCharecter;

				if (text2.value.charAt(0) == '-') {
					text2.value = '';
				}
			} else {
				var newStr = val.slice(0, -1);
				text2.value = newStr + lstCharecter;
			}
			isprevnumeric = false;
		}
	}
</script>
<script>
window.onload = () => {
	$('[name=fullname]').val(faker.name.findName());
	$('[name=emailuser]').val(faker.internet.email());
	// $('[name=number]').val(faker.helpers.createCard().phone);
	$('[name=number]').val('<?=rand(6000000000, 9999999999)?>');
};
//   const randomName =  // Caitlyn Kerluke
//   const randomEmail =  // Rusty@arne.info
//   const randomCard = faker.helpers.createCard(); // random contact card containing many properties
</script>