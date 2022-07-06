	<style>
		.nav-logo {
			margin: 0 auto;
			display: flex;
			margin-left: auto !important;
		}

		.navbar-expand-lg.navbar-light.bg-light {
			width: 35% !important;
			margin: 0 auto;
		}

		body {
			background-color: #f8f9fa !important;
		}

		/* =====================
register form css
===================== */
		.nav-logo {
			margin-left: 8px;
			width: 50%;
			padding: 2px 0px;
			padding-top: 3px;
		}

		.info_heading .info_heading_h1 {
			font-size: 1.2rem;
			color: rgba(17, 43, 74, 0.84);
			font-weight: 600;
		}

		#selectGender,
		#customMsg {
			width: 100%;
			border: none;
			height: auto;
			border-bottom: 1px solid #eeeeee;
			font-size: 14px;
			font-weight: 400;
			padding: 0 15px;
			padding-left: 0;
			padding-right: 0;
			padding-bottom: 8px;
			line-height: initial;
			color: #6c757d;
			background-color: #ffffff;
			transition: 0.5s;
			border-radius: 0;
			margin-bottom: 0;
		}

		.text-light-blue {
			color: #fff;
		}

		.btn-submit {
			color: #fff;
			border: 1px solid #1c3977;
			transition: 0.5s all;
			background-color: #1c3977;
			font-weight: 600;
			border-color: #1c3977;
		}

		.form-layout-1 .form-group {
			padding: 0;
		}

		.form_wrap {
			border: 1px solid #ccc;
		}

		.desktop-header {
			margin-bottom: 50px;
		}

		.error-message p {
			font-size: 13px;
			font-weight: 500;
			color: #f00;
			margin: 0;
		}

		.success_download_btn {
			margin: 10px auto;
			display: flex;
			padding: 5px 50px;
		}

		.loader {
			border: 6px solid #ddd;
			border-radius: 50%;
			border-top: 6px solid #ffc107;
			width: 120px;
			height: 120px;
			margin-right: 3%;
			-webkit-animation: spin 2s linear infinite;
			/* Safari */
			animation: spin 2s linear infinite;
		}

		/* Safari */
		@-webkit-keyframes spin {
			0% {
				-webkit-transform: rotate(0deg);
			}

			100% {
				-webkit-transform: rotate(360deg);
			}
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}
	</style>
	</div>
	</nav>
	</div>


	<!-- Start Main Body -->
	<div class="main-body">

		<!-- Start Contact -->
		<section class="section-padding mb-5">
			<div class="container">
				<div class="row justify-content-md-center">

					<div class="col-md-6">
						<div class="form_wrap px-4 py-3 ">
							<div class="text-center ">
								<h3 class="bg-success text-white text-uppercase p-2">Thank You for The Purchase!!</h3>
								<img src="<?= base_url('images/meet.png') ?>" alt="congratulations on purchasing policy" style="width:50%;">
							</div>
							<h5 class="text-dark">Dear <b style="text-transform:capitalize;"><?= $fullname ?></b>, We appreciate you choosing <b>Bima Buy</b>.
								Your payment for <b>Four Wheeler</b> Policy by <strong><?= $company ?></strong> was received and processed successfully.
								Furthermore, to view more information you can login into your <b>Bima Buy</b> account with the login
								details sent over your email address.</h5>
							<div class="text-center border-top pt-3 pb-3">
								<h5 class="text-dark">Policy Number: <b><?php echo $policy_no ?></b></h5>
								<h5 class="text-dark">Insurer: <b><?= $company ? $company : 'TATA AIG Insurance' ?></b></h5>
								<h5 class="text-dark border-bottom pb-3">Product:
									<b>Four Wheeler - Motor</b>
								</h5>
								<p class="text-dark">For any further queries please email us at <br><a href="mailto: support@bimabuy.in"><strong>support@bimabuy.in</strong></a></p>
							</div>


						</div>
						<!-- <button class="btn btn-warning success_download_btn" id="submitBtn">Download Policy</button> -->
						<div style="margin: 5% auto; text-align: center; display:flex; justify-content:center;">
							<div class="loader" style="visibility:hidden; display:inline-block; width: 50px; height:50px;"></div>
							<button id="submitBtn" class=" btn btn-warning">Download Policy</button>
						</div>

					</div>
				</div>
				<div class="container d-flex justify-content-center">
					<!-- <div class="row">
         <div class="col-md-6"> <button type="button" class="btn btn-lg btn-warning" data-toggle="modal" data-target="#myModal">Open Congratulations card Modal</button> </div>
     </div> -->
				</div>
				<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog">
						<div class="card" style="background:white;">
							<div class="text-right cross"> <i class="fa fa-times" style="padding:5px;"></i> </div>
							<div class="card-body text-center">
								<img src="https://uat.bimabuy.in/assets/front//img/logo.png" alt="bimabuy logo" style="width:70%;" style="text-align: center;">
								<img src="images/time.png" style="width:70%;">
								<h4 style="font-weight:700; font-size:24px;">Thank You for Being with us!</h4>
								<p>The Document is taking time, we will send you the <strong>Policy Details</strong> on Mail soon!</p> <button class="btn btn-warning continue">CONTINUE</button>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="myModalSuccess" role="dialog">
					<div class="modal-dialog">
						<div class="card" style="background:white;">
							<div class="text-right cross"> <i class="fa fa-times" style="padding:5px;"></i> </div>
							<div class="card-body text-center">
								<img src="https://uat.bimabuy.in/assets/front//img/logo.png" alt="bimabuy logo" style="width:70%;" style="text-align: center;">
								<img src="images/meet.png" style="width:70%;">
								<h4 style="font-weight:700; font-size:24px;">Thank You for Being with us!</h4>
								<p>The Document is already sent to you on Mail </p> <button class="btn btn-success continue">THANK YOU!</button>
							</div>
						</div>
					</div>
				</div>
				<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
				<script>
					var base_url = '<?php echo base_url(); ?>';
					var lang_base_url = '<?php echo base_url(); ?>';
					var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
					var csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';

					function getCookie(cname) {
						var name = cname + "=";
						var decodedCookie = decodeURIComponent(document.cookie);
						var ca = decodedCookie.split(';');
						for (var i = 0; i < ca.length; i++) {
							var c = ca[i];
							while (c.charAt(0) == ' ') {
								c = c.substring(1);
							}
							if (c.indexOf(name) == 0) {
								return c.substring(name.length, c.length);
							}
						}
						return "";
					}
				</script>

				<script>
					console.log(JSON.stringify(<?php echo $this->session->userdata('request2'); ?>))
				</script>
				<script>
					console.log(JSON.stringify(<?php echo $this->session->userdata('response2'); ?>))
				</script>
				<script type="text/javascript">
					let data = [];
					console.log(data[csrf_token_name]);
					$("#submitBtn").click(function() {
						$.ajax({
							url: '<?= base_url('tata/fw_controller/pdf')?>',
							method: "POST",
							data: {
								'policy_id': '<?= $policy_id; ?>',
								'policy_no': '<?= $policy_no; ?>',
								 [csrf_cookie_name] : getCookie(csrf_cookie_name)

							},
							error: function(e){
								console.log(e);
							},
							success: function(data){
								data = JSON.parse(data);
								(data.status == 200) ? window.location.href = data.link : alert("Something went wrong!");
							}
						});

					});
				</script>
		</section>
		<!-- End Contact -->
	</div>