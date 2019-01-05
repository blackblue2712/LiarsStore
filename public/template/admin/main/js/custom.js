$(document).ready(function(){
    var totalItems  = 0;
    var isValidOrdering = false;
    var countMessage    = 0;
    
    //Active the sildebar menu
    $(".sidebar-menu li").click(function(){
        
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });

    //When unchecking the checkbox
    $("#check-all").on('ifUnchecked', function(event) {
        //Uncheck all checkboxes
        $("input[type='checkbox']").iCheck("uncheck");
    });
    
    //When checking the checkbox
    $("#check-all").on('ifChecked', function(event) {
        //Check all checkboxes
        $("input[type='checkbox']").iCheck("check");
    });

    $("#logout").click(function(){
        window.location = "/LiarsStore/index.php?action=logout";
    })

    $("a.deleteMulti").click(function(){
        
    })

   

    // TYPING_SEARCH
    $("div.typing_search li").click(function(){
        var textSelect       = $(this).text();
        var RoleSelect       = $(this).attr("role");
        var textShowInButton = $("div.typing_search").find("button").text();
        var roleInButton     = $("div.typing_search").find("button").attr("role");

        console.log(RoleSelect);
        console.log(roleInButton);
        
        $("div.typing_search").find("button").html(textSelect + ' <span class="fa fa-caret-down"></span>');
        $("div.typing_search").find("button").attr('role', RoleSelect);

        $(this).find('a').text(textShowInButton);
        $(this).attr("role", roleInButton);

        $('input[name=filter_typing]').val( RoleSelect );
    })

    $("button.typing_search_action").click(function(){
        $("#adminForm").submit();
    })

    //ENTER TO SEARCH
    $("input#content_search").keyup(function(e){
        if(e.keyCode == 13){
            $("#adminForm").submit();
        }   
    })
    //CLEAR CONTENT SEARCH
    $("button.clear_content_search").click(function(){
        $("input#content_search").val("");
    })

    //SORT BY SELECT
    $("#select_filter_group").on("change", function(){
        var nameGroupSelected = $(this).find(":selected").val();
        $("input[name=filter_name_group]").val(nameGroupSelected);
        $("#adminForm").submit();
    })
    $("#select_filter_status").on("change", function(){
        var statusSelect = $(this).find(":selected").val();
        // $("input[name=filter_name_group]").val(statusSelect);
        $("#adminForm").submit();
    })

    //Pagination
    $("li.disabled").find("i").css("color", "red");

    //CHANGE ORDERING BY AJAX
    $("body").on({

        keyup   : function(e){
            if(e.keyCode != 13){
                isValidOrdering = changeOrderingAjax( $(this).val() )
            }
        },
        click  : function(e){
            if(e.keyCode != 13){
                isValidOrdering = changeOrderingAjax( $(this).val() )
            }
        }, 
        blur    : function(e){
            if(isValidOrdering == true){
                $.ajax({
                    url     : "/LiarsStore/index.php?module=admin&controller=group&action=changeOrdering&id_update=" +  $(this).data("id") + "&valueUpdateTo=" + $(this).val(),
                    tpye    : "POST",
                    dataType: "json"
                }).done(function(data){
                    var msgHTML = '<div style="display:none" class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Alert!</b> The ordering has <b>group id '+ data.idUpdate +'</b> has been change to <b> '+ data.orderingUpdate +' </b> </div>';
                    $(".message_alert").append(msgHTML);
                    var showAnimate = $(".message_alert .alert:eq(" + countMessage +")").slideDown().delay(3000).slideUp().promise();
                    showAnimate.done(function(){
                        $(".message_alert .alert:eq(" + countMessage +")").empty();
                    })
                    $("a#sort-ordering").removeClass("label label-success").removeClass("label label-danger");
                    countMessage ++;
                })
            }else{
                //display errors
                var msgHTML = '<div style="display:none" class="alert alert-warning alert-dismissable"><i class="fa fa-warning"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Alert!</b> Can not update the <b>unvalid ordering</b>, The range valid value is <b>1 to 20</b></div>';
                $(".message_alert").append(msgHTML);
                var showAnimate = $(".message_alert .alert:eq(" + countMessage +")").slideDown().delay(3000).slideUp().promise();
                showAnimate.done(function(){
                    $(".message_alert .alert:eq(" + countMessage +")").empty();
                })
                $("a#sort-ordering").removeClass("label label-success").removeClass("label label-danger");
                countMessage ++;
            }
        }
    }, 'input[name=ordering]');

});




//DELETE MULTI
function deleteMulti(linkDelete){
    var flag = confirm("Are you fucking sure?");
    if(!flag){
        return false;
    }else{
        $("#adminForm").attr("action", linkDelete);
        $("#adminForm").submit();
    }
}

//PUBLIC MULTI
function publicMulti(linkPublic){
    $("#adminForm").attr("action", linkPublic);
    $("#adminForm").submit();
}
//UN PUBLIC MULTI
function unpublicMulti(linkUnpublic){
    $("#adminForm").attr("action", linkUnpublic);
    $("#adminForm").submit();
}

// FILTER/SORT
//SORT BY TYPING
function sortList(col, type){
    $("input[name=filter_column]").val(col);
    $("input[name=filter_column_dir]").val(type);
    $("#adminForm").submit();
}

//CHANGE PAGE
function changePage(page){
	$("input[name=filter_page]").val(page);
	$("#adminForm").submit();
}




function getUrlVar(key){
	var result = new RegExp(key + "=([^&]*)", "i").exec(window.location.search); 
	return result && unescape(result[1]) || ""; 
}

function checkInputStringDanger(query ,labelName, options){
    $(query).keyup(function(){
        if( $(this).val().length < options[0] || $(this).val().length > options[1] ){
            $(this).closest("div.form-group").addClass("has-warning");
            $(this).closest("div.form-group").children("label").html('<i class="fa fa-warning"></i> ' + labelName);
        }else{
            $(this).closest("div.form-group").removeClass("has-warning");
            $(this).closest("div.form-group").children("label").html('<i class="fa fa-check"></i> ' + labelName);
        }
    })    
}
function checkInputNumberDanger(query ,labelName, options = false){
    $(query).keyup(function(){
        if( $(this).val() < options[0] || $(this).val() > options[1] ){
            $(this).closest("div.form-group").addClass("has-warning");
            $(this).closest("div.form-group").children("label").html('<i class="fa fa-warning"></i> ' + labelName);
        }else{
            $(this).closest("div.form-group").removeClass("has-warning").addClass("has-success");
            $(this).closest("div.form-group").children("label").html('<i class="fa fa-check"></i> ' + labelName);
        }
    })    
}

function ajaxCheckInputGroup(query, length_check, linkAjax, isEdit = false){
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
                    data    : {groupName :   $(query).val(), id : isEdit }
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



//CHANGE STATUS BY AJAX
function changeStatus(link){
    console.log(link)
    $.ajax({
        url     : link,
        dataType: 'json',
        type    : 'POST'
    }).done(function(data){
        console.log(data);
        var elementUpdate   = data.elementUpdate;
        var statusUpdate    = data.statusUpdate;
        var affectedRows    = data.affectedRows;
        var idUpdate        = data.idUpdate;

        var strClassAAdd    = (statusUpdate == 0) ? "label-danger" : "label-success";
        var strClassARemove = (statusUpdate == 0) ? "label-success" : "label-danger";
        var strClassIRemove    = (statusUpdate == 0) ? "fa-check" : "fa-ban";
        var strClassIAdd = (statusUpdate == 0) ? "fa-ban" : "fa-check";

        $(".show_" + elementUpdate + "_" + idUpdate).find("a").attr("href", data.link);
        $(".show_" + elementUpdate + "_" + idUpdate).find("a").removeClass(strClassARemove).addClass(strClassAAdd);
        
        $(".show_" + elementUpdate + "_" + idUpdate).find("i").removeClass(strClassIRemove).addClass(strClassIAdd);
                                          
    })
}

//CHANGE ORDERING BY AJAX
function changeOrderingAjax(valueChange){
    if(valueChange < 1 || valueChange > 20){
        $("a#sort-ordering").addClass("label label-danger").removeClass("label label-success");
        return false;
    }else{
        $("a#sort-ordering").addClass("label label-success").removeClass("label label-danger");
        return true;
    }
}


//RELOAD PAGE
function reload(){
    window.location = "";
}









//Shuffle array
function shuffle(array) {
    let counter = array.length;

    // While there are elements in the array
    while (counter > 0) {
    // Pick a random index
    let index = Math.floor(Math.random() * counter);

    // Decrease counter by 1
    counter--;

    // And swap the last element with it
    let temp = array[counter];
    array[counter] = array[index];
    array[index] = temp;
    }

    return array;
}


