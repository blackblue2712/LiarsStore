<?php
    $noitice_msg = "";
    if(isset($_SESSION['noitice'])){
        $noitice_msg = "<span class='alert alert-danger' style=''>".$_SESSION['noitice'].". We will redirect you back to login</span>";
    }
    echo $noitice_msg;
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