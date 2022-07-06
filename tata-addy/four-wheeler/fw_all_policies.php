<link href="https://bimabuy.in/uat/assets/front//css/four_wheeler.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<style>
  .side-title {
    margin-top: 4%;
  }

  .w-80\% {
    width: 80%;
  }

  .disabled {
    /* pointer-events: none; */
    opacity: 0.7;
  }

  .disabled input,
  .disabled label {
    pointer-events: none;

  }

  /*   
  .disabled::before{

  } */
</style>

<?php
if ($_SESSION['error-cng']) : ?>
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <span><?= $_SESSION['error-cng'] ?></span>
  </div>

  <script>
    $(".alert").alert();
  </script>
  <?php unset($_SESSION['error-cng']); ?>
<?php endif; ?>
<div class="all_policy_detail">
  <section class="medical_details birthday_details">
    <div class="section-padding lw-tab-section p-relative">
      <form class="form-inline policis-form" method="POST" action="<?php echo base_url(); ?>tata/fw_controller/fw_cover_recalculate/<?= $uid ?>">
        <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
        <div class="container">
          <div class="row">
            <div class="col-md-3">
              <div class="sidebar-left">
                <p class="side-title">IDv:</p>
                <div class="form-group">
                  <input type="number" class="form-control" name="fw_idv" <?= ($car_product_code == 'LIABILITY') ? 'disabled' : '' ?> value="<?php echo $fw_idv ?? 0 ?>" min="<?= ($car_product_code == 'LIABILITY') ? 0 :  $min_idv ?>" max="<?= ($car_product_code == 'LIABILITY') ? 0 :  $max_idv ?>" id="fw_idv" placeholder="Idv">
                  <label for="fw_idv">Min: <?= ($car_product_code == 'LIABILITY') ? 0 :  $min_idv ?> To Max:<?= ($car_product_code == 'LIABILITY') ? 0 :  $max_idv  ?></label>
                </div>
                <p class="side-title">CNG Kit:</p>
                <?php if ($car_product_code == 'PACKAGE') { ?>
                  <div class="form-group <?= ($prev_cng_yes_or_no or $caseType == 'new_vehicle') ?  null : 'disabled' ?>">
                    <input type="number" class="form-control" name="cng_kit" min="<?php echo '0'; ?>" value="<?php echo $premium_for_cng_by_user; ?>" max="<?= ($car_product_code == 'PACKAGE') ? 50000 : ((float)$fw_idv / 2) ?>" id="cng_kit" placeholder="CNG Kit">
                    <label for="cng_kit">Min: <?php echo '0'; ?> To Max: <?= ($car_product_code == 'PACKAGE') ? 50000 : ((float)$fw_idv / 2) ?></label>
                  </div>
                <?php } else { ?>
                  <div class="form-group <? //($prev_cng_yes_or_no) ?  null : 'disabled' ?>">
                    <input type="radio" name="cng_tp" id="cng_tp_yes" value="Y" <?php if ($cng_tp && $cng_tp == "Y") {
                                                                                  echo 'checked';
                                                                                } ?>><label for="cng_tp_yes" style=" padding-left: 25px; font-size: small;">Yes</label>
                    <input type="radio" name="cng_tp" id="cng_tp_no" value="N" <?php if (empty($cng_tp) or ($cng_tp && $cng_tp == "N")) {
                                                                                  echo 'checked';
                                                                                } ?>><label for="cng_tp_no" style=" padding-left: 25px; font-size: small;">No</label>
                  </div>
                <?php } ?>
                <?php if ($caseType == 'roll_over') : ?>
                  <input type="hidden" name="prev_cng_yes_or_no" value="<?= ($prev_cng_yes_or_no) ?>">
                <?php endif; ?>
                <p class="side-title">Legal liability to paid Driver:</p>
                <div class="form-group">
                  <input type="radio" name="ll_paid" id="ll_yes" value="Y" <?php if ($ll_paid && $ll_paid == "Y") {
                                                                              echo 'checked';
                                                                            } ?>><label for="ll_yes" style=" padding-left: 25px; font-size: small;">Yes</label>
                  <input type="radio" name="ll_paid" id="ll_no" value="N" <?php if (empty($ll_paid) or ($ll_paid && $ll_paid == "N")) {
                                                                            echo 'checked';
                                                                          } ?>><label for="ll_no" style=" padding-left: 25px; font-size: small;">No</label>
                </div>
                <?php if ($car_customer_type !== 'Organization') : ?>
                  <p class="side-title">PA cover Owner Driver:</p>
                  <div class="form-group">
                    <input type="radio" name="owner_driver" id="owner_yes" value="Y" onchange="$('#owner_driver_info').hide()" <?= ($owner_driver && $owner_driver == "Y") ? 'checked' : null?>>
                    <label for="owner_yes" style=" padding-left: 25px; font-size: small;">Yes</label>
                    <input type="radio" name="owner_driver" id="owner_no" value="N" onchange="$('#owner_driver_info').show()" <?php if (empty($owner_driver) or ($owner_driver && $owner_driver == "N")) {
                                                                                      echo 'checked';
                                                                                    } ?>><label for="owner_no" style=" padding-left: 25px; font-size: small;">No</label>
                  </div>
                <?php endif; ?>
                <small id="owner_driver_info" style="<?= ($owner_driver == 'Y') ? 'display: none' : 'display:block';?>"><i class="fa fa-info-circle mr-2"></i>By selecting no, you confirm that either you don't have a valid driving license or you have pa owner driver > 15 Lakhs</small>
                <p class="side-title">PA cover Paid Driver:</p>
                <div class="form-group">
                  <input type="radio" name="paid_driver" id="paid_yes" value="Y" <?php if ($paid_driver && $paid_driver == "Y") {
                                                                                    echo 'checked';
                                                                                  } ?>><label for="paid_yes" style=" padding-left: 25px; font-size: small;">Yes</label>
                  <input type="radio" name="paid_driver" id="paid_no" value="N" <?php if (empty($paid_driver) or ($paid_driver && $paid_driver == "N")) {
                                                                                  echo 'checked';
                                                                                } ?>><label for="paid_no" style=" padding-left: 25px; font-size: small;">No</label>
                </div>
                <p class="side-title">Un-named Passenger:</p>
                <div class="form-group">
                  <input type="radio" name="unnamed" id="unnamed_0" value="0" <?php if ($unnamed && $unnamed == "0") {
                                                                                echo 'checked';
                                                                              } ?>><label for="unnamed_0" style=" padding-left: 25px; font-size: small;">0</label><br>
                  <input type="radio" name="unnamed" id="unnamed_1L" value="100000" <?php if ($unnamed && $unnamed == "100000") {
                                                                                      echo 'checked';
                                                                                    } ?>><label for="unnamed_1L" style=" padding-left: 25px; font-size: small;">100000</label><br>
                  <input type="radio" name="unnamed" id="unnamed_2L" value="200000" <?php if ($unnamed && $unnamed == "200000") {
                                                                                      echo 'checked';
                                                                                    } ?>><label for="unnamed_2L" style=" padding-left: 25px; font-size: small;">200000</label>
                </div>
                <!--   <p class="side-title">Non-Electrical Accessories:</p>
                                    <div class="form-group">
                                    <input type="number" class="form-control" name="fw_nonelectric_amount" min="<?php //echo '0'; 
                                                                                                                ?>" max="<?php  //echo $electric_nonelectric; 
                                                                                                                          ?>" value="<?php //echo $car_non_electrical_insuredAmount; 
                                                                                                                                      ?>" id="fw_nonelectric_amount" placeholder="Non-Electrical Accessories">
                                    <label for="fw_nonelectric_amount">Min: <?php //echo '0'; 
                                                                            ?> To Max:<? // echo $electric_nonelectric; 
                                                                                      ?></label>
                                    </div> -->


                <button type="submit" class="btn calculate-btn">Re-Calculate</button>
              </div>
            </div>

            <div class="col-md-8 popup_all_all_policy">
              <div class="row padding_top_bottom">

                <div class="col-md-6">
                  <button type="button" <?php if ($car_product_code == 'LIABILITY' or $caseType == 'new_vehicle') echo 'disabled'; ?> class="btn btn-warning same_btn" data-toggle="modal" data-target="#exampleModalsncb">NCB is set to

                    <?php echo $car_previousNoClaimBonus; ?>%
                    <i class="fa fa-caret-down icon-drop" aria-hidden="true"></i>
                  </button>
                </div>
                <div class="col-md-6">
                  <button type="button" <?php if ($car_product_code == 'LIABILITY') echo 'disabled'; ?> class="btn btn-warning same_btn" data-toggle="modal" data-target="#exampleModalsaddons">Select Addons & Accessories <i class="fa fa-caret-down icon-drop" aria-hidden="true"></i>
                  </button>
                </div>
                <div class="col-md-4">
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <button type="button" class="btn btn-warning same_btn" data-toggle="modal" data-target="#exampleModalsinsurers">Insurers <i class="fa fa-caret-down icon-drop" aria-hidden="true"></i>
                  </button>
                </div>
                <div class="col-md-4">
                  <button type="button" class="btn btn-warning same_btn" data-toggle="modal" data-target="#exampleModalsplan">Plan Type: All Plans <i class="fa fa-caret-down icon-drop" aria-hidden="true"></i>
                  </button>
                </div>
              </div>

              <div class="row">
                <div class="col-12 policy_box_detail">
                  <div class="lw-mega-tab">

                    <div class="tab-content lw-tab-content-wrapper">
                      <div class="tab-pane container active" id="LOANLY-1">
                        <div class="table-responsive">
                          <?php $this->load->view("alert_messages"); ?>
                          <table class="lw-tab-table">
                            <tbody>
                              <tr class="lw-table-row-1">
                                <th>Company</th>
                                <th>IDV</th>
                                <th>Net Premium</th>
                                <th>Rating</th>
                                <th>Action</th>
                              </tr>

                              <tr id="companyrow">

                                <td class="lw-table-data-2">
                                  <img src="https://www.tataaig.com/logo-min.png" alt="img" class="w-80%">
                                </td>
                                <td class="lw-table-data-3">
                                  <ul>
                                    <li> <strong>INR <?php echo $fw_idv; ?></strong>
                                    </li>
                                    <li> <span>

                                      </span>
                                    </li>
                                  </ul>
                                </td>
                                <td class="lw-table-data-3">
                                  <ul>
                                    <li> <strong><?php echo "INR" . $netpremium; ?></strong>
                                    <li> <strong><?php echo "INR" . $duepremium; ?> (Including 18% GST)<div class="price-cut-line"></div>
                                        <button type="button" class="more-info" data-toggle="modal" data-target="#exampleModalmoretwo">
                                          More Info
                                        </button>
                                      </strong>
                                    </li>

                                  </ul>
                                </td>
                                <td class="lw-table-data-3 company-rating"> <span class="rating-number">5/5</span>
                                  <div class="ratings"> <span class="text-custom-yellow"><i class="fas fa-star"></i></span>
                                    <span class="text-custom-yellow"><i class="fas fa-star"></i></span>
                                    <span class="text-custom-yellow"><i class="fas fa-star"></i></span>
                                    <span class="text-custom-yellow"><i class="fas fa-star"></i></span>
                                    <span class="text-custom-yellow"><i class="fas fa-star"></i></span>
                                  </div>
                                </td>
                                <form method="post" action="<?php echo base_url; ?>">
                                  <input type="hidden" name="vehicle_id" value="<?php echo $vehicle_id; ?>">
                                  <td class="lw-table-data-3 choose-btn"> <a href="<?= base_url('tata-four-wheeler-all-details/' . $uid) ?>" class="btn-first btn-submit-fill">Buy Now</a>
                                    <a href="#" class="Loan-content">T&amp;C Apply</a>
                                  </td>
                                </form>
                              </tr>
                            </tbody>
                          </table>
                          <?= $bundle_str ? '<small><i class="fa fa-info-circle mr-2"></i> ' . $bundle_str  . '</small>': null?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>

  </section>
</div>

<!-- modal NCB Value -->
<form id="four_mak" method="POST" action="<?php echo base_url(); ?>tata/fw_controller/car_ncb_choose">
  <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
  <div class="modal fade ncbmodal" id="exampleModalsncb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center">Confirm NCB Value</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-caret-up icon-drop" aria-hidden="true"></i></span>
          </button>
        </div>
        <div class="modal-body">
          <p class="text-center">Did you make a claim in your existing policy?</p>
          <!--       <button type="button" class="btn btn-outline-primary ncbbutton">Yes</button>
      <button type="button" onclick="myFunction()" class="btn btn-outline-info ncbbutton" >No</button>
       -->
          <div class="text-center form-row margin_top_bottom">
            <div class="col-md-12 row">
              <div class="form-check four_wheeler box-icon col-6">
                <label class="poli form-check-label icon-lab ncbbutton <?php if ($car_isClaimInLastYear == 1) {
                                                                          echo "icon-lab-hover";
                                                                        } else {
                                                                          "weyr";
                                                                        } ?>" id="box-icon7" for="exampleRadios5">
                  <input class="form-check-input" name="isClaimInLastYear" type="radio" id="exampleRadios5" value="1">
                  <span> Yes</span>
                </label>
              </div>
              <div class="form-check four_wheeler box-icon col-6">
                <label class="poli form-check-label icon-lab red ncbbutton <?php if ($car_isClaimInLastYear == 0) {
                                                                              echo "icon-lab-hover";
                                                                            } else {
                                                                              "kjwher";
                                                                            } ?>" id="box-icon8" for="exampleRadios6">
                  <input class="form-check-input" name="isClaimInLastYear" type="radio" id="exampleRadios6" value="0">
                  <span>No</span>
                </label>
              </div>
            </div>
          </div>



          <div id="hidediv">
            <p class="text-center">Select your existingNo Claim Bonus (NCB)</p>
            <div class="form-group row">
              <div class="col-md-4">
                <div class="form-check form-check-inline" id="ncb_box">
                  <input class="form-check-input" type="radio" name="ncbvalue" id="inlineRadio1" value="0" <?php if ($car_previousNoClaimBonus && $car_previousNoClaimBonus == "0") {
                                                                                                              echo "checked";
                                                                                                            } else {
                                                                                                              "";
                                                                                                            } ?>>
                  <label class="form-check-label" for="inlineRadio1">0</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check form-check-inline ">
                  <input class="form-check-input" type="radio" name="ncbvalue" id="inlineRadio2" value="20" <?php if ($car_previousNoClaimBonus && $car_previousNoClaimBonus == "20") {
                                                                                                              echo "checked";
                                                                                                            } else {
                                                                                                              "";
                                                                                                            } ?>>
                  <label class="form-check-label" for="inlineRadio2">20</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check form-check-inline ">
                  <input class="form-check-input" type="radio" name="ncbvalue" id="inlineRadio9" value="25" <?php if ($car_previousNoClaimBonus && $car_previousNoClaimBonus == "25") {
                                                                                                              echo "checked";
                                                                                                            } else {
                                                                                                              "";
                                                                                                            } ?>>
                  <label class="form-check-label" for="inlineRadio9">25</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="ncbvalue" id="inlineRadio3" value="35" <?php if ($car_previousNoClaimBonus && $car_previousNoClaimBonus == "35") {
                                                                                                              echo "checked";
                                                                                                            } else {
                                                                                                              "";
                                                                                                            } ?>>
                  <label class="form-check-label" for="inlineRadio3">35</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="ncbvalue" id="inlineRadio4" value="45" <?php if ($car_previousNoClaimBonus && $car_previousNoClaimBonus == "45") {
                                                                                                              echo "checked";
                                                                                                            } else {
                                                                                                              "";
                                                                                                            } ?>>
                  <label class="form-check-label" for="inlineRadio4">45</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check form-check-inline ">
                  <input class="form-check-input" type="radio" name="ncbvalue" id="inlineRadio5" value="50" <?php if ($car_previousNoClaimBonus && $car_previousNoClaimBonus == "50") {
                                                                                                              echo "checked";
                                                                                                            } else {
                                                                                                              "";
                                                                                                            } ?>>
                  <label class="form-check-label" for="inlineRadio5">50</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check form-check-inline ">
                  <input class="form-check-input" type="radio" name="ncbvalue" id="inlineRadio6" value="55" <?php if ($car_previousNoClaimBonus && $car_previousNoClaimBonus == "55") {
                                                                                                              echo "checked";
                                                                                                            } else {
                                                                                                              "";
                                                                                                            } ?>>
                  <label class="form-check-label" for="inlineRadio6">55</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check form-check-inline ">
                  <input class="form-check-input" type="radio" name="ncbvalue" id="inlineRadio7" value="65" <?php if ($car_previousNoClaimBonus && $car_previousNoClaimBonus == "65") {
                                                                                                              echo "checked";
                                                                                                            } else {
                                                                                                              "";
                                                                                                            } ?>>
                  <label class="form-check-label" for="inlineRadio7">65</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- end NCB value modal -->
<!-- insurers modal -->
<form>
  <div class="modal fade insurers" id="exampleModalsinsurers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center">Insurers</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-caret-up icon-drop" aria-hidden="true"></i></span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" checked>
            <label class="form-check-label" for="exampleCheck1">TATA AIG Assurance</label>
          </div>
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Plan modal -->
<form method="POST" action="<?php echo base_url(); ?>tata/fw_controller/car_product_type_choose/<?= $uid ?>">
  <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />

  <div class="modal fade allplans" id="exampleModalsplan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center">Plans Type</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-caret-up icon-drop" aria-hidden="true"></i></span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-check">
            <input class="form-check-input" type="radio" name="car_product_code" id="exampleRadiosPACKAGE" <?php if ($car_product_code && ($car_product_code == "PACKAGE")) {
                                                                                                              echo "checked";
                                                                                                            } ?> value="PACKAGE">
            <label class="form-check-label" for="exampleRadiosPACKAGE">
              Comprehensive Policy
            </label>
          </div>
          <div class="form-check <?= ($caseType == 'new_vehicle') ? 'd-none' : '' ?>">
            <input class="form-check-input" type="radio" name="car_product_code" id="exampleRadiosLIABILITY" <?php if ($car_product_code && ($car_product_code == 'LIABILITY')) {
                                                                                                                echo "checked";
                                                                                                              } ?> value="LIABILITY">
            <label class="form-check-label" for="exampleRadiosLIABILITY">
              TP only Policy
            </label>
          </div>
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
</form>


<!-- modal idv -->
<form>
  <div class="modal fade insured-value" id="exampleModalsinsurersvalue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center">Insured Value (IDV)</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-caret-up icon-drop" aria-hidden="true"></i></span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label for="numberboxidv">Rs. To Rs. </label>
            <input type="number" class="form-control" name="fw_idv" min="" max=" " id="numberboxidv" placeholder="">
          </div>
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- end idv modal -->
<!-- modal Addons -->
<form method="post" action="<?= base_url('tata/fw_controller/fw_addons_choose/' . $uid) ?>">
  <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
  <div class="modal fade addons" id="exampleModalsaddons" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center">Select Addons & Accessories</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-caret-up icon-drop" aria-hidden="true"></i></span>
          </button>
        </div>
        <div class="modal-body">
        <div class=" bg-dark text-white my-2 p-2"><small><i class="fa fa-info-circle mr-2"></i>TATA AIG provides Addons in Bundle i.e. If you select any addon from one bundle automatically other addons from same bundle will be added</small></div>
          <p class="heading">Addons</p>
          <?php foreach ($allAddons as $addons) {

            if ($addons->id == 9 and $previousNoClaimBonus == 0 or $addons->id == 9 and  $isClaimInLastYear == 1) continue;
            if ($isClaimInLastYear == 0) {

              if (strtotime(date('Y-m-d', strtotime($addons->applicable_ncb))) > strtotime($car_register_date)) {
                continue;
              }
            } else {
              if (strtotime(date('Y-m-d', strtotime($addons->applicable_non_ncb))) > strtotime($car_register_date) and !empty($addons->applicable_non_ncb)) continue;
            }
          ?>
            <div class="form-check">

              <input type="checkbox" class="form-check-input" id="exampleCheck-<?= print_r($addons->name) ?>" name="addons[]" <?php echo eval("echo (\$addon{$addons->id} == 'Yes' or (\$addons->bundle == \$bundle_code and !empty(\$bundle_code)) or (\$addon{$addons->id}_checked == 'Yes') or (\$addons->id == 7 and (\$bundle_str))) ? 'checked' : '';"); ?> value="<?= $addons->id; ?>">
              <label class="form-check-label" for="exampleCheck-<?= print_r($addons->name) ?>"><?php print_r($addons->name); ?></label>
              <?=($addons->id == "1" and $caseType == 'roll_over') ? '<br><small><i class="fa fa-info-circle mr-2"></i>By selecting above addon, you accept that you have Depreciation addon in previous policy</small>': null?>
            </div>
          <?php } ?>

        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- end idv modal -->


<!--Second More Info Modal -->
<div class="modal fade" id="exampleModalmoretwo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title color_black" id="exampleModalLabel3">Premium Breakup Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body moreinfopopup">
        <div class="row first">
          <div class="col col-md-6 row bottomborder_padding">
            <div class="col-md-4">
              <div class="left_box">
                <h6>Plan Name :</h6>
              </div>
              <div class="left_box">
                <h6>IDV :</h6>
              </div>
            </div>
            <div class="col-md-8">
              <div class="right_box plan_name">
                <h6>TATA AIG Company</h6>
              </div>
              <div class="right_box idv">
                <h6>INR <?php echo $fw_idv ?></h6>
              </div>
            </div>
          </div>
          <div class="col col-md-6 row bottomborder_padding">
            <div class="col-md-4">
              <div class="left_box">
                <h6>Car Model :</h6>
              </div>
              <div class="left_box">
                <h6>CRN :</h6>
              </div>
            </div>
            <div class="col-md-8">
              <div class="right_box bike_model">
                <h6><?php if ($make) {
                      echo $make;
                    } ?> <?php if ($model) {
                            echo $model;
                          } ?> <?php if ($variant) {
                                  echo $variant;
                                } ?></h6>
              </div>
              <div class="right_box rto">
                <h6><?php echo $crnvalue; ?></h6>
              </div>
            </div>
          </div>
        </div>
        <div class="row second">
          <div class="col col-md-6 row">
            <div class="col-md-8">
              <div class="left_box">
                <h6><strong>Own damage Premium (A)</strong></h6>
              </div>
              <!--          	<div class="left_box">
         	 <h6><strong>Basic OD</strong></h6>
         	</div> -->
              <!--          	<div class="left_box">
         	 <h6><strong>Own damage Discount</strong></h6>
         	</div> -->
              <div class="left_box <?= ($caseType == 'new_vehicle') ? 'd-none' : '' ?>">
                <h6><strong>Current Year NCB</strong></h6>
              </div>
            </div>
            <div class="col-md-4">
              <div class="right_box damage_premium">
                <h6><strong>INR <?php echo $own_damage; ?> </strong></h6>
              </div>
              <!--          	<div class="right_box damage_discount">
         	 <h6>₹</h6>
         	</div> -->
              <!--          	<div class="right_box basic_od">
         	 <h6>₹</h6>
         	</div> -->

              <div class="right_box no_claim_bonus <?= ($caseType == 'new_vehicle') ? 'd-none' : '' ?>">
                <h6><strong>INR <?php echo round($ncbdiscount); ?></strong></h6>
              </div>

              <!--          	<div class="right_box no_claim_bonus">
         	 <h6><strong><?php echo "₹0"; ?></strong></h6>
         	</div> -->

            </div>
          </div>
          <div class="col col-md-6 row">
            <div class="col-md-8">
              <div class="left_box">
                <h6>Basic 3rd Party Premium :</h6>
              </div>
              <div class="left_box">
                <h6>CPA :</h6>
              </div>
              <?php if ($ll_paid_premium) : ?>
                <div class="left_box">
                  <h6>Legal Liabilty to Paid driver :</h6>
                </div>
              <?php endif; ?>
              <?php if ($cng_premium_tp) : ?>
                <div class="left_box">
                  <h6>CNG Premium (TP):</h6>
                </div>
              <?php endif; ?>
              <?php if ($cng_premium_od) : ?>
                <div class="left_box">
                  <h6>CNG Premium (OD):</h6>
                </div>
              <?php endif; ?>
              <?php if ($paid_driver_premium) : ?>
                <div class="left_box">
                  <h6>PA cover(Paid Driver):</h6>
                </div>
              <?php endif; ?>
              <?php if ($unnamed_premium) : ?>
                <div class="left_box">
                  <h6>Unnamed Passenger:</h6>
                </div>
              <?php endif; ?>
            </div>
            <div class="col-md-4">
              <div class="right_box basic_thirt_party">
                <h6><strong>INR <?php echo $third_party_premium; ?></strong></h6>
              </div>
              <div class="right_box cpa">
                <h6><strong>INR <?php echo $pa_owner_driver; ?></strong></h6>
              </div>
              <?php if ($ll_paid_premium) : ?>
                <div class="right_box cpa">
                  <h6><strong>INR <?php echo $ll_paid_premium; ?></strong></h6>
                </div>
              <?php endif; ?>
              <?php if ($cng_premium_tp) : ?>
                <div class="right_box cpa">
                  <h6><strong>INR <?php echo $cng_premium_tp; ?></strong></h6>
                </div>
              <?php endif; ?>
              <?php if ($cng_premium_od) : ?>
                <div class="right_box cpa">
                  <h6><strong>INR <?php echo $cng_premium_od; ?></strong></h6>
                </div>
              <?php endif; ?>
              <?php if ($paid_driver_premium) : ?>
                <div class="right_box cpa">
                  <h6><strong>INR <?php echo $paid_driver_premium; ?></strong></h6>
                </div>
              <?php endif; ?>
              <?php if ($unnamed_premium) : ?>
                <div class="right_box cpa">
                  <h6><strong>INR <?php echo $unnamed_premium; ?></strong></h6>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="row third">
          <div class="col col-md-6 row">
            <div class="col-md-8">
              <div class="left_box">
                <h6><strong>Total Addon</strong></h6>
              </div>
              <div class="addon_div">
                <?php foreach ($addons_with_premium as $key => $value) : ?>
                  <div style="display: flex; width: 140%;">

                    <div class="left_box">
                      <h6><?= ucwords($key) ?></h6>
                    </div>

                    <div class="right_box " style="width: 40%;">
                      <h6 class="ml-3"><b>INR <?= $value ?></b></h6>
                    </div>
                  </div>
                <?php endforeach;  ?>
              </div>
            </div>
            <div class="col-md-4">
              <?php if ($addons_premium != "0") { ?>
                <div class="right_box addon_premium">
                  <h6><strong>INR<?php echo $addons_premium ?? 0; ?></strong></h6>
                </div>
              <?php } else { ?>
                <div class="right_box addon_premium">
                  <h6><strong>INR <?php echo "0"; ?></strong></h6>
                </div>
              <?php } ?>

            </div>
          </div>
          <div class="col col-md-6 border_none">
            <img class="text-center modal_img_logo_popup" src="<?= base_url('assets/front/img/logo.png') ?>">
          </div>
          <div class="col col-md-6 row border_none">
            <div class="col-md-8">

              <div class="left_box">
                <h6><strong>Net Premium (IN INR) :</strong></h6>
              </div>
              <div class="left_box">
                <h6><strong>With Service / GST tax :</strong></h6>
              </div>
            </div>
            <div class="col-md-4">

              <div class="right_box netpremium">
                <h6><strong>INR <?php echo $netpremium; ?></strong></h6>
              </div>
              <div class="right_box gst_tax">
                <h6><strong>INR <?php echo $duepremium; ?></strong></h6>
              </div>

            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>
<!-- end  -->


<div class="modal fade prev-cng-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="form-group">
          In your previous policy, did you have CNG coverage?
          <input type="radio" name="prev_cng_check" id="prev_cng_check_yes" value="Y" <?= ($prev_cng_check && $prev_cng_check == "Y") ? 'checked' : null ?>><label for="prev_cng_check_yes" style=" padding-left: 25px; font-size: small;">Yes</label>
          <input type="radio" name="prev_cng_check" id="prev_cng_check_no" value="N" <?= (empty($prev_cng_check) or ($prev_cng_check && $prev_cng_check == "N")) ? '' : null ?>><label for="prev_cng_check_no" style=" padding-left: 25px; font-size: small;">No</label>
        </div>
      </div>
    </div>
  </div>
</div>




<script>
  <?php if($caseType == 'roll_over'): ?>
  $(document).click(function(e) {
    if (e.target == document.querySelector('.disabled')) {
      $('.prev-cng-modal').modal('show');
    }
  });

  $('[name="prev_cng_check"]').change(function() {
    /**
     * * This function will help us use the CNG cover only if the user has the same in previous Policy 
     */
    if ($(this).is(':checked')) {
      console.log($('[name="prev_cng_check"]:checked').val());
      if ($('[name="prev_cng_check"]:checked').val() == 'Y') {
        if (document.querySelector('[name="cng_kit"]') != null) {
          $('[name="cng_kit"]').parents('.disabled').removeClass('disabled');
          $('[name="prev_cng_yes_or_no"]').val('Y');
        }
        if (document.querySelector('[name="cng_tp"]') != null) {
          $('[name="cng_tp"]').parents('.disabled').removeClass('disabled');
          $('[name="prev_cng_yes_or_no"]').val('Y');
        }
      } else {
        if (document.querySelector('[name="cng_kit"]') != null) {
          $('[name="cng_kit"]').parents('.disabled').addClass('disabled');
          $('[name="prev_cng_yes_or_no"]').val('N');
        }
        if (document.querySelector('[name="cng_tp"]') != null) {
          $('[name="cng_tp"]').parents('.disabled').addClass('disabled');
          $('[name="prev_cng_yes_or_no"]').val('N');
        }
      }
    } else console.log('not');
    $('.prev-cng-modal').modal('hide');
  });
  <?php endif;?>
</script>
<script src="<?php echo FRONT_CSSJS_PATH; ?>/js/TATA AIG_fw.js"></script>