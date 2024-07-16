jQuery(document).ready(function($) {

    // Initialize datepicker
    $('#delivery_date').datepicker({
       dateFormat: 'yy-mm-dd' // Adjust date format as needed
    });

    $('#shipping_delivery_date').datepicker({
        dateFormat: 'yy-mm-dd' // Adjust date format as needed
     });

   // Function to validate input fields and show error messages
   function validateFields($fieldsWrapper, $errorContainer) {
       var isValid = true;
       
       $fieldsWrapper.find('.oak-required-field').each(function() {
           var $field = $(this);
           var $formRow = $field.closest('.form-row');
           var $errorMessage = $formRow.find('.error-message');

           if ($field.val().trim() === '') {
               isValid = false;
               var fieldName = $formRow.find('label').text();
               $formRow.addClass('woocommerce-invalid');
               $errorMessage.text(fieldName + ' is required.').show();
           } else {
               $errorMessage.hide();
               $formRow.removeClass('woocommerce-invalid');
           }
       });
       
       return isValid;
   }
   
   /*Get delivery info input*/
   $('#delivery-step-next-btn').on('click', function(e) {
       e.preventDefault();

       var delivery_button = $(this);
       var error_message = $('.oak-delivery-fields-wrapper').find('.woocommerce-notices-wrapper');

       // Reset all previous error messages
       $('.error-message').text('').hide();

       // AJAX call
       if (validateFields($('.oak-delivery-fields'))) {
           var delivery_type = $('#delivery_type:checked').val();
           var postcode = $('.postcode').val();
           var billing_house_no = $('#billing_house_no').val();
           var street_address = $('.street_address').val();
           var billing_address = $('.billing_address').val();
           var delivery_date = $('#delivery_date').val();
           var delivery_time = $('#delivery_time').val();

           $.ajax({
               type: 'POST',
               url: Oak_Food_Multi_Step_Checkout.ajax_url,
               data: {
                   action: 'handle_checkout_delivery_step',
                   delivery_type: delivery_type,
                   postcode: postcode,
                   billing_house_no: billing_house_no,
                   street_address: street_address,
                   billing_address: billing_address,
                   delivery_date: delivery_date,
                   delivery_time: delivery_time,
                   security: Oak_Food_Multi_Step_Checkout.nonce
               },
               beforeSend: function() {
                   delivery_button.prop('disabled', true);
               },
               success: function(response) {
                   // Check if request was successful
                   if (response.success) {
                       error_message.html(''); //Empty errors
                       $('.oak-delivery-fields-wrapper').hide();
                       $('.oak-facts-section-wrapper').show();
                       $('.delivery-step-btn, .fact-step-btn').toggleClass('active');
                       $('.delivery-step-btn').addClass('passed-step');
                       delivery_button.prop('disabled', false);
                   } else {
                       error_message.html('<div class="woocommerce-error">' + response.data.message + '</div>');
                       delivery_button.prop('disabled', false);
                   }
               },
               error: function(errorThrown) {
                   error_message.html('<div class="woocommerce-error">AJAX error. Please try again.</div>');
                   delivery_button.prop('disabled', false);
               }
           });
       }
   });

   /*Get fact info input*/
   $('#facts-step-next-btn').on('click', function(e) {
       e.preventDefault();

       var fact_button = $(this);
       var error_message = $('.oak-facts-section-wrapper').find('.woocommerce-notices-wrapper');

       // Reset all previous error messages
       $('.error-message').text('').hide();

       // AJAX call
       if (validateFields($('.oak-facts-default-billing-fields'))) {
           var fact_email = $('#fact_email').val();
           var first_name = $('#first_name').val();
           var last_name = $('#last_name').val();
           var phone = $('#phone').val();
           var fact_delivery_time = $('#fact_delivery_time').val();
           var custom_password = $('#custom_password').val();
           var different_billing_address = $('#different_billing_address:checked').val();
           
           if(different_billing_address && 'on' == different_billing_address){
                if (!validateFields($('.different-shipping-address'))) {
                    return;
                }
           }

           //different billing/shipping address
           var shipping_postcode = $('#shipping_postcode').val();
           var shipping_house_no = $('#shipping_house_no').val();
           var shipping_street_address = $('#shipping_street_address').val();
           var shipping_address_1 = $('#shipping_address_1').val();
           var shipping_first_name = $('#shipping_first_name').val();
           var shipping_last_name = $('#shipping_last_name').val();
           var shipping_phone = $('#shipping_phone').val();
           var shipping_delivery_date = $('#shipping_delivery_date').val();
           var shipping_delivery_time = $('#shipping_delivery_time').val();


           $.ajax({
               type: 'POST',
               url: Oak_Food_Multi_Step_Checkout.ajax_url,
               data: {
                   action: 'handle_checkout_fact_step',
                   fact_email: fact_email,
                   first_name: first_name,
                   last_name: last_name,
                   phone: phone,
                   fact_delivery_time: fact_delivery_time,
                   custom_password: custom_password,
                   different_billing_address: different_billing_address,
                   shipping_postcode: shipping_postcode,
                   shipping_house_no: shipping_house_no,
                   shipping_street_address: shipping_street_address,
                   shipping_address_1: shipping_address_1,
                   shipping_first_name: shipping_first_name,
                   shipping_last_name: shipping_last_name,
                   shipping_phone: shipping_phone,
                   shipping_delivery_date: shipping_delivery_date,
                   shipping_delivery_time: shipping_delivery_time,
                   security: Oak_Food_Multi_Step_Checkout.nonce
               },
               beforeSend: function() {
                   fact_button.prop('disabled', true);
               },
               success: function(response) {
                   // Check if request was successful
                   if (response.success && response.data.is_need_to_page_reload == true) {
                       location.reload();
                   }else if(response.success){
                       error_message.html(''); //Empty errors
                       $('.oak-facts-section-wrapper').hide();
                       $('.woocommerce-checkout').show();
                       $('.pm-step-btn, .fact-step-btn').toggleClass('active');
                       $('.fact-step-btn').addClass('passed-step');
                       fact_button.prop('disabled', false);
                   } else {
                       error_message.html('<div class="woocommerce-error">' + response.data.message + '</div>');
                       fact_button.prop('disabled', false);
                   }
               },
               error: function(errorThrown) {
                   // Handle error
                   error_message.html('<div class="woocommerce-error">AJAX error. Please try again.</div>');
                   fact_button.prop('disabled', false);
               }
           });
       }
   });

   // Function to remove error message when user starts typing in fields
   $('.oak-required-field').on('input change', function() {
       if ($(this).val().trim() !== '') {
           $(this).closest('.form-row').find('.error-message').hide();
           $(this).closest('.form-row').removeClass('woocommerce-invalid');
       } else {
           $(this).closest('.form-row').find('.error-message').show();
           $(this).closest('.form-row').addClass('woocommerce-invalid');
       }
   });

   // Toggle show hide checkout page login form
   $('.oak-checkout-login-form a.showlogin').on('click', function(e) {
       e.preventDefault();
       $('.oak-checkout-login-form .wc-checkout-login-form').toggle();
       $('.oak-facts-email-row').toggle();
       $('.showlogin .close-text, .showlogin .open-text').toggle();

   });

   //Select delivery time value[Start]
   $('#delivery_time').on('change', function(e){
       $('#fact_delivery_time').val($(e.target).val());
   });

   $('#fact_delivery_time').on('change', function(e){
       $('#delivery_time').val($(e.target).val());
   });
   //Select delivery time value[End]

   // Goto facts previous page
   $('#facts-step-prev-btn').on('click', function(e) {
       e.preventDefault();
       $('.oak-facts-section-wrapper').toggle();
       $('.oak-delivery-fields-wrapper ').toggle();
       $('.fact-step-btn, .delivery-step-btn').toggleClass('active');
       $('.delivery-step-btn').removeClass('passed-step');
   });

   //Goto payment method previous page
   $('#pm-step-prev-btn').on('click', function(e) {
       e.preventDefault();
       $('.oak-facts-section-wrapper').show();
       $('form.woocommerce-checkout').removeClass('oak-d-block');
       $('form.woocommerce-checkout').hide();
       $('.pm-step-btn, .fact-step-btn').toggleClass('active');
       $('.fact-step-btn').removeClass('passed-step');
   });

   // Handle checkout login form AJAX validation
   $('.wc-checkout-login-form form.login').on('submit', function(e) {
       e.preventDefault();

       var $form = $(this);
       var $message = $('.oak-facts-section-wrapper').find('.woocommerce-notices-wrapper');
       var data = {
           'action': 'custom_checkout_login',
           'nonce': Oak_Food_Multi_Step_Checkout.nonce,
           'username': $form.find('input[name="username"]').val(),
           'password': $form.find('input[name="password"]').val()
       };

       $.ajax({
           url: Oak_Food_Multi_Step_Checkout.ajax_url,
           type: 'POST',
           data: data,
           beforeSend: function() {
               $form.find('button[type="submit"]').prop('disabled', true);
           },
           success: function(response) {
               if (response.success) {
                   window.location.reload();
               } else {
                   $message.html('<div class="woocommerce-error">' + response.data.message + '</div>');
                   $form.find('button[type="submit"]').prop('disabled', false);
               }
           },
           error: function() {
               $message.html('<div class="woocommerce-error">AJAX error. Please try again.</div>');
               $form.find('button[type="submit"]').prop('disabled', false);
           }
       });
    });



    // Function to update the delivery address information
    function updateDeliveryAddress() {
        var postCode = $(".postcode").val();
        var houseNo = $(".house_no").val();
        var streetAddress = $(".street_address").val();
        var billingAddress = $(".billing_address").val();

        // Create an array to store non-empty values
        var addressParts = [];

        // Push non-empty values into the array
        if (houseNo.trim() !== '') {
            addressParts.push(houseNo);
        }
        if (streetAddress.trim() !== '') {
            addressParts.push(streetAddress);
        }
        if (billingAddress.trim() !== '') {
            addressParts.push(billingAddress);
        }
        if (postCode.trim() !== '') {
            addressParts.push(postCode);
        }

        // Update the delivery address information
        $(".delivery-address-inf").text(addressParts.join(", "));
    }

    // Function to update the additional delivery information
    function updateAdditionalDeliveryInfo() {
        var postCode = $(".postcode").val();
        var houseNo = $(".house_no").val();
        var streetAddress = $(".street_address").val();
        var billingAddress = $(".billing_address").val();
        var firstName = $(".first_name").val();
        var lastName = $(".last_name").val();
        var phone = $(".phone").val();

        // Create an array to store non-empty values
        var infoParts = [];

        // Push non-empty values into the array
        if (houseNo.trim() !== '') {
            infoParts.push(houseNo);
        }
        if (streetAddress.trim() !== '') {
            infoParts.push(streetAddress);
        }
        if (billingAddress.trim() !== '') {
            infoParts.push(billingAddress);
        }
        if (postCode.trim() !== '') {
            infoParts.push(postCode);
        }
        if (firstName.trim() !== '') {
            infoParts.push(firstName);
        }
        if (lastName.trim() !== '') {
            infoParts.push(lastName);
        }
        if (phone.trim() !== '') {
            infoParts.push(phone);
        }

        $(".delivery-address-inf1").text(infoParts.join(", "));
    }

    updateDeliveryAddress();
    updateAdditionalDeliveryInfo();

    $(".postcode, .house_no, .street_address, .billing_address").on("input", function () {
        updateDeliveryAddress();
    });

    $(".first_name, .last_name, .phone, .fact_delivery_time").on("input", function () {
        updateAdditionalDeliveryInfo();
    });

    $("#different_billing_address").on("change", function () {
        if ($(this).is(":checked")) {
            $(".different-shipping-address").show();
        } else {
            $(".different-shipping-address").hide();
        }
    });

    if ($("#different_billing_address").is(":checked")) {
        $(".different-shipping-address").show();
    }
});
