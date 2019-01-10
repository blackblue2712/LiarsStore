<?php
    $error_msg = "";
    if(isset($this->params['error'])){
        switch($this->params['error']){
            case "do-not-have-permission": $error_msg = "<span class='alert alert-danger' style=''>You don't have permission to access <b>Admin Controll Panel</b>. We will redirect you back to home page</span>";
            break;
        }
    }
    echo $error_msg;
?>
<script type="text/javascript">
    var redi = $("span").delay(2000).promise();
    redi.done( () =>{
        window.location = "/LiarsStore/index.html";
    })
</script>

<?php
    exit();
?>