var isAdd = 0;
$(document).ready(function(){    
    $("body").on({
        mouseenter  : function(e){
            $(this).find("span.right_price").show();
            $(this).find("span.status").show();
        },
        mouseleave  : function(e){
            $(this).find("span.right_price").hide();
            $(this).find("span.status").hide();
        }
    },".list-top-movie-item, #movie-carousel-top li")


    $("body").on({
        mouseenter  : function(e){
            $(this).find("ul.sub").show();
        },
        mouseleave  : function(e){
            $(this).find("ul.sub").hide();
        }
    },"#mega-menu-1 li")

    $("body").on({
        mouseenter  : function(e){
            $(this).show();
        },
        mouseleave  : function(e){
            $(this).hide();
        }
    },"ul.sub")


    //Related book
    $("span.tab-detail a").click(function(){
        var classA = $(this).attr("class");
        $(".block-movie-detail .tab").removeClass("active");
        $(this).closest("div.tab").addClass("active");
        $(".news-article").hide();
        $("#tab-"+classA).fadeIn(500);
    })

    //SORT TOP
    $("div.list-movie-filter-item button").click(function(){
        $("div.list-movie-filter-item").find("ul").toggle();
    })

    // //Drop down logout
    // $(".widget_user_header div.btn-group").click(function(){
    //     $(this).toggleClass("open");
    // })

    //LOGOUT
    $("a.fxlink-logout").click(function(){
        $.ajax({
            url     : "/LiarsStore/index.php?module=client&controller=index&action=logout",
            dataType: "json",
            type    : "post",
            success : (data) =>{
                console.log(data);
                window.location = data.redirect;
            }
        })
    })

    //Edit cart
    $("input.input_quantity").on("change click", function(){
        var idUpdateQuantity = $(this).data("id");
        if( $(this).val() >= 0 ){
            $.ajax({
                url     : '/LiarsStore/index.php?module=client&controller=cart-book&action=updateCart',
                dataType: 'json',
                type    : 'post',
                data    : {idUpdateQuantity: idUpdateQuantity, quantityUpdate: $(this).val()}
            }).done(function(data){
                $("small.badge-cart").html(data.totalItemInCart);
                $("td.totalAmount").html("Total: " + data.totalAmount);
                $(".cart-amount").html('<i class="fa fa-dollar"></i> ' + data.totalAmount)
                $(".show_price_" + idUpdateQuantity).find("div").html(data.priceUpdated)
            })
        }else{
            alert("The quantity must greater than 0");
        }
    })

    //Check all in cart
    $("input#check-all").click(function(){
        var isCheck = this.checked;
        checkBoxs = $("form#cart-form").find(":checkbox").each(function(index, ele){
            ele.checked = isCheck
        })
    })
    //Submit form cart
    $("button#submit-form-cart").click(function(e){
        var selectedItem = $("form#cart-form").find(":checked");
        if(selectedItem.length > 0){
            $("form#cart-form").submit();
        }else{
            alert("Please choose the product that you want to buy (tick the checkbox)")
        }
    })

    //Prevent user change input price in developer tool
    // $("form#cart-form input[type=hidden]").change( function(){
    //     console.log("change");
    //     alert("You can not change the input. We will refresh after you click ok");
    // })
    $("a.change-fullname").click(function(){
        $(".box-change-fullname").toggle("fast", function(){

        });
    })
    $("a.changeEmail").click(function(){
        $(".box-change-email").toggle("fast", function(){

        });
    })
    $("a.changePassword").click(function(){
        $(".box-change-password").toggle("fast", function(){

        });
    })
    $("a#closeBox").click(function(){
        $(this).closest("div.col-sm-6").slideUp("fast");
    })

    //Change avatar
    $("input.avatar").on("change", function(){
        var filename = this.value.split('\\').pop()
        checkFileUpload =  previewPicture(this);
        console.log(checkFileUpload)
        if(checkFileUpload.fileSize == 0){
            checkFile = true;
            console.log("not-ok-size-0")
            $("a.btn-savechange-avatar").hide(300)
        }else if(checkFileUpload.fileSize < SIZE_UPLOAD.min || checkFileUpload.fileSize > SIZE_UPLOAD.max || (EXTENDSION_UPLOAD.indexOf(checkFileUpload.fileExtension) < 0 ) ){
            checkFile = false;
            console.log("not-ok");
            $("a.btn-savechange-avatar").hide(300)
        }else{
            $("a.btn-savechange-avatar").show(300)
           
        }
    })

    $("a.btn-savechange-avatar").click(function(){
        $("#form-change-avatar").submit();
    })

    //LOGIN WITH FACEBOOK
    $("a.button-login-with-fb").click(function(e){
        e.preventDefault();
        $.ajax({
            url     : "http://localhost/LiarsStore/index.php?module=client&controller=index&action=loginFacebook",
            dataType: "html",
            type    : "post",
            success : (data) =>{
                console.log(data);
                window.location = data;
            }
        })
    })

    //
    $("div.episodes ul.chapter-book-all li a").click(function(e){
        idBook = getUrlVar("id");
        $.ajax({
            url     : '/LiarsStore/index.php?module=client&controller=index&action=countView',
            dataType: 'html',
            type    : 'post',
            data    : {idBook : idBook},
            success : (data) =>{
                console.log(data);
            }
        })
    })

    //
    

})
//AJAX RELATED BOOK
function relatedBook(url){
    if(isAdd == 0){
        $.ajax({
            url     : url,
            type    : "POST",
            dataType: "json",
            success : function(data){
                console.log(data)
                var xhtml = '';
                for(x in data){
                    console.log(data[x].name)
                    xhtml += '<li>'
                                +'<a class="movie-item m-block" title="'+data[x].name+'" href="'+data[x].href+'">'
                                    +'<div class="block-wrapper">'
                                        +'<div class="movie-thumbnail ratio-box ratio-3_4">'
                                            +'<div class="public-film-item-thumb ratio-content" style="background-image:url('+data[x].picture+')"></div>'
                                        +'</div>'
                                        +'<div class="movie-meta">'
                                            +'<div class="movie-title-1">'+data[x].name+'</div>'
                                            +'<span class="fbcom-left">548</span><span class="viewed-right">144866</span>'
                                            +data[x].sale_off
                                            +'<span class="ribbon ribbon-right">'+data[x].price+'</span>'
                                        +'</div>'
                                    +'</div>'
                                +'</a>'
                            +'</li>';
                }
                $("#tab-related ul#movie-last-movie").prepend(xhtml);
            }
        })
        isAdd = 1;
    }
    
}

function changePage(page){
	$("input[name=filter_page]").val(page);
	$("#adminForm").submit();
}

function onSearch(keyword){
    if(keyword.length > 1){
        $.ajax({
            url     : '/LiarsStore/index.php?module=client&controller=index&action=ajaxSearch',
            dataType: "json",
            type    : "post",
            data    : {keyword: keyword},
            success : function(data){
                console.log(data)
                var xhtml = '';
                if(data.length > 0){
                    for(x in data){
                        xhtml += '<li><a style="background-image: url('+data[x].picture+')" class="thumb" href="'+data[x].href+'"></a>'
                                    +'<div class="ss-info">'
                                        +'<a href="'+data[x].href+'" class="ss-title">'+data[x].name+'</a>'
                                        +'<p>'+data[x].book_descript+'</p>'
                                        +'<p>13/13</p>'
                                    +'</div>'
                                    +'<div class="clearfix"></div>'
                                +'</li>';
                    }
                    $(".search-suggest").show();
                    xhtml += '<li class="ss-bottom" style="padding: 0; border-bottom: none;"><a href="#" id="suggest-all">Enter để tìm kiếm</a></li>'
                    $("#search-suggest-list").html(xhtml);
                }else{
                    $("#search-suggest-list").html('<li class="ss-bottom" style="padding: 0; border-bottom: none;"><a href="#">No record</a></li>')
                }
                
                
            }
        })
    }else{
        $(".search-suggest").hide();
    }
}

function onOrder(url, price){
    var quantityBook = Number($("input.quantity_book").val());
    if(Number.isInteger(quantityBook) != true || quantityBook <= 0){
        alert("Please type number of quantity");
        $("input.quantity_book").val(1);
    }else{
        $.ajax({
            url     : url,
            dataType: "json",
            data    : {quantity_book : quantityBook, price: price},
            type    : "POST",
            success : (data, textStatus) =>{
                //animate
                var animate = $("li.icon-cart").children().hide().end().css({
                    background  : "url('/LiarsStore/public/loading/loadingnb.gif') center center no-repeat",
                    width       : "34px",
                    height      : "41px"
                }).delay(200).promise().done( ()=>{
                    $("li.icon-cart").css("background", "none").children().show();
                })
                //Update interface
                $("small.badge-cart").html(data.totalItemInCart);
                $(".cart-amount").html('<i class="fa fa-dollar"></i> ' + data.totalAmount)
            },
            error    : (jqXHR, textStatus, errorThrowndata) =>{
                if(jqXHR.status == 200){
                    var modalLogin = "";
                    modalLogin += '<div id="myModal" class="modal fade" role="dialog">'
                                            +'<div class="modal-dialog">'
                                                +'<div class="modal-content" style="background-color: #1C1C1C">'
                                                +'<div class="modal-header">'
                                                    +'<button type="button" class="close" data-dismiss="modal">×</button>'
                                                    +'<h4 class="modal-title" style="color: darkgreen">You need Sign in!</h4>'
                                                +'</div>'
                                                +'<div class="modal-body">'
                                                    +'<p>'+formLogin+'</p>'
                                                +'</div>'
                                                +'<div class="modal-footer">'
                                                    +'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
                                                +'</div>'
                                                +'</div>'
                                    
                                            +'</div>'
                                        +'</div>'
                                        +'<script>$(document).ready(function(){$("#myModal").modal("show") })</script>';
                    $("div.container").append(modalLogin);
                }
            }
        })
    }
}

function onOpenCart(){
    $(".widget_user_header .layer_hide .cart-amount").delay(200).show().animate({
        bottom     : 47 + "%",
    },300, () =>{
        $("a.main-wrap-cart").attr("href", "javascript:onCloseCart()");
        $("a.main-wrap-cart").css("color", "#CED20A")
    });
    $(".widget_user_header .layer_hide .cart-detail").show().animate({
        bottom     : 42 + "%",
    },300)
    $(".widget_user_header .layer_hide .cart-history").delay(100).show().animate({
        bottom     : 37 + "%",
    },300)
}
function onCloseCart(){
    $(".widget_user_header .layer_hide .cart-amount").delay(200).animate({
        bottom     : 0 + "%",
    },100, () =>{
        $("a.main-wrap-cart").attr("href", "javascript:onOpenCart()");
        $(".widget_user_header .layer_hide .cart-amount").hide();
        $("a.main-wrap-cart").css("color", "#ced1f9")
    });
    $(".widget_user_header .layer_hide .cart-detail").animate({
        bottom     : 0 + "%",
    },100, ()=>{
        $(".widget_user_header .layer_hide .cart-detail").hide();
    });
    $(".widget_user_header .layer_hide .cart-history").delay(100).animate({
        bottom     : 0 + "%",
    },100, ()=>{
        $(".widget_user_header .layer_hide .cart-history").hide();
    });
}

//DELETE IN CART
function onDeleteCart(id){
    $("#book-in-cart-" + id).remove();
    $.ajax({
        url     : '/LiarsStore/index.php?module=client&controller=cart-book&action=deleteCart',
        dataType: 'json',
        type    : 'post',
        data    : {idDelete : id}
    }).done(function(data){
        console.log(data);
        $("small.badge-cart").html(data.totalItemInCart);
        $("td.totalAmount").html("Total: " + data.totalAmount);
    })
}

//Login Ajax
function ajaxCheckPassword(){
    var username = $("#myModal").find("input.username").val();
    var password = $("#myModal").find("input.password").val();
    var token    = $("#myModal").find("input.token").val();
    $.ajax({
        url     : '/LiarsStore/index.php?module=client&controller=index&action=ajaxLogin',
        dataType: "json",
        type    : "POST",
        data    : {username: username, password: password, token: token}
    }).done(function(data){
        if(data.redirect != undefined){
            window.location = data.redirect;
        }else{
            window.location = "";
        }
        
    })
    return false;
}

function checkInputStringDanger(query ,labelName, options){
    $(query).keyup(function(){
        var hasA = 0;
        if(options == true){
            hasA = $(this).val().indexOf("@");
        }
        if( $(this).val().length < options[0] || $(this).val().length > options[1] || hasA ==-1 ){
            $(this).closest("div.form-group").addClass("has-warning");
            $(this).closest("div.form-group").children("label").html('<i class="fa fa-warning"></i> ' + labelName);
        }else{
            $(this).closest("div.form-group").removeClass("has-warning");
            $(this).closest("div.form-group").children("label").html('<i class="fa fa-check"></i> ' + labelName);
        }
    })    
}

function ajaxCheckInputUser(query, length_check, linkAjax, colCheck, isEdit = false){
    $(query).keyup(function(){
        if( $(this).val().length >= length_check[0] && $(this).val().length <= length_check[1] ){
            $(this).parent().find('span.warning').hide().end().find('span.success').hide();
            $(this).closest("div.form-group").addClass("has-feedback");
            var animation = $(this).parent().find('span.loading').show().delay(100).promise();
            animation.done(function(){
                $.ajax({
                    url     : linkAjax,
                    dataType: "json",
                    type    : "POST",
                    data    : {valueCheck :   $(query).val(), id : isEdit, colCheck: colCheck }
                }).done(function(data){
                    console.log(data)
                    if(data.check_status == true){
                        $(query).parent().find('span.loading').hide().end().find('span.warning').hide().end().find('span.success').show();
                        $(query).closest("div.form-group").removeClass('has-warning').addClass("has-success");
                        $("button[type=submit], a.submit-form").removeClass("disabled");
                    }else{
                        $(query).parent().children("label").find("i").removeClass("fa-check").addClass("fa-warning");
                        $(query).parent().find('span.loading').hide().end().find('span.success').hide().end().find('span.warning').show();
                        $(query).closest("div.form-group").removeClass('has-success').addClass("has-warning");
                        $("button[type=submit], a.submit-form").addClass("disabled");
                    }
                    return data.check_status;
                })
            })
        }else{
            $(this).parent().find('span.loading').hide().end()
                            .find('span.success').hide().end()
                            .find('span.warning').hide().end();
            $("button[type=submit], a.submit-form").addClass("disabled");
        }
    })
}

//AJAX RESEND ACTIVE CODE
function resendActiveCode(link){
    $("a.resend-active-code").attr("href", "#").parent().css({
        "padding": "8px 33px 8px 0px",
        "background": 'url("/LiarsStore/public/loading/loadingnb.gif") center right no-repeat',
        "background-color": '#f9f2f4',
    })
    $.ajax({
        url     : link,
        dataType: "html",
        type    : "POST",
        success : (data) =>{
            $("a.resend-active-code").attr("href", "javascript:resendActiveCode('" + link + "')").parent().css({
                "padding": "2px 4px",
                "background": 'none',
                "background-color": '#f9f2f4'
            })
        },
        error   : (jqXHR, textStatus, errorThrowndata) => {
            console.log(errorThrowndata)
            console.log(textStatus)
        }
    })
}

function viewSite(link){
    window.open(link);
}

function changeInfo(query){
    var valueChange = $(query).val();
    $("div.mark-animation").show();
    $("div.modal-info-user").css("opacity", 0.6);
    $.ajax({
        url     : '/LiarsStore/index.php?module=client&controller=user&action=changeInfo',
        dataType: 'json',
        type    : 'post',
        data    : {columnChange : query.replace("#", ""), valueChange: valueChange}
    }).done( (data) =>{
        console.log(data);
        $("div.mark-animation").delay(400).fadeOut();
        $("div.modal-info-user").delay(400).animate({opacity: 1});
        if(data.status == 1){
            if(query == "#fullname"){
                $("div.header .widget_user_header button.username").html("Hello, " + valueChange);
            }
            $("div.show-" + query.replace("#", "")).html(valueChange);
        }
    })

}
function changePassword(qnew, qold){
    var newPassword = $(qnew).val();
    var oldPassword = $(qold).val();

    $("div.mark-animation").show();
    $("div.modal-info-user").css("opacity", 0.6);
    $.ajax({
        url     : '/LiarsStore/index.php?module=client&controller=user&action=changePassword',
        dataType: 'json',
        type    : 'post',
        data    : {newPassword: newPassword, oldPassword: oldPassword}
    }).done( (data) =>{
        console.log(data)
        $("div.mark-animation").delay(400).fadeOut();
        $("div.modal-info-user").delay(400).animate({opacity: 1});
        if(data.status == 0){
            $("div.box-change-password").append('<div class="alert alert-danger alert-dismissable" style="margin-top:10px"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Alert!</b> Wrong password! </div>');
        }else{
            $("div.box-change-password").append('<div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Alert!</b> Success change infomation!</div>');
        }
    })
}


function openFile(){
    $("input.avatar").click();
    // $("img#preview_picture").hide();
    return false;
}

//Preview picure before upload
function previewPicture(input) {
    var filename = input.value.split('\\').pop();
    var fileExtension = getFileExtenstion( filename);
    if( filename.trim().length > 0){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                if( EXTENDSION_UPLOAD.indexOf(fileExtension) >= 0){
                    $('#preview_picture').attr('src', e.target.result);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
        return {fileSize: input.files[0].size, fileExtension: getFileExtenstion( filename), fileSizeMB: convertFileSizeToMB(input.files[0].size) };
    }else{
        return {fileSize: 0, fileExtension: "", fileSizeMB: 0 };
    }
    
}

//get file extension
function getFileExtenstion(filename){
    return filename.split(".").pop();

}

function convertFileSize(fileSize){
    if(fileSize <= 1024){
        fileSize = fileSize + " KB";
    }else if(fileSize > 1024){
        fileSize = Math.ceil(fileSize/1024) + " KB";
    }else if(fileSize > 1024*1024){
        fileSize = Math.ceil( fileSize/(1024*1024) ) + " MB";
    }else if(fileSize > 1024*1024*1024){
        fileSize = Math.ceil( fileSize/(1024*1024*1024) ) + " GB";
    }
    return fileSize;
}

function convertFileSizeToMB(fileSize){
    return fileSize/(1024*1024);
}

function getUrlVar(key){
	var result = new RegExp(key + "=([^&]*)", "i").exec(window.location.search); 
	return result && unescape(result[1]) || ""; 
}

function openModalConfigFont(){
    $("div.wrap-mask").fadeIn();
    $("div.modal-config-font").show();
    $("div.modal-config-font").animate({
        top: "20%",
        opacity: 1
    },300);
}
function closeConfig(){
    $("div.wrap-mask").fadeOut();
    $("div.modal-config-font").animate({
        top: "15%",
        opacity: 0
    },300, () =>{
        $("div.modal-config-font").hide();
    });
    
}