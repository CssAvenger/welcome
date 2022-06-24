<style>
	input:invalid,
	select:invalid {
		border-color: red;
	}

	input:valid,
	select:valid {
		border-color: #ccc;
	}

	.selectedRadio {
		background-color: royalblue;
		color: white;
	}
</style>
<link href="https://bimabuy.in/uat/assets/front//css/four_wheeler.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

<div id="loader">
	<div class="loader loader-danger custom-loader"></div>
	<p class="text-center text-white loader-text">Processing Data. Please Wait...</p>
</div>
<div class="all_policy_detail personal">
	<section class="medical_details birthday_details">
		<h3 class="text-center color_black"> Great Choice! A few more details to go.</h3>
		<div class="container col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="w-100 ">
				</div>

				<div class="personal_details_div">

					<div class="details_div">
						<form id="carprsnl_detail" method="POST">
							<input type="hidden" name="" />
							<input type="hidden" name="vehicle_code" value="<?php echo $vehicle_code; ?>" />
							<div class="accordion main-design-collapse" id="accordionExample">

								<div class="accordion-item">
									<h2 class="accordion-header" id="headingOne">
										<button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											Car Details
										</button>
									</h2>
									<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<div class="selected_bike_details">
												<div class="selected_bike_details_content">
													<p>Car Number : <span><?= ($caseType == 'new_vehicle') ? 'NEW' : $four_wheeler_registration_number; ?> </span> </p>
												</div>
											</div>

											<div class="selected_bike_details">
												<div class="selected_bike_details_content">
													<p>Make : <span> <?php echo $make; ?></span> </p>
												</div>
											</div>
											<div class="selected_bike_details">
												<div class="selected_bike_details_content">
													<p>Model : <span> <?php echo $model; ?></span> </p>
												</div>
											</div>
											<div class="selected_bike_details">
												<div class="selected_bike_details_content">
													<p>Variant : <span> <?php echo $variant; ?></span> </p>
												</div>
											</div>
											<div class="selected_bike_details">
												<div class="selected_bike_details_content">
													<p>Registration Date : <span> <?php echo $car_register_date; ?></span> </p>
												</div>
											</div>
											<?php if($caseType != 'new_vehicle' and $car_product_code == 'PACKAGE'): ?>
											<div class="selected_bike_details">
												<div class="selected_bike_details_content">
													<p class="width_auto" style="line-height: initial; margin-right: 2px;">Claim last year : <span class="float_none"><?php if ($isClaimInLastYear == '0' or $isClaimInLastYear == "NO") {
																																											echo "No";
																																										} else {
																																											echo "Yes";
																																										} ?></span> </p>
													<p class="width_auto" style="line-height: initial;"> NCB : <span class="float_none">INR<?php if ($ncbdiscount == "null") {
																																				echo "0";
																																			} else {
																																				echo round($ncbdiscount);
																																			} ?></span> </p>
												</div>
											</div>
											<?php endif; ?>

										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingTwo">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
											Cost Break Up
										</button>
									</h2>
									<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<div class="selected_bike_details">
												<div class="selected_bike_details_content">
													<p>IDV Premium </p>
												</div>
												<span>INR <?php echo $idv; ?></span>
											</div>

											<div class="selected_bike_details">
												<div class="selected_bike_details_content">
													<p>Own Damage Premium </p>
												</div>
												<span>INR<?php echo $own_damage; ?></span>
											</div>
											<!-- <div class="selected_bike_details">                                    
                                    	<div class="selected_bike_details_content">
                                       		 <p>NCB  </p>
                                    	</div>
                                    		<span>INR<?php if ($ncbdiscount == "null") {
															echo "0";
														} else {
															echo $ncbdiscount;
														} ?></span>
                                	</div> -->
											<div class="selected_bike_details">
												<div class="selected_bike_details_content">
													<p>Basic 3rd Party Premium</p>
												</div>
												<span>INR<?php echo $third_party_premium; ?></span>
											</div>
											<div class="selected_bike_details">
												<div class="selected_bike_details_content">
													<p>CPA</p>
												</div>
												<span>INR<?php echo $pa_owner_driver; ?></span>
											</div>

											<div class="selected_bike_details">
												<div class="selected_bike_details_content">
													<p>Net Premium </p>
												</div>
												<span>INR<?php echo $netpremium; ?></span>
											</div>

											<?php if ($addons_premium) : ?>
												<div class="selected_bike_details">
													<div class="selected_bike_details_content">
														<p class="fw-5  fontbold">Addons Premium </p>
													</div>
													<span>INR<?php echo $addons_premium; ?></span>
												</div>
											<?php endif; ?>
											<?php if ($cng_premium) : ?>
												<div class="selected_bike_details">
													<div class="selected_bike_details_content">
														<p class="fw-5  fontbold">CNG Premium </p>
													</div>
													<span>INR<?php echo $cng_premium; ?></span>
												</div>
											<?php endif; ?>
											<?php if ($ll_paid_premium) : ?>
												<div class="selected_bike_details">
													<div class="selected_bike_details_content">
														<p class="fw-5  fontbold">Limited Liability Premium </p>
													</div>
													<span>INR<?php echo $ll_paid_premium; ?></span>
												</div>
											<?php endif; ?>
											<?php if ($unnamed_premium) : ?>
												<div class="selected_bike_details">
													<div class="selected_bike_details_content">
														<p class="fw-5  fontbold">Un-named Passenger Premium </p>
													</div>
													<span>INR<?php echo $unnamed_premium; ?></span>
												</div>
											<?php endif; ?>
											<?php if ($paid_driver_premium) : ?>
												<div class="selected_bike_details">
													<div class="selected_bike_details_content">
														<p class="fw-5  fontbold">CPA (Paid driver) Premium </p>
													</div>
													<span>INR<?php echo $paid_driver_premium; ?></span>
												</div>
											<?php endif; ?>

											<div class="selected_bike_details">
												<div class="selected_bike_details_content">
													<p class="fw-5 color_black fontbold">Final Premium </p>
												</div>
												<span class="color_black">INR<?php echo $duepremium; ?></span>
											</div>

										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingThree">
										<button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
											Proposal Creation
										</button>
									</h2>
									<div id="collapseThree" class="accordion-collapse collapse " aria-labelledby="headingThree" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<div class="form-row">
												<div class="col">
													<label>Email </label>
													<input required data-title='Email' type="email" class="form-control" name="emailuser" placeholder="Email id" value="<?php if ($emailuser) {
																																													echo $emailuser;
																																												} ?>">

												</div>
												<div class="col">
													<label>Mobile Number </label>

													<div class="input-group mb-3">
														<div class="input-group-prepend">
															<div class="input-group-text bg_none">+91</div>
														</div>
														<input required data-title='Mobile' type="text" class="form-control" pattern="[6-9][\d]{9}" name="number" id="mobile_no" value="<?php if ($number) {
																																										echo $number;
																																									} ?>" id="inlineFormInputGroup" placeholder="Mobile Number" required />
													</div>
													<span class="error-message"><?php echo form_error('phone_number'); ?></span>
												</div>

											</div>
											<?php if ($car_customer_type == 'Organization') : ?>
												<div class="form-row">
													<div class="col">
														<label for="Organization_name">Organization Name</label>
														<input type="text" name="Organization_name" id="Organization_name" class="form-control" required value="<?php echo $org_name; ?>">
													</div>
													<div class="col">
														<label for="gstin">GSTIN Number</label>
														<input type="text" name="gstin" id="gstin" class="form-control" required value="<?php echo $gstin; ?>">
													</div>
												</div>
											<?php endif; ?>
											<?php if(true/* $car_customer_type == 'Individual' */):?>
													<?php if( $car_customer_type == 'Individual' ):?>
											<div class="form-row">
												<div class="col-2">
													<label for="exampleFormControlSelect1">Salutation</label>

													<select required data-title='Salutation' class="form-control" name="salutation" id="exampleFormControlSelect1" onchange="getGender(this)">
														<?= ($car_customer_type == 'Individual') ? selectOptions(getValueDB('tata_salutation_4w'), 'name', 'name') : ''?>
														<option style="<?= ($car_customer_type == 'Individual') ? 'display:none;' : '' ?>" value="M/S">M/S</option>
													</select>
												</div>
												<div class="col">
													<label>First Name </label>
													<input value="<?= $first_name ?  $first_name : $fullname?>" <?= $car_customer_type == 'Individual' ? 'required' : '' ?> data-title='First Name' type="text" class="form-control" name="first_name" placeholder="First name" value="<?php if ($fullname) {
														echo $fullname;
																																																			} ?>">

												</div>
												<div class="col">
													<label>Middle Name </label>
													<input value="<?= $middle_name ?>" data-title='Middle Name' type="text" class="form-control" name="middle_name" placeholder="Middle name">
												</div>
												<div class="col">
													<label>Last Name </label>
													<input value="<?= $last_name ?>" type="text" class="form-control" name="last_name" placeholder="Last name" <?= $car_customer_type == 'Individual' ? 'required' : '' ?>>
												</div>

											</div>
											<div class="form-row">
												<div class="col">
													<label>Date of Birth </label>
													<input value="$proposer_dob" data-title='Date of Birth' max="<?php echo date('Y-m-d', strtotime("-18 year")); ?>" type="date" class="form-control" name="proposer_dob"  <?= $car_customer_type == 'Individual' ? 'required' : '' ?>>

												</div>

												<div class="col">
													<label for="exampleFormControlSelect1">Marital Status</label>
													<select <?= $car_customer_type == 'Individual' ? 'required' : '' ?>  data-title='Marital Status' class="form-control" name="marital_status" id="exampleFormControlSelect1" <?= $car_customer_type == 'Individual' ? 'required' : '' ?>>
														<?= selectOptions([['name' => 'Single'], ['name' => 'Married'], ['name' => 'Others']], 'name', 'name') ?>
													</select>
												</div>
												<div class="col">
													<label>Gender</label>
													<select <?= $car_customer_type == 'Individual' ? 'required' : '' ?> data-title='Gender' class="form-control" name="proposer_gender" id="gender">
														<?= selectOptions([['name' => 'Male'], ['name' => 'Female'], ['name' => 'Others']], 'name', 'name') ?>
													</select>
												</div>
											</div>
											<?php endif; ?>
											<?php endif; ?>
											<div class="form-row">
												<div class="col">
													<label>Occupation</label>
													<select type="text" class="form-control" name="occupation" value="" data-title='Occupation' placeholder="Occupation" required>
														<?= selectOptions($occupation, 'name', 'name') ?>
													</select>

												</div>
												<div class="col">
													<label>Pan No</label>
													<input value="<?= $pan_number ?>" type="text" class="form-control" name="pan_number" value="" placeholder="Pan Number">

												</div>
												<div class="col">
													<label>Aadhar No</label>
													<input value="<?= $aadhar_number ?>" type="text" class="form-control" name="aadhar_number" value="" placeholder="Aadhar Number">

												</div>


											</div>

										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingFour">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
											Address Details
										</button>
									</h2>
									<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<div class="form-row">
												<div class="col"><label for="address1">Address Line 1</label>
													<input value="<?= $address1 ?>" required data-title='Address Line 1' class="form-control" type="text" name="address1" id="address">
												</div>
												<div class="col"><label for="address2">Address Line 2</label>
													<input value="<?= $address2 ?>" class="form-control" type="text" name="address2" id="address">
												</div>
											</div>
											<div class="form-row">
												<div class="col">
													<label>Pincode </label>
													<input value="<?= $present_pincode ?>" required data-title='Pincode' id="pincode" class="form-control" type="text" name="present_pincode" maxlength="6" pattern="^[1-9]{1}\d{5}" placeholder="Pincode">
												</div>
												<div class="col">
													<label for="exampleFormControlSelect1">State </label>
													<select required data-title='State' id="state_id" class="form-control" name="present_state">
														<option>Select State</option>
														<option>...</option>
													</select>

												</div>
												<div class="col">
													<label for="exampleFormControlSelect2">City </label>
													<select id="city_id" class="form-control" name="present_city">
														<option>Select City</option>
														<option>...</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingFive">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
											Vehicle Additional Details
										</button>
									</h2>
									<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<div class="form-row">
												<div class="col">
													<label>Registration Number </label>
													<input required data-title='Registration Number' type="text" class="form-control" id="car_reg_num" name="four_wheeler_registration_number" placeholder="Enter Car Number (eg.DL-10-CB-1234)" maxlength="13" value="<?php echo ($caseType == 'new_vehicle') ? "NEW" : $four_wheeler_registration_number; ?>">
												</div>
												<?php if ($caseType !== 'new_vehicle') : ?>
													<div class="col">
														<label>Previous Policy Number</label>
														<input type="text" required data-title='Previous Policy Number' class="form-control" class="form-control" id="previous_policy_number" name="previous_policy_number" placeholder="Enter Previous policy number" minlength="5" maxlength="20" value="">
													</div><?php endif; ?>
											</div>
											<div class="form-row">
												<div class="col">
													<label>Engine Number </label>
													<input minlength="6" maxlength="30" value="<?= $engine_number ?>" required data-title='Engine Number' type="text" class="form-control" name="engine_number" placeholder="Engine Number">
												</div>
												<div class="col">
													<label>Chassis Number </label>
													<input minlength="17" pattern="[\w]{17,21}" maxlength="21" value="<?= $chassis_number ?>" type="text" required data-title='Chassis Number' class="form-control" name="chassis_number" placeholder="Chassis Number">
												</div>
												<div class="col">
													<label for="exampleFormControlSelect5">Color Type</label>
													<!--    													 <select class="form-control" id="exampleFormControlSelect5" name="color_type" required>
     													 <option value="">Select Color Type</option>
                                                     <option value="Black">Black</option>
    													</select> -->
													<input type="text" class="form-control" name="color_type" placeholder="Color">
												</div>
											</div>
											<div class="form-row">
												<div class="col">
													<label>PUC Number</label><?= (stripos("DL", $four_wheeler_registration_number) and $caseType != 'new_vehicle' ? required() : '')?>
													<input type="text" class="form-control" <?= stripos("DL", $four_wheeler_registration_number) ? 'required' : '' ?> name="puc_number" placeholder="MH092007829826752">
												</div>
												<div class="col">
													<label>PUC Expiry date</label><?= (stripos("DL", $four_wheeler_registration_number)? required() : '')?>
													<input type="date" class="form-control" <?= $caseType != 'new_vehicle' ? 'required' : null?> type="date" name="puc_expiry_date">
												</div>
											</div>
										</div>
									</div>

								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingSix">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix" required>
											Nominee Details
										</button>
									</h2>
									<div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<div class="form-row">
												<div class="col">
													<label for="examplerelation">Nominee Relation </label>
													<select <?= $car_customer_type == 'Individual' ? 'required' : '' ?>  data-title='Nominee relation' id="relation" class="form-control" name="nominee_relation">
														<option value="">Select Relation</option>
														<option value="INSURED (SELF-DRIVING)">INSURED (SELF-DRIVING)</option>
														<option value="OTHERS">OTHERS</option>
														<option value="Daughter">Daughter</option>
														<option value="Father">Father</option>
														<option value="Mother">Mother</option>
														<option value="Son">Son</option>
														<option value="Spouse">Spouse</option>
													</select>
												</div>
												<div class="col">
													<label>Nominee Full Name </label>
													<input  <?= $car_customer_type == 'Individual' ? 'required' : '' ?>  data-title='Nominee Name' class="form-control" type="text" placeholder="Full Name" name="nominee_name">
												</div>
												<div class="col">
													<label>Nominee Date of Birth </label>
													<input  <?= $car_customer_type == 'Individual' ? 'required' : '' ?>  data-title='Nominee D.O.B' type="date" class="form-control" name="nominee_dob" value="" name="nominee_dob"  max="<?php echo date('Y-m-d', strtotime("-18 year")); ?>">

												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingSeven">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSix" required>
											HP/ Finance </button>
									</h2>
									<div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
										<div class="accordion-body">

											<div class="form-check box-icon" onclick="bankdiv(), bankcitydiv()">
												<label class="form-check-label icon-lab " id="box-icon1" onclick="myFunction(),remove()" for="exampleRadiosyes">
													<input class="form-check-input" type="radio" name="finance" id="exampleRadiosyes" value="1" checked>
													<span>Yes</span>
												</label>
											</div>
											<div class="form-check box-icon" onclick="bankdivremove(), bankcitydivremove()">
												<label class="form-check-label icon-lab icon-lab-hover" id="box-icon2" onclick="myFunction2(),remove2()" for="exampleRadiosno">
													<input style="" class="form-check-input" type="radio" name="finance" id="exampleRadiosno" value="0" checked>
													<span>No</span>
												</label>
											</div>

											<div class="form-row" id="bankopt">

												<div class="col-12">
													<label>Bank Name</label>
													<select class="form-control" name="financier_name" id="exampleFormControlSelect1">
														<option value="">Select Bank </option>
														<?= selectOptions($financiers, 'name', 'name') ?>
													</select>
												</div>

											</div>
											<div class="form-row" id="bankcity" style="display: none;">

												<div class="col-6">
													<label>City</label>
													<input class="form-control" type="text" placeholder="City Name" name="financier_city" id="bank_city_name">
												</div>
												<div class="col-6">
													<label>Agreement type</label>
													<select class="form-control" name="finance_type" id="finance_agreement_type">
														<?= selectOptions(getValueDB('tata_finance_type_4w'), 'name', 'name') ?>
													</select>
												</div>

											</div>
										</div>
									</div>
								</div>

							</div>
							<button id="mobile_send_otp" type="button" class="btn btn-warning personal_send_otp" data-toggle="modal" data-target="">
								Pay Now
							</button>
						</form>

					</div>


					<div class="form_div">
						<div class="third_party">
							<div class="medical_right two_wheeler">
								<img src="<?php echo base_url(); ?>assets/front//img/car-insurance-5.gif">
							</div>
							<?php if (!auth_check()) { ?>
								<div class="accordion mb-4" id="accordionExample">
									<div class="card">
										<div class="card-header p-0 decoration_none have_an_account_box" id="headingTen">

											<button class="btn btn-link text-white collapsed decoration_none" type="button" data-toggle="collapse" data-target="#collapseTen" aria-expanded="true" aria-controls="collapseTen">
												Already Have An Account ? Please Login
											</button>

										</div>

										<div id="collapseTen" class="collapse show" aria-labelledby="headingTen" data-parent="#accordionExample">
											<div class="card-body">
												<form method="post" class="form-layout-1" id="form_login">

													<div id="result-login" class="text-danger"></div>

													<div class="form-group">
														<label for="exampleInputEmail1" class="sr-only">Email address</label>
														<input type="email" class="form-control" id="exampleInputEmail1" name="user_login" placeholder="Enter Email Id" required>
													</div>
													<div class="form-group">
														<label for="exampleInputPassword1" class="sr-only">Password</label>
														<input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Enter Password" required>
													</div>
													<button type="submit" class="btn btn-primary btn-sm mt-3">Login</button>
												</form>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
						<!--                                 	     <button type="button"  data-toggle="modal" data-target="#exampleModal" id="mobile_send_otp" class="btn btn-warning">Pay Now</button> -->

						<!-- Button trigger modal -->

					</div>

				</div>


			</div>
		</div>
	</section>

</div>

<!-- Modal term paynow -->
<div class="modal fade" id="exampleModalpay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="form-check">

						<input type="checkbox" class="form-check-input" id="myCheck">
						<label class="form-check-label" for="mycheck">
							Agree to terms and conditions
						</label>
					</div>
					<div class="policy" id="text">
						<h5 class="text-center">Terms of Use</h5>
						<p>Zoom Insurance Brokers Pvt. Ltd.(“Zoom”) operates the website <a href="https://bimabuy.in">https://www.bimabuy.in</a> (the “site”) to provide consumers a seamless way to choose and buy Insurance products from multiple Insurance companies. Zoom is not an insurance Organization. Zoom is a licensed Insurance Broking Organization holding a Broking licence from the Indian Insurance Regulator - Insurance Regulatory and Development authority.
							The trade logo “Bima Buy” and the URL <a href="https://bimabuy.in">www.bimabuy.in</a> is owned by Zoom Insurance Brokers Pvt. Ltd.(trade mark owner) and the same is used here. The services provided by the site are subject to the following conditions. Before you may use the Site, you must read and accept all of the terms and conditions in, and linked to, this Terms of Use.
						</p>
						<h5>Terms & conditions acceptance</h5>
						<p>Please read these Terms and Conditions (hereafter referred to as “Terms of use”) carefully. Your Acceptance of the Terms of Use contained herein constitutes the Agreement for the Purpose as defined hereunder.
							By visiting our site and accessing the information, resources, services, products, and tools we provide, you have confirmed that you have read, understand and agree to accept and adhere to the following terms of use, along with the terms and conditions as stated in our Privacy Policy (please refer to the Privacy Policy section for more information).<br>
							This Agreement describes the terms governing the usage of the facilities provided to you on the site. Clicking "I Agree" to "Terms & Conditions", shall be considered as your electronic acceptance of this Agreement under Information Technology Act 2000(as amended from time to time). Your continued usage of the facilities from time to time would also constitute acceptance of the Terms of Use including any updation or modification thereof and you would be bound by this Agreement until this Agreement is terminated as per provisions defined herein.<br>
							Your electronic consent, accepting these Terms of Use, represents that you have the capacity to be bound by it, or if you are acting on behalf of any person, that you have the authority to bind such person.
						</p>
						<h5>Responsible use and conduct</h5>
						<p>By visiting our website and accessing the information, resources, services, products, and tools we provide for you, either directly or indirectly (hereafter referred to as 'Resources'), you agree to use these Resources only for the purposes intended as permitted by (a) the terms of use, and (b) applicable laws, regulations and generally accepted online practices or guidelines.
							Wherein, you understand that: </p>
						<ul>
							<li> You may be required to provide certain information about yourself (such as identification, contact details, etc.) as part of the registration process, or as part of your ability to use the Resources. You agree that any information you provide will always be accurate, correct, and up to date.</li>
							<li> You are responsible for maintaining the confidentiality of any login information associated with any account you use to access our Resources. Accordingly, you are responsible for all activities that occur under your account/s.</li>
							<li> We strongly prohibit the accessing (or attempting to access) any of our Resources by any means other than through the means we provide. You specifically agree not to access (or attempt to access) any of our Resources through any automated, unethical or unconventional means.</li>
							<li> Involving in any activity that disrupts or interferes with our Resources, including the servers and/or networks to which our Resources are located or connected, is strictly prohibited.</li>
							<li> Attempting to copy, duplicate, reproduce, sell, trade, or resell our Resources is strictly prohibited.</li>
							<li> You are solely responsible for any consequences, losses, or damages that we may directly or indirectly incur or suffer due to any unauthorized activities conducted by you, as explained above, and may incur criminal or civil liability.</li>
							<li> We may provide various open communication tools on our website or linked social media accounts, such as blog comments, blog posts, public chat, forums, message boards, newsgroups, product ratings and reviews. You understand that generally we do not monitor the content posted by users of these various tools, which means that it your personal responsibility to use these tools in a responsible & ethical manner. You also agree that you will not upload, post, share, or otherwise distribute any content that:</li>
							<li> Is illegal, threatening, defamatory, abusive, harassing, degrading, intimidating, fraudulent, deceptive, invasive, racist, or contains any type of suggestive, inappropriate, or explicit language;</li>
							<li> Infringes on any trademark, patent, trade secret, copyright, or other proprietary right of any party;</li>
							<li> Contains any type of unauthorized or unsolicited advertising;</li>
							<li> Impersonates any person or entity, including any https://www.bimabuy.in employees or representatives.</li>
							<li> We have the right at our sole discretion to remove any content that, we feel in our judgment does not comply with these terms of use, along with any content that we feel is otherwise inaccurate, or violates any 3rd party copyrights or trademarks. We are not responsible for any delay or failure in removing such content. If you post content that we choose to remove, you hereby consent to such removal, and consent to waive any claim against us.</li>
							<li> We do not hold any liability for any content posted by you or any other 3rd party users of our website. However, any content that doesn’t violate or infringe any 3rd party copyrights or trademarks posted by you using any open communication tools on our website, becomes the property of Zoom, and as such, gives us a perpetual, irrevocable, worldwide, royalty-free, exclusive license to reproduce, modify, adapt, translate, publish, publicly display and/or distribute as we see fit. This only refers and applies to content posted via open communication tools as described, and does not refer to information that is provided as part of the registration process, necessary in order to use our Resources. All information provided as part of our registration process is covered by our privacy policy.</li>
						</ul>

						<h5>Privacy</h5>
						<p>Your privacy is very important to us, which is why we've created a separate Privacy Policy in order to explain in detail how we collect, manage, process, secure, and store your private information. Our privacy policy is included under the scope of these terms of use.
						</p>
						<h5>Indemnity</h5>
						<p>You hereby agree to indemnify, defend and hold bimabuy.in and its directors, officers, POSP, owners, employees, information providers, licensors and licensees (collectively, the “Indemnified Parties”), affiliates harmless from and against any and all liability and costs incurred by the Indemnified Parties in connection with any claim arising out of any breach of the Agreement or the foregoing representations, warranties and covenants, without limitation, attorneys’ fees and costs. You shall cooperate in complete absolute manner when required in the defense of any claim. We reserve the right to take over the exclusive defense of any claim for which we are entitled to indemnification under these terms of use. In such event, you shall provide us with such cooperation as is reasonably requested by us.
						</p>
						<h5>Promotional Offers</h5>
						<p>From time to time, you may receive announcement about new products and offers with intent to promote this site and/or facilities/products of listed insurance companies (“Promotional Offers”). The Promotional Offer(s) would always be governed by these Terms of Use plus certain additional terms and conditions, if any prescribed. The said additional terms and conditions, if prescribed, would be specific to the corresponding Promotional Offer only and shall prevail over these Terms of Use, to the extent they may be in conflict with these Terms of Use. The Website reserves the right to withdraw, discontinue, modify, extend and suspend the Promotional Offer(s) and the terms governing it, at its sole discretion.</p>
						<h5>Electronic Communications</h5>
						<p>You agree to receive any notices or other communications about the products from the site in electric form. Electronic communications may be posted on the site and/or delivered to your registered email address, mobile phones etc either by listed insurance companies or by Zoom with whom the services are availed. All communications in electronic format will be considered to be in "writing". Your consent to receive communications electronically is valid until you revoke your consent by notifying of your decision to do so. If you revoke your consent to receive communications electronically, the insurance companies or Zoom shall have the right to terminate the facilities.
						</p>
						<h5>Limitation of warranties</h5>
						<p>Although all efforts are made to ensure that information and content provided as part of this site is correct at the time of inclusion on the site, however there is no guarantee to the accuracy of the Information. This site makes no representations or warranties as to the fairness, completeness or accuracy of Information. There is no commitment to update or correct any information that appears on the Internet or on this site.<br>
							By using this site, you understand and agree that all resources we provide are "as is" and "as available". This means that we do not represent or warrant to you that:<br>
						<ul>
							<li> The use of our resources will meet your needs or requirements</li>
							<li> The use of our resources will be timely, uninterrupted, secure, or free from errors</li>
							<li> The information obtained by using our resources will be reliable or accurate</li>
							<li> Any defects in the operation or functionality of any resources we provide will be repaired or corrected</li>
						</ul>
						</p>
						<h5>Limitation of liabilities</h5>
						<p>In conjunction with the Limitation of Warranties as explained above, you expressly understand and agree that this site is provided to you on an "as is" and "where-is" basis, without any warranty. Zoom will not be liable to you or any third party for any damages of any kind, including but not limited to, direct, indirect, incidental, consequential or punitive damages, arising from or connected with the site, including but not limited to, your use of this site or your inability to use the site or as a result of any changes, data loss or corruption, cancellation, loss of access, or downtime to the full extent that applicable limitation of liability laws apply.<br>
							Further, Zoom and the providers of information shall not be liable, at any time, for any failure of performance, error, omission, interruption, deletion, defect, delay in operation or transmission, computer virus, communications line failure, theft or destruction or unauthorized access to, alteration of, or use of information contained at this site.</p>
						<h5>Copyrights and trademarks</h5>
						<p>All content and material available on https://www.bimabuy.in, including but not limited to the trademarks, logos, text, graphics, website name, code, images and service marks ("Marks") displayed on the Site are the intellectual property of Zoom and are protected by applicable copyright and trademark law. You are prohibited from using any Marks of this site for any purpose including, but not limited to use as metatags on other pages or sites on the World Wide Web without the written permission of Zoom or such third party which may own the Marks. You are prohibited from modifying, copying, distributing, transmitting, displaying, publishing, selling, licensing, creating derivative works or using any Content available on or through the Site for commercial or public purposes unless specifically authorized by Zoom.</p>
						<h5>Termination of use</h5>
						<p>You agree that we may, at our sole discretion, suspend or terminate your access to all or part of our website and Resources with or without notice and for any reason, including, without limitation, breach of this Terms of Use. Any suspected illegal, fraudulent or abusive activity may be grounds for terminating your relationship and may be referred to appropriate law enforcement authorities. Upon suspension or termination, your right to use the Resources we provide will immediately cease, and we reserve the right to remove or delete any information that you may have on file with us, including any account or login information.</p>
						<h5>Exclusive Agreement</h5>
						<p>You agree that these Terms of Use are the complete and exclusive statement of agreement supersede any proposal or prior agreement, oral or written, and any other communications between you and insurance companies and its Third-Party Service Providers or processor bank/merchants relating to the subject matter of these Terms of Use. These Terms of Use, as the same may be amended from time to time, will prevail over any subsequent oral communications between you and the site and/or the processor bank.</p>
						<h5>Use of cookies</h5>
						<p>You agree and understand that the Website will automatically receive and collect certain anonymous information in standard usage logs through the Web server, including computer/computer resource-identification information obtained from "cookies" sent to your browser from a web server or other means as explained in the Privacy Policy.</p>
						<h5>Modification in these terms of use</h5>
						<p>We reserve all the rights, at any time, at our sole discretion, to change or otherwise modify the Terms of Use without any prior notice, and your continued access or use of this Site signifies your acceptance of the updated or modified Terms of Use.</p>
						<h5>Governing Law</h5>
						<p>This site is controlled by Zoom Insurance Brokers Pvt. Ltd. from our office located in Gurugram, and we specifically prohibit you from usage of any of its facilities in any countries or jurisdictions that do not corroborate to all stipulations of these Terms of Use, although, this site can be accessed in most countries around the world.<br>
							As each country has laws that may differ from those of Gurugram, by accessing our site, you agree that the statutes and laws of Haryana without regard to the conflict of laws and the United Nations Convention on the International Sales of Goods, will apply to all matters relating to the use of this website and the purchase of any products or services through this site. In case of any dispute, either judicial or quasi-judicial, the same will be subject to the laws of India, with the courts in Gurugram having exclusive jurisdiction.
							These Terms and Conditions are governed by and to be interpreted in accordance with laws of India, without regard to the choice or conflicts of law provisions of any jurisdiction. You agree, in the event of any dispute arising in relation to these Terms of Use or any dispute arising in relation to the site whether in contract or tort or otherwise, to submit to the jurisdiction of the courts located at Gurugram, India for the resolution of all such disputes.</p>
						<h5>Guarantee</h5>
						<p>Unless otherwise expressed, Zoom Insurance Brokers Pvt. Ltd. expressly disclaims all warranties and conditions of any kind, whether expressed or implied, including, but not limited to the implied warranties and conditions of merchantability, fitness for a particular purpose, and non-infringement.
						</p>


					</div>
					<div id=" after_verified_div" class="text-danger ">
						<button class="btn after_verified_btn">Last Year Claim Status: <?php if ($isClaimInLastYear == '0') {
																							echo "No";
																						} else {
																							echo "Yes";
																						} ?></button>
						<button class="btn after_verified_btn">Previous Year NCB In % :<?php echo $previousNoClaimBonus; ?></button>
					</div>
					<?php if (empty($mobile_otp_verified)) { ?>

						<div class="">
							<?php if (empty($mobile_otp_verified)) { ?>
								<p id="mobile_otp_msg" class="float-left"></p>
								<p id="mobile_otp_timer" class="text-danger mobile_otp_wrap float-right"></p>
							<?php } else { ?>
								<p id="mobile_otp_msg" class="text-success"><i class="fa fa-check"></i> Mobile Number Verified</p>
							<?php } ?>

							<?php if (empty($mobile_otp_verified)) { ?>
								<div class="form-group mobile_otp_wrap mobile_otp_wrap_main ds" <?php if (empty($user_registration_send_mobile_otp)) { ?> style="display: none;" <?php } ?>>
									<input type="text" name="otpmobile" id="otpmobile" class="form-control" placeholder="Enter OTP">
									<button type="button" name="" class="btn btn-success btn-sm mt-2 otp_popup_font" id="mobile_verify_otp"> Verify OTP</button>
									<button type="button" name="" class="btn btn-danger btn-sm mt-2 otp_popup_font" id="mobile_resend_otp">Resend OTP</button>
								</div>
								<p id="mobile_otp_err_msg" class="text-danger mobile_otp_wrap"></p>
								<p id="result-pay" class="text-danger mobile_otp_wrap"></p>

							<?php } ?>
						</div>
					<?php } else { ?>
						<p id="" class="text-success"><i class="fa fa-check"></i> OTP Verified</p>
					<?php } ?>
				</div>
				<div class="modal-footer">
					<button id="car_submitBtn2" class="form-btn btn-bike-no btn btn-danger" type="button">Submit</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal End -->






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>


<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>



<script>
	var showAllErrorMessages = function() {
		let error = '';

		// Find all invalid fields within the form.
		var invalidFields = $('#carprsnl_detail').find(":invalid").each(function(index, node) {

			// Opera incorrectly does not fill the validationMessage property.
			// console.log(node.name);
			error += 'Please fill "' + node.getAttribute('data-title') + '"  field';
			error += '\n';

		});
		alert(error);
	}
	$('#mobile_send_otp').click(() => {
		if (!$('#carprsnl_detail').get(0).checkValidity()) {
			showAllErrorMessages();
			$('#carprsnl_detail').find(":invalid").first().parents('.accordion-item').children().find('button.accordion-button').trigger('click');
			$('#carprsnl_detail').find(":invalid").first().trigger('focus');

		} else {
			$(this).attr("data-target", '#exampleModalpay');
			$('#exampleModalpay').modal('show');
			// alert($(this).attr("data-target"));
		}
	});
</script>
<script>
	var checker = document.getElementById('myCheck');
	var sendbtn = document.getElementById('car_submitBtn2');
	// when unchecked or checked, run the function
	checker.onchange = function() {
		if (this.checked) {
			sendbtn.disabled = false;
		} else {
			sendbtn.disabled = true;
		}

	}
</script>
<script>
	var url = "<?php echo base_url(); ?>";
	$("#car_submitBtn2").click(function(event) {
		var clear_timer;
		var spinner = $('#loader');
		// spinner.show();
		event.preventDefault();
		var selector = $('#carprsnl_detail');
		var serializedData = $(selector).serializeArray();
		serializedData.push({
			name: csrf_token_name,
			value: getCookie(csrf_cookie_name)
		});

		$.ajax({
			type: "post",
			url: url + "tata/fw_controller/four_wheeler_payment/<?= $uid ?>",
			data: serializedData,
			dataType: 'json',
			success: function(data) {

				if (data.status == 0) {
					spinner.hide();
					$('#result-pay').html(data.message);
					setTimeout(() => {
						$('#result-pay').html('');
						
					}, 2000);
				} else if (data.status == 1) {
					spinner.hide();
					// window.open(url + 'new-india-car-payment', "_blank");
					window.location.href = url + 'tata-four-wheeler-payment/<?= $uid ?>';
				} else {
					$('#result-pay').html(data.message);
				}
			}
		})
	});
</script>

<script src="<?php echo FRONT_CSSJS_PATH; ?>/js/bajaj_fw.js"></script>
<script>
	$(document).ready(function() {
		$("#pincode").keyup(function() {
			// alert("hello");
			var pincode = $(this).val();
			// alert($(this).val());
			var data = {
				'pincode': pincode,
			};
			data[csrf_token_name] = getCookie(csrf_cookie_name);
			if (pincode == 0) {
				alert("Please fill the Pincode");
			} else {
				$.ajax({
					type: "post",
					url: base_url + "Location_controller/getlocation_nia",
					data: data,
					dataType: "json",
					success: function(data) {
						$("#state_id").html('<option value="' + data.state_name + '"> ' + data.state_name + '</option>');
						$("#zone_id").html('<option value="' + data.zone_id + '"> ' + data.zone_name + '</option>');
						$("#city_id").html('<option value="' + data.area_name + '"> ' + data.area_name + '</option>');
						$('#bank_city_name').val(data.area_name);
						$("#area_id").html(data.htmlResponse);
						// alert(data.state_id);
						// $("#city_id").html(data);
					}
				});
			}
		});
	})
</script>
<script>
	function bankdiv() {
		var x = document.getElementById("bankopt");
		if (x.style.display === "block") {
			x.style.display = "block";
		} else {
			x.style.display = "block";
		}
	}
</script>
<script>
	function bankdivremove() {
		var x = document.getElementById("bankopt");
		if (x.style.display === "none") {
			x.style.display = "none";
		} else {
			x.style.display = "none";
		}
	}
</script>
<script>
	function bankcitydiv() {
		var x = document.getElementById("bankcity");
		if (x.style.display === "none") {
			x.style.display = "flex";
		} else {
			x.style.display = "flex";
		}
	}
</script>
<script>
	function bankcitydivremove() {
		var x = document.getElementById("bankcity");
		if (x.style.display === "none") {
			x.style.display = "none";
		} else {
			x.style.display = "none";
		}
	}

	$("input[name='finance']").click(function() {
		// alert($("input[name='proposer_gender']:checked").val())
		$("input[name='finance']").parent().removeClass('icon-lab-hover');
		$(this).parent().addClass('icon-lab-hover');
	});
	function getGender(node) {
				if (node.value == "M/S") {} else if (node.value == "MR") {
					$('[value="F"]').hide();
					$('[value="M"]').show();
				} else {
					$('[value="M"]').hide();
					$('[value="F"]').show();
				}
			}
</script>