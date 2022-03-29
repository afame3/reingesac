
var script = document.createElement('script');
script.async = true;
script.src="https://paldesk.io/api/nwidget-client?apiKey=" + paldeskConfig.apiKeyNotification;
//alert( "paldeskConfig.apiKey =" +  paldeskConfig.apiKey)
script.onload = function () {
    /*
    here you can add user_data to config object
    eg.
    beebeeate_config.user_data = {
        externalId: "your_id_for_user"
        username: "username",
        first_name: "user_first_name",
        last_name: "user_last_name",
    }
    */
    var instance = BeeBeeateNotification.widget.new(beebeeate_config_notification);
}

var head = document.getElementsByTagName('head').item(0);
head.appendChild(script);
//document.body.appendChild(script);
