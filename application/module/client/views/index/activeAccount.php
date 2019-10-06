<?php
    if(!isset($_SESSION["emailToResendActivecCode"])){
        $redirectURL = URL::createURL("client", "index","index", null, "/index.html");
        echo Helper::createScript("window.location = '".$redirectURL."'");
    }

    $urlResendActiveCode = URL::createURL("client", "index", "resendActiveCode");
    $urlBack             = URL::createURL("client", "index", "index", null, "/index.html");
?>
<div class="div-col-sm-8">
    <div class="bs-callout bs-callout-info" id="callout-labels-inline-block" style="margin-bottom: 42px;">
        <h4>You need to active your account first</h4>
        <p>We sent an <a href="https://mail.google.com">email for you</a> already. It include link to active your account<br><br>
            <code><a href="<?php echo $urlBack ?>">Back home</a></code>
            <code><a class="resend-active-code" href="javascript:resendActiveCode('<?php echo $urlResendActiveCode ?>')">Resend</a></code>
        </p>
    </div>
</div>


</div>
</div>
<?php
    include_once PATH_TEMPLATE . DS . "client/main/html/footer.php";
    exit();
?>