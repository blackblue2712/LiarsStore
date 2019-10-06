<?php
    //PATH
    define("DS"                     , DIRECTORY_SEPARATOR);
    define("PATH_ROOT"              , dirname(__FILE__));

    define("PATH_LIBS"              , PATH_ROOT . DS . 'libs');
    define("PATH_PUBLIC"            , PATH_ROOT . DS . 'public');
    define("PATH_EXTENDS"           , PATH_LIBS . DS . "extends");
    define("PATH_APPLICATION"       , PATH_ROOT . DS . 'application');
    define("PATH_MODULE"            , PATH_APPLICATION . DS . 'module');
    define("PATH_TEMPLATE"          , PATH_PUBLIC . DS . 'template');
    define("PATH_FILES"             , PATH_PUBLIC . DS . 'files');
    define("PATH_PICTURE_CATEGORY"  , PATH_FILES . DS . 'category');
    define("PATH_PICTURE_USER"      , PATH_FILES . DS . 'user');
    define("PATH_PICTURE_BOOK"      , PATH_FILES . DS . 'book');

    //URL
    define("URL_ROOT"               , DS . "LiarsStore");
    define("URL_PUBLIC"             , URL_ROOT . DS . "public");

    define("URL_TEMPLATE"           , URL_PUBLIC . DS . "template");
    define("URL_FILES"              , URL_PUBLIC . DS . "files");
    define("URL_PICTURE_CATEGORY"   , URL_FILES . DS . "category");
    define("URL_PICTURE_BOOK"       , URL_FILES . DS . "book");
    define("URL_PICTURE_USER"       , URL_FILES . DS . "user");
    define("URL_IMAGE_PUBLIC"       , URL_TEMPLATE . DS . "admin" . DS . "main" . DS . "img");


    //URL REDIRECT HOME PAGE
    define("URL_HOME_PAGE"          , "/LiarsStore/index.html");



    //DEFAULT ARRAY PARAMS
    define("DEFAULT_MODULE"         , "client");
    define("DEFAULT_CONTROLLER"     , "index");
    define("DEFAULT_ACTION"         , "index");


    //DATABASE
    define("DB_HOST"                , "localhost");
    define("DB_USER"                , "root");
    define("DB_PASSWORD"            , "");
    define("DB_NAME"                , "larsgallery");
    define("DB_TABLE"               , "users");

    //PAGING
    define("TOTAL_ITEM_PER_PAGE"    , 5);
    define("PAGE_RANGE"             , 3);

    //SIZE IMAGE
    define("RESIZE_60x90"           , "60x90");
    define("RESIZE_98x150"          , "98x150");
    define("RESIZE_DEFAULT_60x90"   , "60x90-default.png");
    define("RESIZE_DEFAULT_98x150"  , "98x150-default.png");

    //FACEBOOK
    define("APP_SECRET", "e48beebeb353adbedea5cbfcf0fcb0cb");
    define("APP_ID", "2193977410815932");

    //EMAIL
    define("EMAIL_SENT", "nghiab1706729@student.ctu.edu.vn");
    define("PASSWORD", "9Hj6@hq2");