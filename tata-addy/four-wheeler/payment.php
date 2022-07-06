<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.15/tailwind.min.css" integrity="sha512-braXHF1tCeb8MzPktmUHhrjZBSZknHvjmkUdkAbeqtIrWwCchhcpUeAf2Sq3yIq1Q1x5PlroafjceOUbIE3Q5g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="container flex flex-col justify-center items-center inline-block w-1/2 mt-5">
    <h2 class="text-2xl"><?php echo $title ?></h2>
    <label for="name" class="mt-2 text-xl text-black ">Name: <input type="text" class="ml-3 text-gray-800" readonly id="name" value="<?php echo ($car_customer_type == 'Individual') ? $fullname : $company_name; ?>"></label>
    <label for="phone" class="mt-2 text-xl text-black ">Phone: <input type="text" class="ml-3 text-gray-800" readonly id="phone" value="<?php echo $number; ?>"></label>
    <label for="prem" class="mt-2 text-xl text-black ">Email:<input type="text" class="ml-3 text-gray-800" readonly id="email" value="<?php echo $email; ?>"></label>
    <label for="prem" class="mt-2 text-xl text-black ">Quote:<input type="text" class="ml-3 text-gray-800" readonly id="quote" value="<?php echo $quote; ?>"></label>

    <button type="submit" id="paySubmit" class="bg-yellow-400 text-gray-700 px-3 py-2 text-lg rounded mt-2">Pay Now!!</button>
    <!-- <button id="pay" class="bg-yellow-400 text-gray-700 px-3 py-2 text-lg rounded mt-2">Pay Now!!</button> -->
</div>
<form action="" method="post" id="pay-form">
    <input type="hidden" name="pgiRequest" value="">
</form>
<div id="box"></div>
<!-- <input type="text" name="message" id="message" value="progress" style="display: none;"> -->
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script>
    console.log(<?= $this->session->userdata('fullquoteBody') ?>);
    $('#paySubmit').click(function(e) {

        $.ajax({
            url: '<?= base_url('tata/fw_controller/tata4w_payment/' . $uid) ?>',
            method: 'POST',
            error: function(err) {
                console.log(err);
            },
            success: function(res) {
                data = JSON.parse(res);
                url = (JSON.parse(data.data));
                $('#pay-form').attr('action', url.url);
                $('[name="pgiRequest"]').val(url.pgiRequest);
                $('#pay-form').submit();
                console.log(url);
                // window.location.href = data.data.url;
            }
        });
    });
</script>