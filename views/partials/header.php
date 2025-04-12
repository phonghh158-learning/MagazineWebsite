<?php use Helper\DateTimeAsia; ?>
<?php $d = DateTimeAsia::now()->format("F j, Y"); ?>

<header>
    <div class="header-information">
        <span class="item">Magazine</span>
        <span class="item">Website Exclusive</span>
        <span class="item">
            <span><?= $d ?></span>
        </span>
    </div>
    <span class="logo">FARRE VIRTOUSO</span>
</header>