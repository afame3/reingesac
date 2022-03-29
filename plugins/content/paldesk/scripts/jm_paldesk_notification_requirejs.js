window.onload = function(e){
    requirejs(["https://paldesk.io/api/nwidget-client?apiKey={{notification_api_key}}"], function( BeeBeeate ) {

        {{notification_user_data_config_object}}

        var instance = BeeBeeateNotification.widget.new(beebeeate_config_notification);
    });
}