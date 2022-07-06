<?php
class Tata_fw_model extends CI_Model
{

  function auth()
  {


    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://uatapigw-tataaig.auth.ap-south-1.amazoncognito.com/oauth2/token',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=https%3A%2F%2Fapi.iorta.in%2Fwrite&client_id=4dvjgdbs2bl516rl03jh5oli5j&client_secret=r7pigrbhnqpl69bn5rt7gko7333ej06d628ttgi95t3m9h8okqs',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true)['access_token'];
  }
  function __construct()
  {
    parent::__construct();
  }
  function get_ncb_by_name($ncbname)
  {
    $this->db->select('*');
    $this->db->from('godigit_ncb_master');
    $this->db->where('ncb_name', $ncbname);
    $this->db->where('is_active', '1');
    $query = $this->db->get();
    // print_r($query->result());exit();
    return $query->row();
  }

  function add_policy_data($policy_data)
  {
    $this->db->insert('policy_master', $policy_data);
    return $this->db->insert_id();
  }

  function add_proposal_data($proposal_data)
  {
    $this->db->insert('proposal_customer', $proposal_data);
    return $this->db->insert_id();
  }
  function insert_crn($crn_data)
  {
    $this->db->insert('tw_crn', $crn_data);
    return $this->db->insert_id();
  }
  function get_last_crn()
  {
    $this->db->select('*');
    $this->db->from('tw_crn');
    $this->db->limit(1);
    $this->db->order_by('id', "DESC");
    $query = $this->db->get();
    return $query->row();
  }
  function fw_previous_insurer()
  {
    $this->db->select('*');
    $this->db->from('tata_prev_insurers');
    // $this->db->where('is_active', '1');
    $query = $this->db->get();
    // print_r($query->result());exit();
    return $query->result();
  }
  function get_all_make_four_wheeler()
  {
    $query = $this->db->query("SELECT make FROM tata_vehicle_master_4w GROUP BY `make`;");
    return $query->result();
  }
  function get_all_model($make)
  {
    $this->db->select('*');
    $this->db->from('tata_vehicle_master_4w');
    $this->db->where('make', $make);
    $this->db->group_by('model');
    $query = $this->db->get();
    return $query->result();
  }
  function get_all_variants($make, $model)
  {
    $this->db->select('*');
    $this->db->from('tata_vehicle_master_4w');
    $this->db->where('make', $make);
    $this->db->where('model', $model);
    $this->db->group_by('variant');
    $query = $this->db->get();
    return $query->result();
  }

  function get_fw_fuel($make, $model, $variant)
  {

    $this->db->select('*');
    $this->db->from('tata_vehicle_master_4w');
    $this->db->where(array('make' => $make, 'model' => $model, 'variant' => $variant));
    $query = $this->db->get();
    return $query->row();
  }
  function get_perticular_vehicle($make, $model, $variant)
  {

    $this->db->select('*');
    $this->db->from('sbi_vehicle_master');
    $this->db->where('make_id', $make);
    $this->db->where('model_id', $model);
    $this->db->where('variant_id', $variant);
    $query = $this->db->get();
    return $query->row();
  }

  function fetchNCB($code)
  {
    if ($code == '') {
      $code = 0;
    }
    if (empty($code)) {
      $code = 0;
    }
    if ($code == 20) {
      $code = 0;
    }
    if ($code == 25) {
      $code = 20;
    }
    if ($code == 35) {
      $code = 25;
    }
    if ($code == 45) {
      $code = 35;
    }
    if ($code == 50) {
      $code = 45;
    }
    if ($code == 55) {
      $code = 50;
    }
    return $code;
  }


  // developer 6 
  function get_all_policies()
  {
  }

  function get_vehicle_details($data)
  {
    // print_r($data);
    $this->db->select('*');
    $this->db->from('tata_vehicle_master_4w');
    $this->db->where(array('make' => $data['car_make'], 'model' => $data['car_model'], 'variant' => $data['car_variant']));
    $query = $this->db->get();
    return $query->row();
  }


  function tata_car_quote($data)
  {
    $data['od_opt'] = ($data['car_product_code'] == 'PACKAGE') ? 'Y' : 'N';
    $data['coverCode'] = ($data['car_product_code'] == 'PACKAGE') ? 1 : 2;
    $data['start_date'] = (strtotime($data['previousPolicyExpiryDate']) > strtotime(date('Y-m-d'))) ? date('Y-m-d', strtotime("+1 days", strtotime($data['previousPolicyExpiryDate']))) : date('Y-m-d', strtotime("+1day"));
    $data['end_date'] = date('Y-m-d', strtotime("+1years -1 days", strtotime($data['start_date'])));
    $data['vnum'] = explode('-', $data['four_wheeler_registration_number']);
    $data['isClaiminLastYear_'] = ($data['isClaiminLastYear']) ? 'Y' : 'N';
    if (!empty($data['unnamed']) or $data['unnamed'] != 0) {
      $data['unnamedyn'] = 'Y';
    } else {
      $data['unnamed'] = '';
      $data['unnamedyn'] = 'N';
    }
    $data['previousPolicyType'] = ($data['isPreviousPolicyComprehensive']) ? 'Package' : 'Liability';
    $data['cng_kit'] = ($data['premium_for_cng_by_user'] or ($data['cng_tp'] == 'Y' and $data['car_product_code'] == 'LIABILITY')) ? 'Yes' : 'No';
    $json = '{
      "source": "P",
      "q_producer_email": "ervfwed.nucsoft@tataaig.com",
      "q_producer_code": "1234067899",
      "pol_plan_id": "' . strval($data['car_product_code'] == 'PACKAGE' ? "02" : "01") . '",
      "place_reg": "' . $data['rto']['rto_location'] . '",
      "place_reg_code": "' . $data['rto']['rto_location_code'] . '",
      "vehicle_make": "' . $data['make'] . '",
      "vehicle_model": "' . $data['model'] . '",
      "vehicle_variant": "' . $data['variant'] . '",
      "proposer_type": "' . $data['car_customer_type'] . '",
      "proposer_pincode": "' . $data['rto']['pincode'] . '",
      "proposer_gstin": "24AABCU9603R1ZT",
      "proposer_salutation": "Ms",
      "proposer_email": "' . $data['emailuser'] . '",
      "proposer_mobile": "' . $data['number'] . '",
      "business_type_no": "03",
      "dor": "' . $data['car_register_date'] . '",
      "prev_pol_end_date": "' . $data['previousPolicyExpiryDate'] . '",
      "prev_pol_start_date": "' . date('Y-m-d', strtotime("-1years +1day", strtotime($data['previousPolicyExpiryDate']))) . '",
      "man_year": ' . $data['car_register_year'] . ',
      "pol_start_date": "' . $data['start_date'] . '",
      "ble_tp_start": "",
      "ble_tp_end": "",
      "prev_pol_type": "' . $data['previousPolicyType'] . '",
      "claim_last": "' . strval(($data['isClaimInLastYear']) ? 'true' : 'false') . '",
      "pre_pol_ncb": "' . $data['previousNoClaimBonus'] . '",
      "curr_ncb": "' . $data['current_ncb'] . '",
      "regno_1": "' . $data['vnum'][0] . '",
      "regno_2": "' . $data['vnum'][1] . '",
      "regno_3": "' . $data['vnum'][2] . '",
      "regno_4": "' . $data['vnum'][3] . '",
      "cng_lpg_cover": "' . $data['cng_kit'] . '",
      "cng_lpg_si": "' . $data['premium_for_cng_by_user'] . '",
      "electrical_si": "",
      "non_electrical_si": "",
      "uw_loading": "",
      "uw_remarks": "",
      "uw_discount": "",
      "tyre_secure":"' . $data['addon8'] . '",
       "prev_consumable": "",
       "prev_cnglpg": "' . strval($data['prev_cng_yes_or_no'] == 'Y' ? 'Yes' : 'No') . '",
       "prev_engine": "",
       "prev_tyre": "",
       "prev_dep": "No",
      "tyre_secure_options": "REPLACEMENT BASIS",
      "engine_secure":"' . $data['addon5'] . '",
      "engine_secure_options": "WITH DEDUCTIBLE",
      "dep_reimburse": "' . $data['addon1'] . '",
      "dep_reimburse_claims":  "2",
      "add_towing": "No",
      "add_towing_amount": "",
      "return_invoice": "' . $data['addon11'] . '",
      "rsa": "' . $data['addon10'] . '",
      "consumbale_expense":"' . $data['addon6'] . '",
      "key_replace": "' . $data['addon4'] . '",
      "repair_glass": "' . $data['addon7'] . '",
      "emergency_expense": "' . $data['addon3'] . '",
      "personal_loss": "' . $data['addon2'] . '",
      "daily_allowance": "No",
      "allowance_days_accident": "",
      "daily_allowance_limit": "",
      "allowance_days_loss": "",
      "franchise_days": "",
      "pa_owner": "' . strval(($data['owner_driver'] == 'Y') ? 'true' : 'false') . '",
      "pa_owner_tenure": "1",
      "pa_owner_declaration": "' . strval($data['owner_driver'] == 'Y' ? 'None' : 'No valid driving license') . '",
      "pa_unnamed": "' . strval(($data['unnamed']) ? 'Yes'  : 'No') . '",
      "pa_unnamed_no": "' .  strval(($data['unnamed']) ? $data['sc']  : '') . '",
      "pa_unnamed_si": "' . strval(($data['unnamed']) ? $data['unnamed']  : '') . '",
      "pa_named": "No",
      "pa_paid": "' . strval(($data['paid_driver'] == 'Y') ? 'Yes' : 'No') . '",
      "pa_paid_no": "' . strval(($data['paid_driver'] == 'Y') ? '1' : '') . '",
      "pa_paid_si": "' . strval(($data['paid_driver'] == 'Y') ? 100000 : null) . '",
      "ll_paid": "'. strval($data['ll_paid'] == 'Y' ? 'Yes' : null).'",
      "ll_paid_no": "'. strval( $data['ll_paid'] == 'Y' ? 1 : null) .'",
      "ll_paid_si": "'. strval( $data['ll_paid'] == 'Y' ? 1 : null) .'",
      "automobile_association_cover": "No",
      "vehicle_blind": "No",
      "antitheft_cover": "No",
      "voluntary_amount": "",
      "tppd_discount": "No",
      "vintage_car": "No",
      "own_premises": "No",
      "load_fibre": "No",
      "load_imported": "No",
      "load_tuition": "No",
      "pa_unnamed_csi": "",
      "vehicle_make_no": ' . $data['make_code'] . ',
      "vehicle_model_no": ' . $data['model_code'] . ',
      "vehicle_variant_no": "' . $data['model_variant_code'] . '",
      "place_reg_no": "' . $data['rto']['rto_location_code'] . '",
      "pol_plan_variant": "' . strval(($data['car_product_code'] == 'PACKAGE') ? 'PackagePolicy' : 'Standalone TP') . '",
      "proposer_fname": "geeta",
      "proposer_mname": "",
      "proposer_lname": "trimukhe",
      "pre_pol_protect_ncb": null,
      "claim_last_amount": null,
      "claim_last_count": null,
      "quote_id": "",
      "product_id": "M300000000001",
      "product_code": "3184",
      "product_name": "Private Car",
      "ncb_protection": "' . $data['addon9'] . '",
      "ncb_no_of_claims": "2",
      "motor_plan_opted": "' . $data['bundle_name'] . '",
      "motor_plan_opted_no": "' . $data['bundle_code'] . '",
      "vehicle_idv": "' . $data['idv'] . '",
      "no_past_pol": "N", 
      "__finalize": "0"
   }';
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://uatapigw.tataaig.com/motor/v1/quote',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $json,
      CURLOPT_HTTPHEADER => array(
        'Authorization: ' . $this->auth(),
        'x-api-key: 5QerRezeZs3PrVdLQu79c1v9Nsh5S7BOan26zc7P',
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo "<script>console.log(`{" . print_r($data, true) . "}`)</script>";
    echo "<script>console.log(`{$json}`)</script>";
    echo "<script>console.log(`{$response}`)</script>";
    curl_close($curl);
    return json_decode($response);
  }
  function newVehiclePremium($data)
  {
    $data['start_date'] = date('Y-m-d', strtotime("+1 days")/* , strtotime("+1 days") */);


    $data['vnum'] = explode('-', $data['rto']['rto_code']);
    if (!empty($data['unnamed']) or $data['unnamed'] != 0) {
      $data['unnamedyn'] = 'Y';
    } else {
      $data['unnamed'] = '';
      $data['unnamedyn'] = 'N';
    }
    $data['cng_kit'] = ($data['premium_for_cng_by_user']) ? 'Yes' : 'No';

    $json = '{
      "source": "P",
      "q_producer_code": "1234067899",
      "pol_plan_id": "04",
      "place_reg": "' . $data['rto']['rto_location'] . '",
      "vehicle_make": "' . $data['make'] . '",
      "vehicle_model": "' . $data['model'] . '",
      "vehicle_variant": "' . $data['variant'] . '",
      "proposer_type": "' . $data['car_customer_type'] . '",
      "proposer_pincode": "' . $data['rto']['pincode'] . '",
      "proposer_gstin": "",
      "proposer_salutation": "Mr",
      "proposer_email": "' . $data['emailuser'] . '",
      "proposer_mobile": "' . $data['number'] . '",
      "business_type_no": "01",
      "dor": "' . $data['car_register_date'] . '",
      "prev_pol_end_date": "",
      "man_year": ' . $data['car_register_year'] . ',
      "pol_start_date": "' . $data['start_date'] . '",
      "prev_pol_type": "",
      "claim_last": "false",
      "pre_pol_ncb": "",
      "regno_1": "NEW",
      "regno_2": "",
      "regno_3": "",
      "regno_4": "",
      "cng_lpg_cover": "' . $data['cng_kit'] . '",
      "cng_lpg_si": "' . $data['premium_for_cng_by_user'] . '",
      "electrical_si": "",
      "non_electrical_si": "",
      "uw_loading": "",
      "uw_remarks": "",
      "uw_discount": "",
      "tyre_secure":"' . $data['addon8'] . '",
      "tyre_secure_options": "REPLACEMENT BASIS",
      "prev_tyre":"No",
      "engine_secure":"' . $data['addon5'] . '",
      "engine_secure_options": "WITH DEDUCTIBLE",
      "prev_engine":"No",
      "dep_reimburse": "' . $data['addon1'] . '",
      "prev_dep":"No",
      "dep_reimburse_claims":  "2",
      "add_towing": "No",
      "add_towing_amount": "",
      "return_invoice": "' . $data['addon11'] . '",
      "rsa": "' . $data['addon10'] . '",
      "consumbale_expense":"' . $data['addon6'] . '",
      "prev_consumable":"",
      "key_replace": "' . $data['addon4'] . '",
      "repair_glass": "' . $data['addon7'] . '",
      "emergency_expense": "' . $data['addon3'] . '",
      "personal_loss": "' . $data['addon2'] . '",
      "daily_allowance": "No",
      "allowance_days_accident": "",
      "daily_allowance_limit": "",
      "allowance_days_loss": "",
      "franchise_days": "",
      "pa_owner": "' . strval(($data['owner_driver'] == 'Y') ? 'true' : 'false') . '",
      "pa_owner_tenure": "3",
      "pa_owner_declaration": "' . strval($data['owner_driver'] == 'Y' ? 'None' : 'No valid driving license') . '",
      "pa_unnamed": "' . strval(($data['unnamed']) ? 'Yes'  : 'No') . '",
      "pa_unnamed_no": "' .  strval(($data['unnamed']) ? $data['sc']  : '') . '",
      "pa_unnamed_si": "' . strval(($data['unnamed']) ? $data['unnamed']  : '') . '",
      "pa_named": "No",
      "pa_paid": "' . strval(($data['paid_driver'] == 'Y') ? 'Yes' : 'No') . '",
      "pa_paid_no": "' . strval(($data['paid_driver'] == 'Y') ? '1' : '') . '",
      "pa_paid_si": "' . strval(($data['paid_driver'] == 'Y') ? 100000 : null) . '",
      "ll_paid": "'. strval($data['ll_paid'] == 'Y' ? 'Yes' : null).'",
      "ll_paid_no": "'. strval( $data['ll_paid'] == 'Y' ? 1 : null) .'",
      "ll_paid_si": "'. strval( $data['ll_paid'] == 'Y' ? 1 : null) .'",
      "automobile_association_cover": "No",
      "vehicle_blind": "No",
      "antitheft_cover": "No",
      "voluntary_amount": "",
      "tppd_discount": "No",
      "vintage_car": "No",
      "own_premises": "No",
      "load_fibre": "No",
      "load_imported": "No",
      "load_tuition": "No",
      "pa_unnamed_csi": "",
      "vehicle_make_no": ' . $data['make_code'] . ',
      "vehicle_model_no": ' . $data['model_code'] . ',
      "vehicle_variant_no": "' . $data['model_variant_code'] . '",
      "place_reg_no": "' . $data['rto']['rto_location_code'] . '",
      "pol_plan_variant": "PackagePolicy",
      "proposer_fname": "Tejas",
      "proposer_mname": "",
      "proposer_lname": "Raut",
      "pre_pol_protect_ncb": null,
      "claim_last_amount": "",
      "claim_last_count": "",
      "quote_id": "",
      "product_id": "M300000000001",
      "product_code": "3184",
      "product_name": "Private Car",
      "ncb_protection": "' . $data['addon9'] . '",
      "ncb_no_of_claims": "0",
      "motor_plan_opted": "' . $data['bundle_name'] . '",
      "motor_plan_opted_no": "' . $data['bundle_code'] . '",
      "vehicle_idv": "' . $data['idv'] . '",
      "__finalize": "0"
    }';
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://uatapigw.tataaig.com/motor/v1/quote',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $json,
      CURLOPT_HTTPHEADER => array(
        'Authorization: ' . $this->auth(),
        'x-api-key: 5QerRezeZs3PrVdLQu79c1v9Nsh5S7BOan26zc7P',
        'Content-Type: application/json'
      ),
    ));


    $response = curl_exec($curl);
    echo "<script>console.log(`{$json}`)</script>";
    echo "<script>console.log(`{$response}`)</script>";
    curl_close($curl);
    return json_decode($response);
  }

  function tataFullQuote($data)
  {
    $data['start_date'] = date('Y-m-d', strtotime("+1 days"));
    $data['end_date'] = date('Y-m-d', strtotime("+1years -1 days", strtotime(join(array_insert(array_insert(str_split($data['start_date']), '-', 4), '-', 7)))));
    $data['new_vehicle'] = 'N';
    $data['policy_term'] = 1;
    $data['vnum'] = explode('-', $data['four_wheeler_registration_number']);
    $data['state_code'] = $data['vnum'][0];
    if ($data['car_product_code'] == 'LIABILITY') $data['current_ncb'] = 0;
    if (!empty($data['unnamed']) or $data['unnamed'] != 0) {
      $data['unnamedyn'] = 'Y';
    } else {
      $data['unnamed'] = '';
      $data['unnamedyn'] = 'N';
    }
    $data['previousPolicyType'] = ($data['isPreviousPolicyComprehensive']) ? 'Package' : 'Liability';

    $data['cng_kit'] = ($data['premium_for_cng_by_user'] or ($data['cng_tp'] == 'Y' and $data['car_product_code'] == 'LIABILITY')) ? 'Yes' : 'No';


    $body = '{
      "source": "P",
      "q_producer_email": "ervfwed.nucsoft@tataaig.com",
      "q_producer_code": "1234067899",
      "pol_plan_id": "' . strval($data['car_product_code'] == 'PACKAGE' ? "02" : "01") . '",
      "place_reg": "' . $data['rto']['rto_location'] . '",
      "vehicle_make": "' . $data['make'] . '",
      "vehicle_model": "' . $data['model'] . '",
      "vehicle_variant": "' . $data['variant'] . '",
      "proposer_type": "' . $data['car_customer_type'] . '",
      "proposer_pincode": "' . $data['present_pincode'] . '",
      "proposer_gstin": "' . $data['gstin'] . '",
      "proposer_salutation": "' . $data['salutation'] . '",
      "proposer_email": "' . $data['emailuser'] . '",
      "proposer_mobile": "' . $data['number'] . '",
      "business_type_no": "03",
      "dor": "' . $data['car_register_date'] . '",
      "prev_pol_end_date": "' . $data['previousPolicyExpiryDate'] . '",
      "prev_pol_start_date": "' . date('Y-m-d', strtotime("-1years +1day", strtotime($data['previousPolicyExpiryDate']))) . '",
      "man_year": ' . $data['car_register_year'] . ',
      "pol_start_date": "' . $data['start_date'] . '",
      "ble_tp_start": "",
      "ble_tp_end": "",
      "prev_pol_type": "' . $data['previousPolicyType'] . '",
      "claim_last": "' . strval(($data['isClaimInLastYear']) ? 'true' : 'false') . '",
      "pre_pol_ncb": "' . $data['previousNoClaimBonus'] . '",
      "regno_1": "' . $data['vnum'][0] . '",
      "regno_2": "' . $data['vnum'][1] . '",
      "regno_3": "' . $data['vnum'][2] . '",
      "regno_4": "' . $data['vnum'][3] . '",
      "cng_lpg_cover": "' . $data['cng_kit'] . '",
      "cng_lpg_si": "' . $data['premium_for_cng_by_user'] . '",
      "electrical_si": "",
      "non_electrical_si": "",
      "uw_loading": "",
      "uw_remarks": "",
      "uw_discount": "",
      "tyre_secure":"' . $data['addon8'] . '",
       "prev_consumable": "",
       "prev_cnglpg": "' . strval($data['prev_cng_yes_or_no'] == 'Y' ? 'Yes' : 'No') . '",
       "prev_engine": "",
       "prev_tyre": "",
       "prev_dep": "No",
      "tyre_secure_options": "REPLACEMENT BASIS",
      "engine_secure":"' . $data['addon5'] . '",
      "engine_secure_options": "WITH DEDUCTIBLE",
      "dep_reimburse": "' . $data['addon1'] . '",
      "dep_reimburse_claims":  "2",
      "add_towing": "No",
      "add_towing_amount": "",
      "return_invoice": "' . $data['addon11'] . '",
      "rsa": "' . $data['addon10'] . '",
      "consumbale_expense":"' . $data['addon6'] . '",
      "key_replace": "' . $data['addon4'] . '",
      "repair_glass": "' . $data['addon7'] . '",
      "emergency_expense": "' . $data['addon3'] . '",
      "personal_loss": "' . $data['addon2'] . '",
      "daily_allowance": "No",
      "allowance_days_accident": "",
      "daily_allowance_limit": "",
      "allowance_days_loss": "",
      "franchise_days": "",
      "pa_owner": "' . strval(($data['owner_driver'] == 'Y') ? 'true' : 'false') . '",
      "pa_owner_tenure": "1",
      "pa_owner_declaration": "' . strval($data['owner_driver'] == 'Y' ? 'None' : 'No valid driving license') . '",
      "pa_unnamed": "' . strval(($data['unnamed']) ? 'Yes'  : 'No') . '",
      "pa_unnamed_no": "' .  strval(($data['unnamed']) ? $data['sc']  : '') . '",
      "pa_unnamed_si": "' . strval(($data['unnamed']) ? $data['unnamed']  : '') . '",
      "pa_named": "No",
      "pa_paid": "' . strval(($data['paid_driver'] == 'Y') ? 'Yes' : 'No') . '",
      "pa_paid_no": "' . strval(($data['paid_driver'] == 'Y') ? '1' : '') . '",
      "pa_paid_si": "' . strval(($data['paid_driver'] == 'Y') ? 100000 : null) . '",
      "ll_paid": "'. strval($data['ll_paid'] == 'Y' ? 'Yes' : null).'",
      "ll_paid_no": "'. strval( $data['ll_paid'] == 'Y' ? 1 : null) .'",
      "ll_paid_si": "'. strval( $data['ll_paid'] == 'Y' ? 1 : null) .'",
      "automobile_association_cover": "No",
      "vehicle_blind": "No",
      "antitheft_cover": "No",
      "voluntary_amount": "",
      "tppd_discount": "No",
      "vintage_car": "No",
      "own_premises": "No",
      "load_fibre": "No",
      "load_imported": "No",
      "load_tuition": "No",
      "pa_unnamed_csi": "",
      "vehicle_make_no": ' . $data['make_code'] . ',
      "vehicle_model_no": ' . $data['model_code'] . ',
      "vehicle_variant_no": "' . $data['model_variant_code'] . '",
      "place_reg_no": "' . $data['rto']['rto_location_code'] . '",
      "pol_plan_variant": "' . strval(($data['car_product_code'] == 'PACKAGE') ? 'PackagePolicy' : 'Standalone TP') . '",
      "proposer_fname": "geeta",
      "proposer_mname": "",
      "proposer_lname": "trimukhe",
      "pre_pol_protect_ncb": null,
      "claim_last_amount": null,
      "claim_last_count": null,
      "quote_id": "' . $data['quote_id'] . '",
      "product_id": "M300000000001",
      "product_code": "3184",
      "product_name": "Private Car",
      "ncb_protection": "' . $data['addon9'] . '",
      "ncb_no_of_claims": "2",
      "motor_plan_opted": "' . $data['bundle_name'] . '",
      "motor_plan_opted_no": "' . $data['bundle_code'] . '",
      "vehicle_idv": "' . $data['idv'] . '",
      "no_past_pol": "N", 
      "__finalize": "1"
   }
    ';
    // $body);
    // nextLine();
    $curl = curl_init();

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://uatapigw.tataaig.com/motor/v1/quote',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $body,
      CURLOPT_HTTPHEADER => array(
        'Authorization: ' . $this->auth(),
        'x-api-key: 5QerRezeZs3PrVdLQu79c1v9Nsh5S7BOan26zc7P',
        'Content-Type: application/json'
      ),
    ));
    $response = curl_exec($curl);
    $this->session->set_userdata('fullquoteBody', $body);
    $this->session->set_userdata('fullquoteRes', $response);
    curl_close($curl);
    // echo $body;
    // nextLine();
    $this->session->set_userdata(array('fqbody' => $body, 'fqresponse' => $response));
    // echo $response;
    // nextLine();
    return json_decode($response, true);
  }

  function newTataFullQuote($data)
  {
    $data['start_date'] = date('Y-m-d', strtotime("+1 days"));
    $data['end_date'] = date('Y-m-d', strtotime("+1years -1 days"));
    $data['policy_term'] = 1;
    $data['vnum'] = explode('-', strtoupper($data['four_wheeler_registration_number']));
    $data['state_code'] = $data['vnum'][0];
    $data['cng_kit'] = ($data['premium_for_cng_by_user']) ? 'Yes' : 'No';

    $json = '{
      "source": "P",
      "q_producer_code": "1234067899",
      "pol_plan_id": "04",
      "place_reg": "' . $data['rto']['rto_location'] . '",
      "vehicle_make": "' . $data['make'] . '",
      "vehicle_model": "' . $data['model'] . '",
      "vehicle_variant": "' . $data['variant'] . '",
      "proposer_type": "' . $data['car_customer_type'] . '",
      "proposer_pincode": "' . $data['present_pincode'] . '",
      "proposer_gstin": "' . $data['gstin'] . '",
      "proposer_salutation": "' . $data['salutation'] . '",
      "proposer_email": "' . $data['emailuser'] . '",
      "proposer_mobile": "' . $data['number'] . '",
      "business_type_no": "01",
      "dor": "' . $data['car_register_date'] . '",
      "prev_pol_end_date": "",
      "man_year": ' . $data['car_register_year'] . ',
      "pol_start_date": "' . $data['start_date'] . '",
      "prev_pol_type": "",
      "claim_last": "false",
      "pre_pol_ncb": "",
      "regno_1": "NEW",
      "regno_2": "",
      "regno_3": "",
      "regno_4": "",
      "cng_lpg_cover": "' . $data['cng_kit'] . '",
      "cng_lpg_si": "' . $data['premium_for_cng_by_user'] . '",
      "electrical_si": "",
      "non_electrical_si": "",
      "uw_loading": "",
      "uw_remarks": "",
      "uw_discount": "",
      "tyre_secure":"' . $data['addon8'] . '",
      "tyre_secure_options": "REPLACEMENT BASIS",
      "prev_tyre":"No",
      "engine_secure":"' . $data['addon5'] . '",
      "engine_secure_options": "WITH DEDUCTIBLE",
      "prev_engine":"No",
      "dep_reimburse": "' . $data['addon1'] . '",
      "prev_dep":"No",
      "dep_reimburse_claims":  "2",
      "add_towing": "No",
      "add_towing_amount": "",
      "return_invoice": "' . $data['addon11'] . '",
      "rsa": "' . $data['addon10'] . '",
      "consumbale_expense":"' . $data['addon6'] . '",
      "prev_consumable":"",
      "key_replace": "' . $data['addon4'] . '",
      "repair_glass": "' . $data['addon7'] . '",
      "emergency_expense": "' . $data['addon3'] . '",
      "personal_loss": "' . $data['addon2'] . '",
      "daily_allowance": "No",
      "allowance_days_accident": "",
      "daily_allowance_limit": "",
      "allowance_days_loss": "",
      "franchise_days": "",
      "pa_owner": "' . strval(($data['owner_driver'] == 'Y') ? 'true' : 'false') . '",
      "pa_owner_tenure": "3",
      "pa_owner_declaration": "' . strval($data['owner_driver'] == 'Y' ? 'None' : 'No valid driving license') . '",
      "pa_unnamed": "' . strval(($data['unnamed']) ? 'Yes'  : 'No') . '",
      "pa_unnamed_no": "' .  strval(($data['unnamed']) ? $data['sc']  : '') . '",
      "pa_unnamed_si": "' . strval(($data['unnamed']) ? $data['unnamed']  : '') . '",
      "pa_named": "No",
      "pa_paid": "' . strval(($data['paid_driver'] == 'Y') ? 'Yes' : 'No') . '",
      "pa_paid_no": "' . strval(($data['paid_driver'] == 'Y') ? '1' : '') . '",
      "pa_paid_si": "' . strval(($data['paid_driver'] == 'Y') ? 100000 : null) . '",
      "ll_paid": "'. strval($data['ll_paid'] == 'Y' ? 'Yes' : null).'",
      "ll_paid_no": "'. strval( $data['ll_paid'] == 'Y' ? 1 : null) .'",
      "ll_paid_si": "'. strval( $data['ll_paid'] == 'Y' ? 1 : null) .'",
      "automobile_association_cover": "No",
      "vehicle_blind": "No",
      "antitheft_cover": "No",
      "voluntary_amount": "",
      "tppd_discount": "No",
      "vintage_car": "No",
      "own_premises": "No",
      "load_fibre": "No",
      "load_imported": "No",
      "load_tuition": "No",
      "pa_unnamed_csi": "",
      "vehicle_make_no": ' . $data['make_code'] . ',
      "vehicle_model_no": ' . $data['model_code'] . ',
      "vehicle_variant_no": "' . $data['model_variant_code'] . '",
      "place_reg_no": "' . $data['rto']['rto_location_code'] . '",
      "pol_plan_variant": "PackagePolicy",
      "proposer_fname": "Tejas",
      "proposer_mname": "",
      "proposer_lname": "Raut",
      "pre_pol_protect_ncb": null,
      "claim_last_amount": "",
      "claim_last_count": "",
      "quote_id": "' . $data['quote_id'] . '",
      "product_id": "M300000000001",
      "product_code": "3184",
      "product_name": "Private Car",
      "ncb_protection": "' . $data['addon9'] . '",
      "ncb_no_of_claims": "0",
      "motor_plan_opted": "' . $data['bundle_name'] . '",
      "motor_plan_opted_no": "' . $data['bundle_code'] . '",
      "vehicle_idv": "' . $data['idv'] . '",
      "__finalize": "1"
    }';
    // echo ($json);
    // nextLine();
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://uatapigw.tataaig.com/motor/v1/quote',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $json,
      CURLOPT_HTTPHEADER => array(
        'Authorization: ' . $this->auth(),
        'x-api-key: 5QerRezeZs3PrVdLQu79c1v9Nsh5S7BOan26zc7P',
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);
    $this->session->set_userdata('fullquoteBody', $json);
    $this->session->set_userdata('fullquoteRes', $response);
    curl_close($curl);
    // echo $json; nextLine();
    // echo $response; nextLine();
    $this->session->set_userdata(array('fqbody' => $json, 'fqresponse' => $response));

    return json_decode($response, true);
  }
  function proposal($data)
  {
    if ($data['caseType'] == 'roll_over') {
      $data['previousInsurerName'] = (getValueDB('tata_prev_insurers', array('insurer_code', $data['previousInsurerCode']), 'insurer_name')[0])["insurer_name"];
      // var_dump($data['previousInsurerName']);
    }
    // echo $data['finance'];

    $data['financier_city'] = ($data['finance'] == 1) ? $data['financier_city'] : '';
    $data['prev_policy_exist'] = ($data['caseType'] == 'roll_over') ? 'Y' : 'N';
    $data['bundled_policy'] = ($data['caseType'] == 'roll_over') ? 'N' : 'Y';
    $data['start_date'] = ($data['caseType'] == 'roll_over') ? date('Y-m-d', strtotime('+1 days')) : date('Y-m-d');
    $data['pucExpDate'] = $data['start_date'];
    $json = '{
      "proposer_gender": "' . $data['proposer_gender'] . '",
      "proposer_marital": "' . $data['marital_status'] . '",
      "proposer_salutation":"' . ucfirst(strtolower($data['salutation'])) . '",
      "proposer_fname":"' . $data['first_name'] . '",
      "proposer_lname":"' . $data['last_name'] . '",
      "proposer_email":"' . $data['emailuser'] . '",
      "proposer_mobile":"' . $data['number'] . '",
      "proposer_add1": "' . $data['address1'] . '",
      "proposer_add2": "' . $data['address2'] . '",
      "proposer_add3": "' . $data['present_city'] . '",
      "proposer_occupation": "' . $data['occupation'] . '",
      "proposer_pan": "' . $data['pan_number'] . '",
      "proposer_annual": "",
      "proposer_gstin": "' . $data['gstin'] . '",
      "proposer_dob": "' . $data['proposer_dob'] . '",
      "vehicle_puc_expiry": "' . $data['puc_expiry_date'] . '",
      "vehicle_puc": "' . $data['puc_number'] . '",
      "vehicle_puc_declaration": "' . strval($data['puc_number'] and $data['puc_expiry_date'] ? (string)'true' : (string)"false") . '",
      "pre_insurer_name": "' . $data['previousInsurerCode'] . '",
      "pre_insurer_no": "ABCDEF12345",
      "pre_insurer_address": "",
      "financier_type": "' . $data['finance_type'] . '",
      "financier_name": "' . $data['financier_name'] . '",
      "financier_address": "' . $data['financier_city'] . '",
      "nominee_name": "' . $data['nominee_name'] . '",
      "nominee_relation": "' . $data['nominee_relation'] . '",
      "nominee_age": ' . $data['nominee_age'] . ',
      "appointee_name": "",
      "appointee_relation": "",
      "proposal_id": "' . $data['proposal_id'] . '",
      "product_id": "M300000000001",
      "declaration": "Yes",
      "vehicle_chassis": "' . $data['chassis_number'] . '",
      "vehicle_engine": "' . $data['engine_number'] . '",
      "proposer_fullname": "' . $data['fullname'] . '",
      "proposer_pincode": "' . $data['present_pincode'] . '",
      "quote_no": "' . $data['quote_number'] . '",
      "carriedOutBy": "No",
      "__finalize": "1"
      }';
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://uatapigw.tataaig.com/motor/v1/proposal',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $json,
      CURLOPT_HTTPHEADER => array(
        'Authorization: ' . $this->auth(),
        'x-api-key: 5QerRezeZs3PrVdLQu79c1v9Nsh5S7BOan26zc7P',
        'Content-Type: application/json'
      ),
    ));


    $response = curl_exec($curl);
    // echo "\n$json\n$response\n";
    curl_close($curl);

    if (!empty($response)) {
      $this->session->set_userdata(array('pbody' => $json, 'presponse' => $response));
      return json_decode($response, true);
    }
  }
  function pay($data)
  {
    $data['name'] = ($data['car_customer_type'] == 'Individual') ? $data['fullname'] :  $data['company_name'];
    // print_r($data);
    $curl = curl_init();
    $body = '
    {
      "payment_mode": "onlinePayment",
      "online_payment_mode": "UPI",
      "payer_type": "Customer",
      "payer_id": "",
      "payer_pan_no": "",
      "payer_name": "' . $data['name'] . '",
      "payer_relationship": "",
      "email": "' . $data['emailuser'] . '",
      "office_location_code": 90101,
      "deposit_in": "Bank",
      "pan_no": "' . $data['pan_number'] . '",
      "mobile_no": "' . $data['number'] . '",
      "payment_id": [
        "' . $data['payment_id'] . '"
      ],
      "returnurl":"' . base_url('tata-car-response') . '"
    }';
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://uatapigw.tataaig.com/payment/online?product=motor',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $body,
      CURLOPT_HTTPHEADER => array(
        'Authorization: ' . $this->auth(),
        'x-api-key: 5QerRezeZs3PrVdLQu79c1v9Nsh5S7BOan26zc7P',
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $body;
    return ($response);
  }
  function verify_payment($data)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://uatapigw.tataaig.com/payment/verify?product=motor',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
            "payment_id" : "' . $data['payment_id'] . '"
        }',
      CURLOPT_HTTPHEADER => array(
        'x-api-key: 5QerRezeZs3PrVdLQu79c1v9Nsh5S7BOan26zc7P',
        'Authorization: ' . $this->auth(),
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
  }

  function pdfLink($policy)
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://uatapigw.tataaig.com/motor/v1/policy-download/' . $policy,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: ' . $this->auth(),
        'x-api-key: 5QerRezeZs3PrVdLQu79c1v9Nsh5S7BOan26zc7P'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response)->byteStream;
  }
  function getAddons()
  {
    $this->db->select('*');
    $this->db->from('tata_addons_fw');
    $res = $this->db->get();
    return $res->result();
  }
  function getRTO()
  {
    $this->db->select('*');
    $this->db->from('tata_rto_master_4W');
    $this->db->order_by('rto_code', 'ASC');
    $res = $this->db->get();
    return $res->result();
  }
  function rto($code)
  {
    $this->db->select('*');
    $this->db->from('tata_rto_master_4W');
    $this->db->like('rto_code', $code);
    $result = $this->db->get();
    return $result->row();
  }

  function getAllBanks()
  {
    $this->db->select('*');
    $this->db->from('tata_finance');
    $query = $this->db->get()->result();
    return ($query);
  }
  function getBankDetails($bank)
  {
    $this->db->select('name');
    $this->db->from('tata_finance');
    $this->db->where('code', $bank);
    $query = $this->db->get();
    return ($query)->row()->name;
  }
}
