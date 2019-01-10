<?php
    $minEp      = (int)$this->minMaxEp["minEp"];
    $maxEp      = (int)$this->minMaxEp["maxEp"];
    $currentEp  = (int)$this->params["chapter"];

    $id_book = (int)$this->params["id_book"];
    $chapter = (int)$this->params["chapter"];
    $Nextchapter = (int)$this->params["chapter"] + 1;
    $Prevchapter = (int)$this->params["chapter"] - 1;

    $url_back = URL::createURL("client", "index", "detail", array("id" =>$id_book), "/detail-book-$id_book.html");
    $url_prev = URL::createURL("client", "index", "readBook", array("id_book" =>$id_book, "chapter" => $Prevchapter), "/read-book-$id_book-$Prevchapter.html");
    $url_next = URL::createURL("client", "index", "readBook", array("id_book" =>$id_book, "chapter" => $Nextchapter), "/read-book-$id_book-$Nextchapter.html");

    
    if(isset($_SESSION["configReadBook"])){
        $fontConfig         = $_SESSION["configReadBook"]["fontConfig"];
        $backgroundConfig   = $_SESSION["configReadBook"]["backgroundConfig"];
        $colorConfig        = $_SESSION["configReadBook"]["colorConfig"];
        $fontSizeConfig     = $_SESSION["configReadBook"]["fontSizeConfig"];
        echo Helper::createScript(
            '$("blockquote.generate-chapter").css({
                "font-family"         : "'.$fontConfig.'",
                "background-color"    : "'.$backgroundConfig.'",
                "color"               : "'.$colorConfig.'",
                "font-size"           : "'.$fontSizeConfig.'px"
            });'
        );

        echo Helper::createScriptSelected2("select.select-font", $fontConfig);
        echo Helper::createScript('$("input#set-font-size").val("'.$fontSizeConfig.'px")');
        echo Helper::createScript('$("div.set-background-color").find("span[data-color='.$backgroundConfig.']").css("border", "2px solid #fd3939");');
        echo Helper::createScript('$("div.set-color").find("span[data-color='.$colorConfig.']").css("border", "2px solid #fd3939");');
    }
?>
<div class="col-sm-12">
    <span class="tabs">
        <div class="tab active" data-name="day" data-target=".right-box.top-film .content">
            <div class="name"><a title="Day" href="DAY">READ BOOK</a></div>
        </div>
    </span>
    <div class="clearfix"></div>
    <blockquote class="generate-chapter" style="margin-top: 20px; color: #ccc; border-left-color: #10B591">
        <?php echo html_entity_decode( stripcslashes( stripcslashes($this->renderedChapter["content_chapter"])))?>
    </blockquote>

    <div class="wrap-control-readbook">
        <a title="Back" href="<?php echo $url_back?>" class="back-to-detail"><i class="fa fa-backward"></i></a>
        <a title="Previous" href="<?php echo $url_prev?>" class="prev-chapter"><i class="fa fa-chevron-left"></i></a>
        <a title="Next" href="<?php echo $url_next?>" class="next-chapter"><i class="fa fa-chevron-right"></i></a>
        <a title="Font" href="javascript:openModalConfigFont()" class="modal-font"><i class="fa fa-font"></i></a>
    </div>
</div>

<div class="modal-config-font">
    <h3><div class="modal-config-header">Custom</div></h3>
    <div class="modal-config-body">
        <div class="col-md-12" style="margin-bottom:10px">
            <label class="pull-left">Background-color: </label>
            <div class="set-background-color pull-right">
                <span data-color="#fff" data-id="0" style="background-color: #fff"></span>
                <span data-color="#333333" data-id="1" style="background-color: #333333"></span>
                <span data-color="#e6f0e6" data-id="2" style="background-color: #e6f0e6"></span>
                <span data-color="#e3f5fa" data-id="3" style="background-color: #e3f5fa"></span>
                <span data-color="#f5e9ef" data-id="4" style="background-color: #f5e9ef"></span>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="col-md-12" style="margin-bottom:10px">
            <label class="pull-left">Color: </label>
            <div class="set-color pull-right">
                <span data-color="#fff" data-id="0" style="backgroundcolor: #fff"></span>
                <span data-color="#333333" data-id="1" style="background-color: #333333"></span>
                <span data-color="#000" data-id="2" style="background-color: #000"></span>
                <span data-color="forestgreen" data-id="3" style="background-color: forestgreen"></span>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="col-md-12" style="margin-bottom:10px">
            <label class="pull-left">Font: </label>
            <div class="set-font pull-right">
                <select class="select-font" style="padding: 6px 4px;width: 218px;">
                    <option value="Arial" style="font-family: Arial">Arial</option>
                    <option value="Times New Roman" style="font-family: Times New Roman">Times New Roman</option>
                    <option value="CONSOLAS" style="font-family: CONSOLAS">Consolas</option>
                    <option value="INCONSOLATA" style="font-family: INCONSOLATA">Inconsolata</option>
                    <option value="Courier New" style="font-family: Courier New">Courier New</option>
                    <option value="Comic Sans MS" style="font-family: Comic Sans MS">Comic Sans MS</option>
                </select>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="col-md-12" style="margin-bottom:10px">
            <label class="pull-left">Font size: </label>
            <div class="set-font-size pull-right">
                <span class="set-slide_button set-smaller"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>
                <input type="text" name="read[size]" id="set-font-size" value="14px" readonly="readonly" style="padding: 3px 4px;width: 120px;">
                <span class="set-bigger set-slide_button"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
            </div>
            <div class="clearfix"></div>
        </div>
    </div><!-- end modal body -->
    <div class="modal-config-footer">
        <div class="col-md-12">
            <a href="javascript:closeConfig()" class="btn btn-sm btn-default pull-right" title="Close"><i class="fa fa-times-circle"></i></a>
            <button id="save-config" class="btn btn-sm btn-default pull-right" title="Save change"><i class="fa fa-save"></i></button>
            <button id="default-config" class="btn btn-sm btn-default pull-right" title="Default"><i class="fa fa-repeat"></i></button>
        </div>
    </div>
</div>

<script type="text/javascript">
    var minEp       = "<?php echo $minEp ?>";
    var maxEp       = "<?php echo $maxEp ?>";
    var currentEp   = "<?php echo $currentEp ?>";
    if( parseInt(currentEp) <= parseInt(minEp) ) {
        $("a.prev-chapter").attr("href", "javascript:void(0)").addClass("min-chapter");
    }
    if( parseInt(currentEp) >= parseInt(maxEp) ) {
        $("a.next-chapter").attr("href", "javascript:void(0)").addClass("max-chapter");
    }

    var fontConfig          = $("select.select-font").find(":selected").val();
    var backgroundConfig    = '#282828';
    var colorConfig         = "#ccc";
    var fontSizeConfig      = 14;
    //gan gia tri moi khi co session
    <?php if(isset($_SESSION["configReadBook"])){
            echo "fontConfig = '$fontConfig'" . ";";
            echo "backgroundConfig = '$backgroundConfig'". ";";
            echo "colorConfig = '$colorConfig'". ";";
            echo "fontSizeConfig = '$fontSizeConfig'". ";";
        }
    ?>

    var selectedFont = $("select.select-font").find(":selected").val();
    $("select.select-font").css("font-family", selectedFont);
    $("select.select-font").change(function(){
        fontConfig = $("select.select-font").find(":selected").val();
        $(this).css("font-family", fontConfig);
        $("blockquote.generate-chapter").css("font-family", fontConfig);
    });

    $("div.modal-config-body div.set-background-color span").click(function(){
        $("div.modal-config-body div.set-background-color span").css("border", "1px solid #ccc");
        $(this).css("border", "2px solid #fd3939");
        backgroundConfig = $(this).data("color");
        $("blockquote.generate-chapter").css("background-color", $(this).data("color") );
        // $("blockquote.generate-chapter").css("color", "black" );
    });
    $("div.modal-config-body div.set-color span").click(function(){
        $("div.modal-config-body div.set-color span").css("border", "1px solid #ccc");
        $(this).css("border", "2px solid #fd3939");
        colorConfig = $(this).data("color");
        $("blockquote.generate-chapter").css("color", colorConfig );
    });

    // FONT SIZE
    $("div.set-font-size span.set-bigger").click(function(){
        fontSizeConfig = $("input#set-font-size").val();
        fontSizeConfig = (parseInt(fontSizeConfig) + 1);
        $("input#set-font-size").val( fontSizeConfig + "px");
        $("blockquote.generate-chapter").css("font-size", fontSizeConfig + "px" );
    });
    $("div.set-font-size span.set-smaller").click(function(){
        fontSizeConfig = $("input#set-font-size").val();
        fontSizeConfig = (parseInt(fontSizeConfig) - 1);
        $("input#set-font-size").val(  fontSizeConfig + "px");
        $("blockquote.generate-chapter").css("font-size", fontSizeConfig + "px" );
    });

    //SAVE CHANGE
    $("button#save-config").click(function(){
        $.ajax({
            url     : '/LiarsStore/index.php?module=client&controller=index&action=saveChangeReadBook',
            dataType: 'html',
            type    : 'post',
            data    : {fontConfig: fontConfig, backgroundConfig: backgroundConfig, colorConfig: colorConfig, fontSizeConfig: fontSizeConfig},
            success : (data) =>{
                console.log(data);
            }
        })
    });
    //DEFAULT CHANGE
    $("button#default-config").click(function(){
        $("blockquote.generate-chapter").css({
            "font-family"         : "Arial",
            "background-color"    : "#282828",
            "color"               : "#ccc",
            "font-size"           : "14px"
        });
        $('select.select-font option[value="Arial"]').attr('selected', 'selected');
        $("input#set-font-size").val("14px");
        $("div.set-background-color").find("span").css("border", "1px solid #ccc");
        $("div.set-color").find("span").css("border", "1px solid #ccc");

        $.ajax({
            url     : '/LiarsStore/index.php?module=client&controller=index&action=defaultChangeReadBook',
            dataType: 'html',
            type    : 'post',
            success : (data) =>{
                console.log(data);
            }
        })
    });
    
</script>