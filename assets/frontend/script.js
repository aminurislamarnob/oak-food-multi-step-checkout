jQuery(document).ready(function($) {

     // Initialize datepicker
     $('#delivery_date').datepicker({
        dateFormat: 'yy-mm-dd' // Adjust date format as needed
    });
    
    /*Get delivery info input*/
    $('#delivery-step-next-btn').on('click', function(e) {
        e.preventDefault();

        var isValid = true;
        var delivery_button = $(this);
        var error_message = $('.oak-delivery-fields-wrapper').find('.woocommerce-notices-wrapper');

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

        var isValid = true;
        var fact_button = $(this);
        var error_message = $('.oak-facts-section-wrapper').find('.woocommerce-notices-wrapper');

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

    // Toggle show hide checkout page login form
    $('#facts-step-prev-btn').on('click', function(e) {
        e.preventDefault();
        $('.oak-facts-section-wrapper').toggle();
        $('.oak-delivery-fields-wrapper ').toggle();
        $('.fact-step-btn, .delivery-step-btn').toggleClass('active');
    });
    $('#pm-step-prev-btn').on('click', function(e) {
        e.preventDefault();
        console.log('test');
        $('.oak-facts-section-wrapper').show();
        $('form.woocommerce-checkout').removeClass('oak-d-block');
        $('form.woocommerce-checkout').hide();
        $('.pm-step-btn, .fact-step-btn').toggleClass('active');
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
});
