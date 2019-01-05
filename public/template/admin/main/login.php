<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title> <?php echo $this->_title ?> </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php echo $this->_fileCss ?>
    </head>
    <body class="bg-black">
        <?php include_once $this->_fileView; ?>

        <?php echo $this->_fileJs ?>
    </body>
</html>