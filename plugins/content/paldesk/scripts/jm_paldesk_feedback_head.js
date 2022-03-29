
var script = document.createElement('script');
script.async = true;
script.src="https://paldesk.io/api/fwidget-client?apiKey={{feedback_api_key}}";
//alert( "paldeskConfig.apiKey =" +  paldeskConfig.apiKey)
script.onload = function () {

    {{feedback_user_data_config_object}}

    var instance = BeeBeeateFeedback.widget.new(beebeeate_config_feedback);
}

window.onload = function(e){
    document.body.appendChild(script);
}
