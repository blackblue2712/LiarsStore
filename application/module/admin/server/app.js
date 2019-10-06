var totalSalesMade = 0;

(function($){
    $.liarsMain = function(options){
        var socket = io.connect("http://localhost:8080");

        init();
        function init(){
            authInit();
            authSocket();
        }

        function authInit(){
            //Delete notification badge when click to it
            $("a.count-notifications").click(function(){
                socket.emit("admin-cart-deleteBadge");
            })
        }
        function authSocket(){
            var sound = new buzz.sound("/LiarsStore/public/audio/Google_Event-1", {
                formats: ["mp3"]
            });
            socket.on('auth-cart-checkout', (data) =>{ 
                sound.play();
                if(data.countSelectedItem > 0){
                    var countNotifications =  $("li.notifications-menu a.count-notifications span").html();
                    var issetCheckCout     = $('li.notifications-menu li.count-sales-made').find("i").length;
                    console.log(issetCheckCout)
                    if(countNotifications != undefined){
                        countNotifications = parseInt(countNotifications);
                        if(issetCheckCout > 0){
                            $("li.notifications-menu a.count-notifications").html('<i class="glyphicon glyphicon-globe"></i><span class="label label-danger">1</span>');
                            $("li.notifications-menu li.header").html('You have 1 notifications');
                        }else{
                            $("li.notifications-menu a.count-notifications").html('<i class="glyphicon glyphicon-globe"></i><span class="label label-danger">'+ (countNotifications+1) +'</span>')
                            $("li.notifications-menu li.header").html('You have '+(countNotifications+1)+' notifications');
                        }
                    }else{
                        $("li.notifications-menu a.count-notifications").html('<i class="glyphicon glyphicon-globe"></i><span class="label label-danger">1</span>')
                        $("li.notifications-menu li.header").html('You have 1 notifications');
                    }
                    totalSalesMade += data.countSelectedItem;
                    var salseMadeInDb = parseInt($("li.count-sales-made a").text());
                    if(salseMadeInDb > 0){
                        $("li.notifications-menu ul.menu li.count-sales-made a").html('<i class="ion ion-ios7-cart success"></i> '+(totalSalesMade+salseMadeInDb)+' sales made');
                    }else{
                        $("li.notifications-menu ul.menu li.count-sales-made a").html('<i class="ion ion-ios7-cart success"></i> '+totalSalesMade+' sales made');
                    }
                    
                }
            });

            //Delete notification badge when click to it
            socket.on("admin-cart-deleteBadge", () =>{
                $("li.notifications-menu a.count-notifications").html('<i class="glyphicon glyphicon-globe"></i>')
            })
        }
    }


})(jQuery);


$(document).ready(function(){
    $.liarsMain();
})