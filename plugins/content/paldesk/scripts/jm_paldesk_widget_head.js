
var script = document.createElement('script');
script.async = true;
script.src="https://paldesk.io/api/widget-client?apiKey={{widget_api_key}}";
//alert( "paldeskConfig.apiKey =" +  paldeskConfig.apiKey)
script.onload = function () {

    {{widget_user_data_config_object}}

    var instance = BeeBeeate.widget.new(beebeeate_config);
}

window.onload = function(e){
    document.body.appendChild(script);
}
