// REST API Plugin
function mo_rest_api_plugin_adv_install_activate(nonce) {
    const button = jQuery('#mo_rest_api_plugin_adv_button');
    const actionText = 'Securing your site...';

    button.text(actionText).prop('disabled', true);

    const data = {
        action: 'install_and_activate_rest_api_free',
        nonce: nonce,
    };

    jQuery.post(ajaxurl, data)
        .done(function (response) {
            if (response.success && response.data.redirect_url) {
                window.location.href = response.data.redirect_url;
            } else {
                button.text('Enable Now').prop('disabled', false);
                alert('An error occurred. Please try again.');
            }
        })
        .fail(function () {
            button.text('Enable Now').prop('disabled', false);
            alert('Failed to connect to the server. Redirecting to the plugin page...');
            window.location.href = 'https://wordpress.org/plugins/wp-rest-api-authentication/';
        });
}

function mo_plugins_test_api_security(nonce, buttonId) {
    document.getElementById(buttonId).innerText = 'Checking...';

    const data = {
        action: 'test_api_security',
        nonce: nonce,
    };

    jQuery.post(ajaxurl, data)
        .done(function (response) {
            location.reload();
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX request failed: ", textStatus, errorThrown);
        });
}

jQuery(document).on('click', '#mo_rest_api_plugin_adv_notice .notice-dismiss', function () {
    const data = {
        action: 'mo_rest_api_plugin_adv_dismiss_notice',
    };
    jQuery.post(ajaxurl, data, function (response) {
        if (!response.success) {
            console.error('Failed to update dismiss status.');
        }
    });
});
