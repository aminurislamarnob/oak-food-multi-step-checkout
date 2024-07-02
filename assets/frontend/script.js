jQuery(document).ready(function($) {
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
                    alert('Success: ' + response.data.message);
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
});
