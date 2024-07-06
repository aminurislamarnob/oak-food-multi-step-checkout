jQuery(document).ready(function($) {
    /*Get Email input*/
    $('#checkout-first-step-btn').on('click', function(e) {
        e.preventDefault();

        // Get email input value
        var email = $('#oak_billing_email').val();

        // AJAX call
        $.ajax({
            type: 'POST',
            url: Oak_Food_Multi_Step_Checkout.ajax_url,
            data: {
                action: 'handle_checkout_step',
                email: email,
                security: Oak_Food_Multi_Step_Checkout.nonce
            },
            success: function(response) {
                // Check if request was successful
                if (response.success) {
                    $('.enter-email-step').hide();
                    $('.checkout-delivery-step').show();
                    $('#fact_email').val(email);
                    // alert('Success: ' + response.data.message);
                } else {
                    console.log(response);
                    // Display WooCommerce error notice
                    // $('.woocommerce-error').remove(); // Remove existing notices
                    // $('.woocommerce-message').remove();
                    // $('form.cart').before('<div class="woocommerce-error">' + response.data.message + '</div>');
                }
            },
            error: function(errorThrown) {
                // Handle error
                console.log('AJAX request failed');
                console.log(errorThrown);
            }
        });
    });

    /*Get delivery info input*/
    $('#delivery-step-next-btn').on('click', function(e) {
        e.preventDefault();

        var isValid = true;

        // Reset all previous error messages
        $('.error-message').text('').hide();

        // Validate each required input field
        $('.oak-delivery-fields .oak-required-field').each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                var fieldName = $(this).closest('.form-row').find('label').text();
                $(this).closest('.form-row').addClass('woocommerce-invalid');
                $(this).closest('.form-row').find('.error-message').text(fieldName + ' is required.').show();
            }
        });
        console.log(isValid);

        // AJAX call
        if (isValid) {
            var delivery_type = $('#delivery_type:checked').val();
            var postcode = $('.postcode').val();
            var billing_house_no = $('#billing_house_no').val();
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
                    billing_address: billing_address,
                    delivery_date: delivery_date,
                    delivery_time: delivery_time,
                    security: Oak_Food_Multi_Step_Checkout.nonce
                },
                success: function(response) {
                    // Check if request was successful
                    if (response.success) {
                        // alert('Success: ' + response.data.message);
                        $('.oak-delivery-fields-wrapper').hide();
                        $('.oak-facts-section-wrapper').show();
                    } else {
                        console.log(response);
                        // Display WooCommerce error notice
                        // $('.woocommerce-error').remove(); // Remove existing notices
                        // $('.woocommerce-message').remove();
                        // $('form.cart').before('<div class="woocommerce-error">' + response.data.message + '</div>');
                    }
                },
                error: function(errorThrown) {
                    // Handle error
                    console.log('AJAX request failed');
                    console.log(errorThrown);
                }
            });
        }
    });

    /*Get fact info input*/
    $('#facts-step-next-btn').on('click', function(e) {
        e.preventDefault();

        var isValid = true;

        // Reset all previous error messages
        $('.error-message').text('').hide();

        // Validate each required input field
        $('.oak-facts-fields .oak-required-field').each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                var fieldName = $(this).closest('.form-row').find('label').text();
                $(this).closest('.form-row').addClass('woocommerce-invalid');
                $(this).closest('.form-row').find('.error-message').text(fieldName + ' is required.').show();
            }
        });

        // AJAX call
        if (isValid) {
            var fact_email = $('#fact_email').val();
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var phone = $('#phone').val();
            var fact_delivery_time = $('#fact_delivery_time').val();
            var custom_password = $('#custom_password').val();
            var different_billing_address = $('#different_billing_address:checked').val();

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
                    security: Oak_Food_Multi_Step_Checkout.nonce
                },
                success: function(response) {
                    // Check if request was successful
                    if (response.success) {
                        // alert('Success: ' + response.data.message);
                        $('.oak-facts-section-wrapper').hide();
                        $('.woocommerce-checkout').show();
                    } else {
                        console.log(response);
                        // Display WooCommerce error notice
                        // $('.woocommerce-error').remove(); // Remove existing notices
                        // $('.woocommerce-message').remove();
                        // $('form.cart').before('<div class="woocommerce-error">' + response.data.message + '</div>');
                    }
                },
                error: function(errorThrown) {
                    // Handle error
                    console.log('AJAX request failed');
                    console.log(errorThrown);
                }
            });
        }
    });

    // Function to remove error message when user starts typing in fields
    $('.oak-required-field').on('input', function() {
        if ($(this).val().trim() !== '') {
            $(this).closest('.form-row').find('.error-message').hide();
            $(this).closest('.form-row').removeClass('woocommerce-invalid');
        }else{
            $(this).closest('.form-row').find('.error-message').show();
            $(this).closest('.form-row').addClass('woocommerce-invalid');
        }
    });

    // Toggle show hide checkout page login form
    $('.oak-checkout-login-form a.showlogin').on('click', function(e) {
        e.preventDefault();
        $('.oak-checkout-login-form .wc-checkout-login-form').toggle();
        $('.oak-facts-email-row').toggle();
    });

    //Always select create account checkbox
    // $('input#createaccount').prop('checked', true);
});
