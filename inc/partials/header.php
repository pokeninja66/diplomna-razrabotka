<header>
    <nav id="navigation">
        <ul>
            <li><a href="/" title="Home"><i class="fas fa-home"></i></a></li>
            <?php foreach (Common::setMenuArr() as $name => $link) { ?>
                <li><a href="<?php echo $link; ?>"><?php echo $name; ?></a></li>
            <?php } ?>

        </ul>
    </nav>
</header>