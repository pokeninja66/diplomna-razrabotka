<?php
#
$_HAS_PAGE_ACCESS = true;
require "./config.php";

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Diplomna</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <base href="./">

    <!-- css -->
    <link rel="stylesheet" href="./public/css/reset.css">
    <link rel="stylesheet" href="./public/css/main.css">
    <!-- add VUE -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

</head>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div id="app">

        <header>
            <nav id="navigation">
                <ul>
                    <li><a href="/">Home</a></li>
                    <?php foreach (Common::setMenuArr() as $name => $link) { ?>
                        <li><a href="<?php echo $link; ?>"><?php echo $name; ?></a></li>
                    <?php } ?>
                
                </ul>
            </nav>
        </header>

        <div class="main-content">
            <pre>
                <?php print_r($_SESSION); ?>
            </pre>
        </div>

    </div>

    <script src="./public/scripts/main.js" async defer></script>
</body>

</html>