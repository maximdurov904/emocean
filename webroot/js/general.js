jQuery(document).ready(function($) {

    // CHOOSE DELIVERY METHOD
    $('#activate_flat_rate').change(function()
    {

      var check = $(this).val();

      if (check == 1) { 
        $('#flat-rate-line').show();
      } else {
        $('#flat-rate-line').hide();
      }

    });

    // ORDER GREATER THAN
    $('#activate_order_greater').change(function()
    {

      var check = $(this).val();

      if (check == 1) { 
        $('#order-greater-line').show();
      } else {
        $('#order-greater-line').hide();
      }

    });

    // ORDER GREATER THAN
    $('#activate_order_greater_weight').change(function()
    {

      var check = $(this).val();

      if (check == 1) { 
        $('#order-greater-weight-line').show();
      } else {
        $('#order-greater-weight-line').hide();
      }

    });

    // Next (Payment Method)
    $("#next_link_payment").click(function() {

      var check = $('#pay_method').val();

      if (check == 0) {
        alert('Please choose a payment method!');
        return false;
      } else {
        // Redirect to, we will parse the payment method name
        return true;
      }

    });
    $("#billing_state").change(function () {
        $("#delivery_state").val($("#billing_state").val());
    })
    // Copy Billing Address to Shipping Address
    $("#btn_copy").click(function () {
        $("#delivery-address").val($("#billing-address").val());
        $("#delivery-suburb").val($("#billing-suburb").val());
        $("#delivery-post-code").val($("#billing-post-code").val());
    })
 var loc = window.location.pathname.match(/^\/?(\w+)\b/);
    // document.documentElement is the html element, this adds the class
    if(loc) document.documentElement.className += " " + loc[1].toLowerCase();

  });