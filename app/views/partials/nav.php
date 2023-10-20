<?php 

$cartItemsNumber = isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : 0;

ob_start(); ?>
<li class="nav__menu__item nav__menu__item--icon-text">
    <a href="<?=ROOT?>user/signout"><i class="fa-solid fa-arrow-right-from-bracket"></i><span>Sign out</span></a>
</li>
<li class="nav__menu__item nav__menu__item--icon-text">
    <a href="<?=ROOT?>user/info"><i class="fa-regular fa-address-card"></i><span>My info</span></a>
</li>
<li class="nav__menu__item nav__menu__item--icon-text">
    <a href="<?=ROOT?>user/orders"><i class="fa-solid fa-sack-dollar"></i><span>My orders</span></a>
</li>
<li class="nav__menu__item">
    <!-- TODO: admin only -->
    <a href="<?=ROOT?>products/add">(Admin) Add a product</a>
</li>
<?php $userSignedInMenu = ob_get_clean();

ob_start(); ?>
<li class="nav__menu__item nav__menu__item--icon-text">
    <a href="<?=ROOT?>user/signin"><i class="fa-solid fa-arrow-right-to-bracket"></i><span>Sign in</span></a>
</li>
<li class="nav__menu__item nav__menu__item--icon-text">
    <a href="<?=ROOT?>user/signup"><i class="fa-solid fa-user-plus"></i><span>Sign up</span></a>
</li>
<?php $userSignedOutMenu = ob_get_clean();

$userMenu = isset($_SESSION["userId"]) ? $userSignedInMenu : $userSignedOutMenu;

?>

<nav class="nav">
   <ul id="nav-pages-menu" class="nav__menu">
        <li class="nav__menu__item">
            <a href="<?=ROOT?>"><i class="fa fa-home"></i></a>
        </li>
        <li id="nav-shop-item" class="nav__menu__item nav__menu__item__parent">
            <a href="<?=ROOT?>products">Shop</a>
            <div class="nav__submenu">
                <ul id="nav-shop-submenu" class="nav__submenu__list">
                    <li class="nav__menu__item">
                        <a href="<?=ROOT?>products/books">Books</a>
                    </li>
                    <li class="nav__menu__item">
                        <a href="<?=ROOT?>products/protection">Protection</a>
                    </li>
                    <li class="nav__menu__item">
                        <a href="<?=ROOT?>products/shoes">Shoes</a>
                    </li>
                    <li class="nav__menu__item">
                        <a href="<?=ROOT?>products/vehicles">Vehicles</a>
                    </li>
                    <li class="nav__menu__item">
                        <a href="<?=ROOT?>products/weapons">Weapons</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav__menu__item">
            <a href="<?=ROOT?>pages/about">About</a>
        </li>
        <li class="nav__menu__item">
            <a href="<?=ROOT?>pages/contact">Contact us</a>
        </li>
    </ul>
    <ul id="nav-user-menu" class="nav__menu">
        <li id="nav-cart-item" class="nav__menu__item">
            <a href="<?=ROOT?>cart"><i class="fa-solid fa-cart-shopping"></i><?=$cartItemsNumber !== 0 ? " ($cartItemsNumber)" : null ?></a>
        </li>
        <li class="nav__menu__item  nav__menu__item__parent">
            <a href="#"><i class="fa-solid fa-user"></i></a>
            <div class="nav__submenu">
                <ul id="nav-user-submenu" class="nav__submenu__list">
                    <?= $userMenu ?>
                </ul>
            </div>
        </li>

    </ul>
</nav>