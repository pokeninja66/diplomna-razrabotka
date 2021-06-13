<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $page_description; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <base href="./">

    <!-- css -->
    <link rel="stylesheet" href="./public/css/reset.css">
    <link rel="stylesheet" href="./public/css/main.css">
    <link href="./public/css/font-awsome.css" rel="stylesheet">
    <?php
    if ($page_extra_css != '') { ?>
        <link rel="stylesheet" href="./public/css/<?php echo $page_extra_css; ?>.css">
    <?php } ?>
    <!-- add VUE -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
</head>