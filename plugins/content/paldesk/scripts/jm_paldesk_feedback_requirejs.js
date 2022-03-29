window.onload = function(e){
    requirejs(["https://paldesk.io/api/fwidget-client?apiKey={{feedback_api_key}}"], function( BeeBeeate ) {

        {{feedback_user_data_config_object}}

        var instance = BeeBeeateFeedback.widget.new(beebeeate_config_feedback);
    });
}