<?php
error_reporting(0);
defined('BASEPATH') or exit('No direct script access allowed');
class Fw_controller extends Home_core_controller
{
	public function __construct()
	{
		parent::__construct();
		error_reporting(E_ERROR);
		$this->load->library('form_validation');
		$this->load->model('cmsmodel');
		$this->load->model('common_model');
		$this->load->library('Encryption');
		$this->load->model('Email_model');
		$this->load->model('tata/Tata_fw_model');
		$this->load->model('tata/Tata_tw_model');
		// ini_set('max_execution_time', '300');
	}
	function car_basic_details()
	{
		$data['title'] = 'Four Wheeler Basic Details';
		$data['make'] = $this->Tata_fw_model->get_all_make_four_wheeler();
		// print_r($data['make']);exit();
		$data['rtos'] = $this->Tata_tw_model->getRTO();
		$this->load->view('partials/header', $data);
		$this->load->view('tata/four-wheeler/fw_basic_details', $data);
		$this->load->view('partials/footer');
	}
	function car_all_policies_re()
	{
		$formData = $this->input->post();
		$formData['four_wheeler_registration_number'] =  strtoupper($formData['four_wheeler_registration_number']);
		if (!empty($formData['four_wheeler_registration_number'])) {
			$formData['rto'] = $this->getRTO($formData['four_wheeler_registration_number']);
		} else {
			$formData['rto'] = $this->getRTO($formData['rtoSelect']);
		}
		$vehicle_details = ($this->Tata_fw_model->get_vehicle_details($formData));
		$uid = 'CAR' . setUid();
		$formData = array_merge($formData, (array)$vehicle_details);
		if (checkDays(date('Y-m-d'), $formData['car_register_date']) > -180  and checkDays(date('Y-m-d'), $formData['car_register_date']) <= 0) {
			if (checkDays(date('Y-m-d'), $formData['car_register_date']) >= -15  and checkDays(date('Y-m-d'), $formData['car_register_date']) <= 0) {
				$formData['caseType'] = 'new_vehicle';
				$dataArray =  array('time' => time(), 'data' => json_encode($formData), 'uid' => $uid, 'type' => '4W');
				insert_into_db($dataArray, 'tata_transaction');
				$this->session->set_userdata('uid', $uid);
				echo checkDays(date('Y-m-d'), $formData['car_register_date']) . "\n\n";
				redirect((base_url() . 'tata-four-wheeler-policy/' . $uid));
			} else {
				breakIn();
				return;
			}
		} else {
			$formData['caseType'] = 'roll_over';

			if ($formData['product_code'] == 'PACKAGE') {
				$formData['cover_code'] = '1';
				$formData['cover_name'] = 'PACKAGE';
			} else {
				$formData['cover_code'] = '2';
				$formData['cover_name'] = 'LIABILITY';
			}
		}
		$dataArray =  array('time' => time(), 'data' => json_encode($formData), 'uid' => $uid, 'type' => '4W');
		insert_into_db($dataArray, 'tata_transaction');
		$this->session->set_userdata('uid', $uid);
		var_dump($dataArray);
		redirect((base_url() . 'tata-fw-ncb-selection/' . $uid));
	}
	function car_ncb_selection($uid)
	{
		$data = (array)json_decode(($this->Tata_tw_model->getDetails($uid))['data']);
		$data['uid'] = $uid;
		$data['previous_insurer'] = $this->Tata_fw_model->fw_previous_insurer();

		$this->load->view('partials/header');
		$this->load->view('tata/four-wheeler/fw_ncb_selection', $data);
		$this->load->view('partials/footer');
	}
	function car_ncb_selection_re($uid)
	{
		$data = (array)json_decode(($this->Tata_tw_model->getDetails($uid))['data']);
		$form_data = $this->input->post();
		$crn = $this->vehicle_common_master_model->get_last_crn();
		$crnvalue = $crn->crn_value;
		$n_crn = str_replace("BB2W", "", $crnvalue);
		$ne_crn = (int)$n_crn + 1;
		$new_crn = "BB2W" . "$ne_crn";
		$crn_data = array(
			"crn_value" => $new_crn
		);
		$data['cv_crn'] = $this->vehicle_common_master_model->insert_crn($crn_data);										// print_r($_SESSION);exit();
		$form_data = $this->input->post();
		$details = array_merge($data, $form_data);
		if (checkDays(date('Y-m-d'), $form_data['previousPolicyExpiryDate']) < 0 and $data['car_product_code'] == 'PACKAGE') {
			breakIn();
			return;
		} else if ($form_data['previousInsurerCode'] == 'TATA AIG GENERAL INSURANCE CO.LTD.') {
			breakIn("Cases from TATA AIG not allowed!");
			return;
		} else if ($form_data['isPreviousPolicyComprehensive'] == '0' and $data['car_product_code'] == 'PACKAGE') {
			breakIn("You cannot proceed forward, Apologies");
			return;
		}
		if (empty($form_data['previousNoClaimBonus']) or $data['car_product_code'] == 'LIABILITY') $details['previousNoClaimBonus'] = 0;
		updateTable('tata_transaction', array('uid', $uid), array('data', $details));
		redirect((base_url() . 'tata-four-wheeler-policy/') . $uid);
	}
	function car_product_type_choose($uid)
	{
		$data = (array)json_decode(($this->Tata_tw_model->getDetails($uid))['data']);
		$data['car_product_code'] = $this->input->post('car_product_code');
		$data['idv'] = ($data['car_product_code'] == 'LIABILITY') ? 0 : $data['idv'];
		updateTable('tata_transaction', array('uid', $uid), array('data', $data));

		redirect((base_url() . 'tata-four-wheeler-policy/') . $uid);
	}
	function car_ncb_choose($uid)
	{
		$data = $uid;
		$isClaimInLastYear = $this->input->post("isClaimInLastYear");
		$previousNoClaimBonus = $this->input->post("ncbvalue");
		if ($isClaimInLastYear == 1) {
		} else {
			if ($data['previousPolicyExpiryDate']) {
			} else {
			}
			if ($data['car_previousInsurerCode']) {
			} else {
			}
		}
		redirect((base_url() . 'tata-four-wheeler-policy/') . $uid);
	}
	function all_policies($uid)
	{
		$data = json_decode(($this->Tata_tw_model->getDetails($uid))['data'], true);
		echo "<script>console.log(`" . json_encode($data) . "`)</script>";
		$data['uid'] = $uid;
		$data['title'] = 'Review';
		$data['isClaimInLastYear_'] = $data['isClaimInLastYear'];

		$seoResult = $this->common_model->getSeoDetail(2);
		$data['meta_title'] 	= $seoResult->title;
		$data['meta_keyword'] 	= $seoResult->meta_keyword;
		$data['meta_desc'] 	 	= $seoResult->meta_desc;
		$car_register_date = $data['car_register_date'];
		$data['car_register_year'] = substr($car_register_date, 0, 4);
		foreach ($data['allAddons'] as $addon) {
			$data[strval('addon' . ['id'])] = empty($data[strval('addon' . ['id'])]) ? 'N' : $data[strval('addon' . ['id'])];
		}
		if (empty($data['bundle_code'])) {
			if ($data['p7']) {
				$data['bundle_name'] = 'SAPPHIRE++';
				$data['bundle_code'] = 'P7';
			} else if ($data['p6']) {
				$data['bundle_name'] = 'SAPPHIREPLUS';
				$data['bundle_code'] = 'P6';
			} else if ($data['p4']) {
				$data['bundle_name'] = 'PEARL+';
				$data['bundle_code'] = 'P4';
			} else if ($data['p3']) {
				$data['bundle_name'] = 'PEARL';
				$data['bundle_code'] = 'P3';
			} else if ($data['p2']) {
				$data['bundle_name'] = 'GOLD';
				$data['bundle_code'] = 'P2';
			} else if ($data['p1']) {
				$data['bundle_name'] = 'Silver';
				$data['bundle_code'] = 'P1';
			}
		}
		if (!empty($data['selectedAddons'])) {
			$data['selectedAddons']  = 	(array)$data['selectedAddons'];
		}
		if ($data['caseType'] != 'new_vehicle') {
			if ($data['isPreviousPolicyComprehensive'] == 1) {
				$data['isPreviousPolicyComprehensive'] = 1;
				$data['previousInsurerCode'] = $data['previousInsurerCode'];
				$data['previousPolicyExpiryDate'] = $data['previousPolicyExpiryDate'];

				if ($data['isClaimInLastYear_'] == 1) {
					$data['previousNoClaimBonus'] = "0";
					$data['current_ncb'] = 0;
				} else {
					$data['isClaimInLastYear_'] = 0;
					$data['previousNoClaimBonus'] = $data['previousNoClaimBonus'];
					$data['current_ncb'] = $this->protectionOfNCB($data['previousNoClaimBonus']);
				}
			} else {
				$data['isPreviousPolicyComprehensive'] = 0;
				$data['previousInsurerCode'] = $data['previousInsurerCode'];
				$data['isClaimInLastYear_'] = $data['isClaimLastYear'];
				$data['previousNoClaimBonus'] = "0";
				$data['current_ncb'] = 0;
				$data['idv'] = 0;
				$data['car_product_code'] = 'LIABILITY';
			}
		}
		if ($data['car_product_code'] == 'LIABILITY') $data['current_ncb'] = 0;
		if (empty($data['owner_driver'])) {
			$data['owner_driver'] = 'N';
		}

		$data['previousPolicyExpiryDate_'] = date('Ymd', strtotime($data['previousPolicyExpiryDate']));
		$data['car_register_date_'] = date('Ymd', strtotime($data['car_register_date']));
		if ($data['caseType'] == 'new_vehicle') {
			$quickClass = $this->Tata_fw_model->newVehiclePremium($data);
			if (!isEmptyObject($quick->PRetErr) and $quick->PRetErr != 'NO ERROR') {
				echo '<script>alert(\'Sorry You cannot proceed\');</script>';
				$data['heading'] = 'Sorry you cannot move forward!';
				$data['message'] = 'Kindly Try again!';
				$data['response'] = json_encode($quick);
				$this->load->view('partials/header', $data);
				$this->load->view('errors/html/error_home.php', $data);
				$this->load->view('partials/footer');
				return;
			} else {
				$quick = $quickClass->data[0]->data->premium_break_up;
				$quickPolicyDetails = $quickClass->data[0]->pol_dlts;

				$data['netpremium'] = $quick->final_premium;
				$data['third_party_premium'] =  $quick->total_tp_premium->basic_tp;
				$data['pa_owner_driver'] =  $quick->total_tp_premium->pa_owner_prem;
				$data['own_damage'] =  $quick->total_od_premium->total_od;
				$data['grosspremium'] =  $quick->net_premium;
				$data['duepremium'] =   $quick->net_premium;
				$data['ncbvalue'] = $data['previousNoClaimBonus'];
				$data['ncbdiscount'] =   $quick->total_od_premium->discount_od->ncb_prem;
				$data['fw_idv'] =  $quick->quotationdata->revised_idv;
				$data['addons_with_premium'] = $this->tataAddonCheck($quick->total_addOns, $data);
				// echo $data['bundle_code'];
				if ($data['addon7'] == 'Yes' or !empty($data['bundle_code'])) {
					$data['addons_with_premium']['repair glass premium'] = 0;
				} else {
					unset($data['addons_with_premium']['repair glass premium']);
				}
				$data['addons_premium'] =  array_sum(array_values($data['addons_with_premium']));
				$data['unnamed_premium'] = $quick->total_tp_premium->pa_unnamed_prem;
				$data['paid_driver_premium'] = $quickPolicyDetails->pa_paid_prem;
				$quickPolicyDetails->pa_paid_prem;
				$data['ll_paid_premium'] = $quick->total_tp_premium->ll_paid_prem;
				$data['cng_premium_od'] = $quick->total_od_premium->od->cng_lpg_od_prem;
				$data['cng_premium_tp'] = $quick->total_tp_premium->cng_lpg_tp_prem;
				$data['cng_premium_total'] = (float)$quick->total_od_premium->od->cng_lpg_od_prem + (float)$quick->total_tp_premium->cng_lpg_tp_prem;
			}
		} else {
			$quickClass = $this->Tata_fw_model->tata_car_quote($data);
			if (!isEmptyObject($quick->PRetErr) and $quick->PRetErr != 'NO ERROR') {
				echo '<script>alert(\'Sorry You cannot proceed\');</script>';
				$data['heading'] = 'Sorry you cannot move forward!';
				$data['message'] = $quick->PRetError;
				$data['response'] = json_encode($quick);
				$this->load->view('partials/header', $data);
				$this->load->view('errors/html/error_home.php', $data);
				$this->load->view('partials/footer');
				return;
			} else {
				echo '<script>console.log(JSON.stringify(' . json_encode($quickClass) . '));</script>';
				$quick = new stdClass();
				$quick = $quickClass->data[0]->data->premium_break_up;
				$quickPolicyDetails = $quickClass->data[0]->pol_dlts;
				$data['netpremium'] = $quick->final_premium;
				$data['third_party_premium'] =  $quick->total_tp_premium->basic_tp;
				$data['pa_owner_driver'] =  $quick->total_tp_premium->pa_owner_prem;
				$data['own_damage'] =  $quick->total_od_premium->total_od;
				$data['grosspremium'] =  $quick->net_premium;
				$data['duepremium'] =   $quick->net_premium;
				$data['ncbvalue'] = $data['previousNoClaimBonus'];
				$data['ncbdiscount'] =   $quick->total_od_premium->discount_od->ncb_prem;
				$data['fw_idv'] =  $quick->quotationdata->revised_idv;
				$data['addons_with_premium'] = $this->tataAddonCheck($quick->total_addOns, $data);
				if ($data['addon7'] == 'Yes' or !empty($data['bundle_code'])) {
					$data['addons_with_premium']['repair glass premium'] = 0;
				} else {
					unset($data['addons_with_premium']['repair glass premium']);
				}
				$data['addons_premium'] =  array_sum(array_values($data['addons_with_premium']));
				$data['unnamed_premium'] = $quick->total_tp_premium->pa_unnamed_prem;
				$data['paid_driver_premium'] = $quickPolicyDetails->pa_paid_prem;
				$data['ll_paid_premium'] = $quick->total_tp_premium->ll_paid_prem;
				$data['cng_premium_od'] = $quick->total_od_premium->od->cng_lpg_od_prem;
				$data['cng_premium_tp'] = $quick->total_tp_premium->cng_lpg_tp_prem;
				$data['cng_premium_total'] = (float)$quick->total_od_premium->od->cng_lpg_od_prem + (float)$quick->total_tp_premium->cng_lpg_tp_prem;
			}
		}
		$data['quote_id'] = $quickClass->data[0]->data->quote_id;
		if (empty($data['idv'])) {
			if ($data['car_product_code'] == "PACKAGE") {
				$data['idv'] = $quickPolicyDetails->vehicle_idv;
			} else $data['idv'] = 0;
		}
		if ($data['idv'] != 0 and (empty($data['min_idv']) or empty($data['max_idv']))) {
			$data['min_idv'] = $quickPolicyDetails->min_idv;
			$data['max_idv'] = $quickPolicyDetails->max_idv;
		}
		$data['fw_idv'] = $data['idv'];
		$data['allAddons'] = $this->Tata_fw_model->getAddons();
		if (empty($data['fw_idv'])) $data['fw_idv'] = 0;
		updateTable('tata_transaction', array('uid', $uid),  array('data', json_encode($data)));
		$data['bundle_str'] = $this->getAddonBundle($data);
		// echo "<script>console.log(`" . print_r($data, true) . "`)</script>";
		$this->load->view('partials/header', $data);
		$this->load->view('tata/four-wheeler/fw_all_policies', $data);
		$this->load->view('partials/footer');
	}
	function car_all_details($uid)
	{
		// $seoResult = new stdClass();
		$data = (array)json_decode(($this->Tata_tw_model->getDetails($uid))['data']);
		if (empty($data['prev_cng_yes_or_no']) or $data['prev_cng_yes_or_no'] == 'N') {
			if ($data['cng_tp'] == 'Y' or !empty($data['premium_for_cng_by_user']) or $data['premium_for_cng_by_user'] != 0) {
				$data['cng_tp'] = null;
				$data['premium_for_cng_by_user'] = 0;
				updateTable('tata_transaction', array('uid', $uid),  array('data', json_encode($data)));
				$_SESSION['error-cng'] = 'You cannot select CNG if you don\'t have the cover in previous policy!';
				$this->session->mark_as_flash('error-cng');
				redirect(base_url("tata-four-wheeler-policy/$uid"), 'refresh');
			}
		}
		// print_r($data); exit;
		$data['title'] = 'Car All Details';
		// $data['meta_title'] 	= $seoResult->title;
		// $data['meta_keyword'] 	= $seoResult->meta_keyword;
		// $data['meta_desc'] 	 	= $seoResult->meta_desc;
		$data['customer_type'] = $data['car_customer_type'];
		$data['financiers'] = getValueDB('tata_financers_4w', [], 'name', 'limit 10000');
		$data['relation'] = getValueDB('tata_relation_4w');
		$data['occupation'] = getValueDB('tata_occupation_4w');
		$data['colors'] = getColorList();
		$data['salutation'] = getValueDB('tata_salutation_4w');
		$this->load->view('partials/header', $data);
		$this->load->view('tata/four-wheeler/car-personal-details', $data);
		$this->load->view('partials/footer');
	}
	function four_wheeler_payment($uid)
	{
		$this->session->unset_userdata(array('fqbody', 'fqresponse', 'pbody', 'presponse'));
		$data = json_decode(($this->Tata_tw_model->getDetails($uid))['data'], true);
		$pdata = $this->input->post();
		$pdata['last_name'] = ucfirst(strtolower($pdata['last_name']));
		if (empty($pdata['middle_name']) or $data['middle_name'] == '') $data['fullname'] = trim($pdata['first_name']) . ' ' . trim($pdata['last_name']);
		else  $data['fullname'] = $pdata['first_name'] . ' ' . $pdata['middle_name'] . ' ' . $pdata['last_name'];
		$data = array_merge($data, $pdata);
		$data['nominee_age'] = getAge($pdata['nominee_dob']);
		if (!empty($data['selectedAddons'])) {
			$data['selectedAddons']  = 	(array)$data['selectedAddons'];
		}
		if (empty($data['quote_number'])) {
			if ($data['caseType'] == 'new_vehicle') {
				$fullQuote =  $this->Tata_fw_model->newTataFullQuote($data);
			} else {
				$fullQuote = $this->Tata_fw_model->tataFullQuote($data);
			}
			$data['quote_number'] = $fullQuote['data'][0]['data']['quote_no'];
			$data['proposal_id']  = $fullQuote['data'][0]['data']['proposal_id'];
		}
		// echo json_encode($data);
		if (!empty($data['proposal_id'])) $proposal_response = $this->Tata_fw_model->proposal($data);

		// print_r($proposal_response);
		$data['payment_id'] = $proposal_response['data'][0]['payment_id'];
		// print_r($data);
		if ($proposal_response['status'] != 200) {
			echo json_encode(array("status" => 0, "message" => $proposal_response['message_txt'], 'reason' => array($this->session->userdata('fqbody'), $this->session->userdata('fqresponse'), $this->session->userdata('pbody'), $this->session->userdata('presponse'))));
			updateTable('tata_transaction', array('uid', $uid),  array('data', json_encode($data)));
			exit;
		} else if (!empty($data['payment_id'])) {
			$data['quote_id'] = $proposal_response['data'][0]['quote_id'];
			$data['quote_no'] = $proposal_response['data'][0]['quote_no'];
			$data['proposal_no'] = $proposal_response['data'][0]['proposal_no'];
			$data['proposal_id'] = $proposal_response['data'][0]['proposal_id'];
			$data['policy_id'] = $proposal_response['data'][0]['policy_id'];
			$data['product_id'] = $proposal_response['data'][0]['product_id'];
			updateTable('tata_transaction', array('uid', $uid),  array('data', json_encode($data)));
			insert_into_db(['proposal_data' => json_encode($pdata), 'status' => 1], 'tata_proposal');
			echo json_encode(array('message' => 'Success', 'status' => 1, 'quote' => str_replace('\\"', '"', $proposal_response)));
			exit;
		} else {
			insert_into_db(['proposal_data' => json_encode($pdata), 'status' => 0], 'tata_proposal');
			echo json_encode(array("status" => 0, "message" => "Error in data", 'sreason' => $proposal_response[0], 'body' => $proposal_response[1], 'pbody' => $proposal_response[2], 'presponse' => $policyHolderCode[2]));
			exit;
		}
	}
	function car_premium_payment($uid)
	{
		echo "<script>console.log(`Party Body: \n" . $this->session->userdata('party_body') . "`)</script>";
		echo "<script>console.log(`Party Response: \n" . $this->session->userdata('party_response') . "`)</script>";
		echo "<script>console.log(`Data Body: \n" . $this->session->userdata('data_body') . "`)</script>";
		echo "<script>console.log(`Data Response: \n" . $this->session->userdata('data_response') . "`)</script>";
		$data = (array)json_decode(($this->Tata_tw_model->getDetails($uid))['data']);
		$data['body'] = $data['request_body'];
		$data['quote'] = $data['quote_no'];
		$data['premium'] = $data['duepremium'];
		$data['title'] = 'Payment';
		$data['number'] = $data['number'];
		$data['email'] = $data['emailuser'] ?? $data['proposer_email'];
		setcookie('uid-bb', $uid, time() + 3600, '/');
		$this->load->view('partials/header', $data);
		$this->load->view('tata/four-wheeler/payment', $data);
		$this->load->view('partials/footer');
	}

	function tata4w_payment($uid)
	{

		$uid = ($uid) ? $uid : $_COOKIE['uid-bb'];
		$data = (array)json_decode(($this->Tata_tw_model->getDetails($uid))['data']);
		echo $this->Tata_fw_model->pay($data);
	}

	function tata4W_response()
	{
		// var_dump($_GET);
		if (isset($_GET)) {
			$uid = ($_SESSION['uid']) ? $_SESSION['uid'] : $_COOKIE['uid-bb'];
			$data = json_decode(($this->Tata_tw_model->getDetails($uid))['data'], true);
			$payVerify = $this->Tata_fw_model->verify_payment($data);
			if ($payVerify['status'] == 200) {
				$data['policy_no'] = $payVerify['data']['policy_no'];
				$data['payment_reference_id'] = $payVerify['data']['reference_id'];
				updateTable('tata_transaction', array('uid', $uid),  array('data', json_encode($data)));
				redirect(base_url("tata-four-wheeler-successful-payment/{$uid}"));
			} else {
				echo "Something went wrong!";
			}
		}
	}
	function personal_details_post($uid)
	{
		$vehicle_code = $this->input->post('vehicle_code');
		$this->form_validation->set_rules('email_id', 'Email Address', 'required|max_length[100]|is_unique[customers.email_id], ');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'required|max_length[100]|is_unique[customers.phone_number]');
		if ($this->form_validation->run() == FALSE) {
			$this->create_quote_godigit($vehicle_code);
		} else {
			if (!auth_check()) {
				$data['first_name'] = $this->input->post('first_name');
				$data['last_name'] = $this->input->post('first_name');
				$data['email_id'] = $this->input->post('email_id');
				$data['phone_number'] = $this->input->post('phone_number');				//secure password
				$password = ucfirst($data['first_name']) . '@' . rand(1000, 9999);
				$data['password'] = $this->bcrypt->hash_password($password);
				$data['token'] = generate_token();
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['modified_at'] = date('Y-m-d H:i:s');
				$user_id = $this->auth_model->register($data);
				if ($user_id) {
					$user = get_user($user_id);
					if (!empty($user)) {
						//update slug						$sendid = $this->Email_model->send_email_customer_creation($user_id, $password);						$this->session->set_flashdata('success', 'Logged In Successfully!');
						$this->auth_model->login_direct($user);
						$this->create_quote_godigit($vehicle_code);
					}
					//redirect((lang_base_url() . "register"); . $uid);
				}
			} else {
				$this->create_quote_godigit($vehicle_code);
				$this->session->set_flashdata('error', 'Already Logged In!');
			}
		}
	}
	function fw_cover_recalculate($uid)
	{
		$data = (array)json_decode(($this->Tata_tw_model->getDetails($uid))['data']);
		$form_data = $this->input->post();
		if ($data['idv'] != $this->input->post('fw_idv') and $data['product_code'] != 'LIABILITY') {
			$data['idv'] = $this->input->post('fw_idv');
		}
		if (isset($form_data['cng_kit'])) {
			$data['premium_for_cng_by_user'] = $form_data['cng_kit'];
		}
		$data['owner_driver'] = $form_data['owner_driver'];
		$data['paid_driver'] = $form_data['paid_driver'];
		$data['ll_paid'] = $form_data['ll_paid'];
		$data['unnamed'] = $form_data['unnamed'];
		$data['cng_tp'] = $form_data['cng_tp'];
		$data['prev_cng_yes_or_no'] = $form_data['prev_cng_yes_or_no'];
		(updateTable('tata_transaction', array('uid', $uid), array('data', json_encode($data))));

		// print_r($form_data);
		// exit;

		redirect((base_url() . 'tata-four-wheeler-policy/') . $uid);
	}
	function successfull_policy_payment($uid)
	{
		$data = (array)json_decode(($this->Tata_tw_model->getDetails($uid))['data']);
		$data['Organization'] = 'TATA AIG Insurance';
		$this->load->view('partials/header', $data);
		$this->load->view('tata/four-wheeler/successfull_policy_payment', $data);
		$this->load->view('partials/footer');
	}
	function pdf()
	{
		$policy_id = ($this->input->post('policy_id'));
		$policy_number = ($this->input->post('policy_no'));
		$pdf_content = $this->Tata_fw_model->pdfLink($policy_id);
		$file = "assets/documents/TATA-{$policy_number}.pdf";
		file_put_contents($file, base64_decode($pdf_content));
		if (strlen(file_get_contents($file)) >  10) {
			echo json_encode(array('status' => 200, 'link' => base_url($file)));
			exit;
		}
		echo json_encode(array('status' => 400, 'message' => "Error , Try Again Later"));
		exit;
	}
	function fw_addons_choose($uid)
	{
		$data = (array)json_decode(($this->Tata_tw_model->getDetails($uid))['data']);
		$fdata = $this->input->post();
		$array = $this->Tata_fw_model->getAddons();
		$temp = null;
		$arrayCheck = $fdata['addons'];
		$bundles = getValueDB('tata_addon_bundle_4w', [], 'arr');
		unset($data['bundle_name']);
		unset($data['bundle_code']);
		$arrayCheck = (unsetItemFromArray($arrayCheck, 9));
		foreach ((array_column($bundles, 'arr')) as $key) {

			if ($arrayCheck == json_decode($key)) {
				$bundle_data = getValueDBSingle('tata_addon_bundle_4w', ['arr' => $key]);
				$data['bundle_code'] = $bundle_data['plan_id'];
				$data['bundle_name'] = $bundle_data['plan_name'];
				goto updateBundle;
			}
		}
		foreach (['p1', 'p2', 'p3', 'p4', 'p6', 'p7'] as $bundleCode) {
			unset($data[$bundleCode]);
		}
		foreach ($array as $value) {
			if (in_array($value->id, $fdata['addons'])) {
				if ($value->bundle == 'P7') {
					$data['p7'] = true;
				} else if ($value->bundle == 'P6') {
					$data['p6'] = true;
				} else if ($value->bundle == 'P4') {
					$data['p4'] = true;
				} else if ($value->bundle == 'P3') {
					$data['p3'] = true;
				} else if ($value->bundle == 'P2') {
					$data['p2'] = true;
				} else if ($value->bundle == 'P1') {
					$data['p1'] = true;
				}
				$data['addon' . $value->id] = 'Yes';
			} else {
				$data['addon' . $value->id] = 'No';
			}
		}

		// print_r($data);
		// exit;
		updateBundle:
		// print_r($data);
		// exit;
		updateTable('tata_transaction', array('uid', $uid), array('data', $data));
		redirect((base_url() . 'tata-four-wheeler-policy/') . $uid);
	}

	public function user_registration_send_mobile_otp($uid)
	{
		$phone_number = $this->input->post('mobile_no');
		$six_digit_random_number = mt_rand(100000, 999999);
		$_SESSION['session_mobile_otp'] = $six_digit_random_number;
		if ($this->general_settings->email_verification != 1) {
			//register
			// $your_url1 = "https://2factor.in/API/V1/423c7d24-b35f-11e9-ade6-0200cd936042/SMS/$phone_number/$six_digit_random_number/BIMABI";
			$your_url1 = "http://v1.msg365.in/http-tokenkeyapi.php?authentic-key=3134436f6e636f757273653336371610534077&senderid=ImpMSG&route=2&number=$phone_number&message=$six_digit_random_number";
			//print_r($your_url1); exit();
			$demo = file_get_contents($your_url1);
		}
		$response = array('status' => 1, 'message' => 'OTP Sent Successfully');
		echo json_encode($response);
	}
	public function user_registration_resend_mobile_otp($uid)
	{
		$phone_number = $this->input->post('mobile_no');
		$six_digit_random_number = mt_rand(100000, 999999);
		$_SESSION['session_mobile_otp'] = $six_digit_random_number;
		if ($this->general_settings->email_verification != 1) {
			//register
			// $your_url1 = "https://2factor.in/API/V1/423c7d24-b35f-11e9-ade6-0200cd936042/SMS/$phone_number/$six_digit_random_number/BIMABI";
			$your_url1 = "http://v1.msg365.in/http-tokenkeyapi.php?authentic-key=3134436f6e636f757273653336371610534077&senderid=ImpMSG&route=2&number=$phone_number&message=$six_digit_random_number";
			//print_r($your_url1); exit();
			$demo = file_get_contents($your_url1);
		}
		$response = array('status' => 1, 'message' => 'OTP Resent Successfully');
		echo json_encode($response);
	}
	public function user_registration_verify_mobile_otp($uid)
	{
		if ($this->input->post('otpmobile', true) == $_SESSION['session_mobile_otp'] || $this->input->post('otpmobile', true) == "12345") {
			$response = array('status' => 1, 'message' => 'OTP Verified');
			echo json_encode($response);
		} else {
			$response = array('status' => 0, 'message' => 'Wrong OTP');
			echo json_encode($response);
		}
	}
	public function get_fw_model()
	{
		echo "<option value=''>--Please Select Model--</option>";
		$make = $this->input->post('make');
		$model1 = $this->Tata_fw_model->get_all_model($make);
		// print_r($make);print_r($model1);exit();
		foreach ($model1 as $model) {
			echo "<option value='$model->model'>" . $model->model . "</option>";
		}
	}
	public function get_fw_variant()
	{
		echo "<option value=''>--Please Select Variant--</option>";
		$make = $this->input->post('make');
		$model = $this->input->post('model');
		$variant = $this->Tata_fw_model->get_all_variants($make, $model);
		foreach ($variant as $variant) {
			echo "<option value='$variant->variant'>" . $variant->variant . "</option>";
		}
	}
	public function get_fw_fuel()
	{
		$make = $this->input->post('make');
		$model = $this->input->post('model');
		$variant = $this->input->post('variant');
		$fuel_type = $this->Tata_fw_model->get_fw_fuel($make, $model, $variant);
		//   $fuel_data = $this->bajaj_fw_model->get_fuel_data($fuel_type->operated_by);		// foreach($fuel_type as $fuel_type)
		// {
		echo "<option value='$fuel_type->fuel_type' >" . $fuel_type->fuel_type . "</option>";		// }
	}
	function tataAddonCheck($addonArray, &$mainArray)
	{
		/* "--dep_reimburse_prem": "1569.02",
            "--daily_allowance_limit": "",
            "--return_invoice_prem": 0,
            "--ncb_protection_prem": 0,
            "--personal_loss_prem": 110,
            "--key_replace_prem": 265,
            "--engine_secure_prem": 0,
            "--tyre_secure_prem": 0,
            "--consumbale_expense_prem": 0,
            "repair_glass_prem": 0,
            "--rsa_prem": 116,
            "--emergency_expense_prem": 110, */
		$addonSelected = array();
		$i = 0;
		foreach ($addonArray as $key => $value) {
			// if (in_array((string)$value->name, $list) and (float)$value->value != 0) {
			// 	$addonSelected[strval($value->name)] = (float) $value->value;
			// }
			$getAddonsForData = [];
			if ($key == 'total_addon') continue;
			if ($value != 0) {
				$addonSelected[convertString(str_ireplace("prem", '', $key), false)] = $value;
				switch ($key) {
					case 'dep_reimburse_prem':
						$mainArray['addon1_checked'] = 'Yes';
						break;
					case 'personal_loss_prem':
						$mainArray['addon2_checked'] = 'Yes';
						break;
					case 'emergency_expense_prem':
						$mainArray['addon3_checked'] = 'Yes';
						break;
					case 'key_replace_prem':
						$mainArray['addon4_checked'] = 'Yes';
						break;
					case 'engine_secure_prem':
						$mainArray['addon5_checked'] = 'Yes';
						break;
					case 'consumbale_expense_prem':
						$mainArray['addon6_checked'] = 'Yes';
						break;
					case 'tyre_secure_prem':
						$mainArray['addon8_checked'] = 'Yes';
						break;
					case 'ncb_protection_prem':
						$mainArray['addon9_checked'] = 'Yes';
						break;
					case 'rsa_prem':
						$mainArray['addon10_checked'] = 'Yes';
						break;
					case 'return_invoice_prem':
						$mainArray['addon11_checked'] = 'Yes';
						break;
					case 'daily_allowance_limit':
						$mainArray['addon12_checked'] = 'Yes';
						break;

					default:
						break;
				}
			} else {
				switch ($key) {
					case 'dep_reimburse_prem':
						unset($mainArray['addon1_checked']);
						break;
					case 'personal_loss_prem':
						unset($mainArray['addon2_checked']);
						break;
					case 'emergency_expense_prem':
						unset($mainArray['addon3_checked']);
						break;
					case 'key_replace_prem':
						unset($mainArray['addon4_checked']);
						break;
					case 'engine_secure_prem':
						unset($mainArray['addon5_checked']);
						break;
					case 'consumbale_expense_prem':
						unset($mainArray['addon6_checked']);
						break;
					case 'tyre_secure_prem':
						unset($mainArray['addon8_checked']);
						break;
					case 'ncb_protection_prem':
						unset($mainArray['addon9_checked']);
						break;
					case 'rsa_prem':
						unset($mainArray['addon10_checked']);
						break;
					case 'return_invoice_prem':
						unset($mainArray['addon11_checked']);
						break;
					case 'daily_allowance_limit':
						unset($mainArray['addon12_checked']);
						break;

					default:
						break;
				}
			}
		}
		return $addonSelected;
	}

	function getRTO($vehicle)
	{
		$rtoCode = '';
		if (strlen($vehicle) < 6) $rtoCode = $vehicle;
		else {
			$rtoCode = substr($vehicle, 0, 5);
		}
		// $rtoDetails = $this->Tata_tw_model->RTO($rtoCode);
		return $this->Tata_fw_model->rto(str_replace("-", "", $rtoCode));
	}
	function getRelation($uid)
	{
		$relatives = $this->Tata_tw_model->getRelation();
		return $relatives;
	}
	function error($uid)
	{
		$data['heading'] = 'Sorry you cannot move forward!';
		$data['message'] = 'Kindly Try again!';
		// $data['response'] = $sbiJson;
		$this->load->view('partials/header', $data);
		$this->load->view('errors/html/error_home.php', $data);
		$this->load->view('partials/footer');
	}
	function getAddonBundle($data)
	{
		return $data['bundle_name'] ? "You selected Addon plan <b>'{$data['bundle_name']}'" : null;
		
	}
	function protectionOfNCB($code)
	{
		$ncb = 0;
		if ($code == 0) {
			$ncb = 20;
		}
		if ($code == 20) {
			$ncb = 25;
		}
		if ($code == 25) {
			$ncb = 35;
		}
		if ($code == 35) {
			$ncb = 45;
		}
		if ($code == 45) {
			$ncb = 50;
		}
		if ($code == 50) {
			$ncb = 50;
		}
		return $ncb;
	}
	function getValue($arr, $name)
	{
		foreach ($arr as $key => $value) {
			if ($value->name == ucwords($name)) {
				return (string)$value->value;
			} else if (stripos($value->name, '(IDV)') and stripos($name, 'IDV')) {
				return (string)$value->value;
			} else if ($value->name == ($name)) {
				return (string)$value->value;
			}
		}
		return null;
	}
}
