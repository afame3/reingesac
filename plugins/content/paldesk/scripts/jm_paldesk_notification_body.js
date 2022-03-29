
var script = document.createElement('script');
script.async = true;
script.src="https://paldesk.io/api/nwidget-client?apiKey={{notification_api_key}}";
//alert( "paldeskConfig.apiKey =" +  paldeskConfig.apiKey)
script.onload = function () {

    {{notification_user_data_config_object}}

    var instance = BeeBeeateNotification.widget.new(beebeeate_config_notification);
}

document.body.appendChild(script);
