window.onload = function(e){
    requirejs(["https://paldesk.io/api/widget-client?apiKey={{widget_api_key}}"], function( BeeBeeate ) {

        {{widget_user_data_config_object}}

        var instance = BeeBeeate.widget.new(beebeeate_config);
    });
}