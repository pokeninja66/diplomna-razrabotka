<header>
    <?php if ($_SESSION['User']) { ?>
        <span class="user">Current User: <?php echo $_SESSION['User']->username ?></span>
    <?php } ?>
    <nav id="navigation">
        <ul>
            <li><a href="/" ><i title="Home" class="fas fa-home"></i></a></li>
            <?php foreach (Common::setMenuArr() as $name => $link) { ?>
                <li><a href="<?php echo $link; ?>"><?php echo $name; ?></a></li>
            <?php } ?>

        </ul>
    </nav>
</header>