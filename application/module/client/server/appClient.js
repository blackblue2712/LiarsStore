
(function($){
    $.liarsMain = function(options){
        var socket = io.connect("http://localhost:8080");

        init();
        function init(){
            authInit();
            authSocket();
        }

        function authInit(){
            $("button#submit-form-cart").click(function(e){
                var selectedItem = $("form#cart-form").find(":checked");
                var countSelectedItem = selectedItem.length;
                console.log(countSelectedItem)
                if(countSelectedItem > 0){
                    var isCheckeAll     = document.getElementById("check-all").checked;
                    if(isCheckeAll == true){
                        countSelectedItem -= 1;
                    }
                    socket.emit('auth-cart-checkout', {countSelectedItem : countSelectedItem});
                }
            });
        }

        function authSocket(){
            
        }

    }


})(jQuery);


$(document).ready(function(){
    $.liarsMain();
})