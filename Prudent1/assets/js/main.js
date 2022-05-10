!(function($) {
  "use strict";
/////////////////////////////////// Range ///////////////////////////////////
const rangeInputs = document.querySelectorAll('input[type="range"]')
const numberInput = document.querySelector('input[type="number"]')
function handleInputChange(e) {
  let target = e.target
  if (e.target.type !== 'range') {
    target = document.getElementById('range')
    targetvalue  = document.getElementById('rangevalue')
  } 
  const min = target.min
  const max = target.max
  const val = target.value
  target.style.backgroundSize = (val - min) * 100 / (max - min) + '% 100%'
  $('#rangevalue').prop( 'style' , `left:${(val - min) * 100 / (max - min)>=50 ? (val - min) * 100 / (max - min) -23: (val - min) * 100 / (max - min) +5}%`);
}
rangeInputs.forEach(input => {
  input.addEventListener('input', handleInputChange)
})
var items = $('.bar_list');
var currentItem = items.filter('.active');

/////////////////////////////////// Login ///////////////////////////////////

$(document).ready(function () {
  $("#otp_login").hide();
  $("#send_otp").click(function () {
    $("#otp_login").show('slow');
    $("#login").hide('slow');
  })
})
/////////////////////////////////// Proposal ///////////////////////////////////

$(document).ready(function () {
  $("#nominee_detail").hide();
  $("#vehicle_detail").hide();
  $("#policy_detail").hide();
  $("#contact_detail").hide();
  $("#confirm_detail").hide();
  $("#expired_policy").hide();
  $("#go_to_home").hide();
  
  $("#next_nominee_detail").click(function () {
      $("#nominee_detail").show();
      $("#car_detail").hide('slow');
      spin('26.5%',true); 
  })
  $("#pre_car_detail").click(function () {
    $("#car_detail").show('slow');
    $("#nominee_detail").hide('slow');
    spin('10%',false);
  });
  $("#next_vehicle_detail").click(function () {
    $("#vehicle_detail").show('slow');
    $("#nominee_detail").hide('slow');
    spin('43.3%',true);
  });
  $("#pre_nominee_detail").click(function () {
    $("#nominee_detail").show('slow');
    $("#vehicle_detail").hide('slow');
    spin('26.5%',false);
  });
  $("#next_policy_detail").click(function () {
    $("#policy_detail").show('slow');
    $("#vehicle_detail").hide('slow');
    spin('60%',true);
  });
  $("#pre_vehicle_detail").click(function () {
    $("#vehicle_detail").show('slow');
    $("#policy_detail").hide('slow');
    spin('43.3%',false);
  });
  $("#next_contact_detail").click(function () {
    $("#contact_detail").show();
    $("#policy_detail").hide('slow');
    spin('76.8%',true);
  });
  $("#pre_policy_detail").click(function () {
    $("#policy_detail").show('slow');
    $("#contact_detail").hide('slow');
    spin('60%',false);
  });
  $("#next_confirm_detail").click(function () {
    $("#confirm_detail").show('slow');
    $("#contact_detail").hide('slow');
    spin('93.5%',true);
  });
  $("#pre_contact_detail").click(function () {
    $("#contact_detail").show('slow');
    $("#confirm_detail").hide('slow');
    spin('76.8%',false);
  });
  $("#expired").click(function () {
    $("#expired_policy").show();
    $("#existing_insurer").hide();
    $("#other_details").hide();
    $("#go_to_home").show();
  })
  $("#not_expired").click(function () {
    $("#expired_policy").hide();
    $("#existing_insurer").show();
    $("#other_details").show();
    $("#go_to_home").hide();
  })
  
/////////////////////////////////// Policies ///////////////////////////////////
  $(".accordion-button").click(function () {
      if ( $(this).parent().hasClass("active")) { 
        $(".accordion_item").removeClass('active');
        $(this).parent().removeClass('active');
      }else{
        $(".accordion_item").removeClass('active');
        $(this).parent().addClass('active');
      }
  });
})
/////////////////////////////////// Proposal ///////////////////////////////////
var spin = (width,flag) =>{
  $('.proposal_bar').animate( { "width" : `${width}` },{
    duration : 1000, 
    step: function() {
      $('#spin').addClass('spin');
      setTimeout(()=>{$('#spin').removeClass('spin');},1000)
  }     
}
);
setTimeout(()=>{ChangeActive(flag);},600)
}
var ChangeActive = (flag) =>{
  var nextItem =   flag? currentItem.next():currentItem.prev();
  currentItem.removeClass('active');
  if ( nextItem.length ) {
      currentItem = nextItem.addClass('active');
  } else {
      currentItem = items.first().addClass('active');
  }
}



$(function () {
  $('[data-toggle="tooltip"]').tooltip();
})
 

})(jQuery);