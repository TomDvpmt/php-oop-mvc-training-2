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
                        <a href="<?=ROOT?>products/vehicules">Vehicules</a>
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
            <a href="<?=ROOT?>cart"><i class="fa-solid fa-cart-shopping"></i></a>
        </li>
        <li class="nav__menu__item  nav__menu__item__parent">
            <a href="#"><i class="fa-solid fa-user"></i></a>
            <div class="nav__submenu">
                <ul id="nav-user-submenu" class="nav__submenu__list">
                    <li class="nav__menu__item nav__menu__item--icon-text">
                        <a href="<?=ROOT?>user?action=login"><i class="fa-solid fa-arrow-right-to-bracket"></i><span>Sign in</span></a>
                    </li>
                    <li class="nav__menu__item nav__menu__item--icon-text">
                        <a href="<?=ROOT?>user?action=register"><i class="fa-solid fa-user-plus"></i></i><span>Sign up</span></a>
                    </li> 
                    <li class="nav__menu__item">
                        <a href="<?=ROOT?>products?action=add">Add a product</a>
                    </li>
                </ul>
            </div>
        </li>

    </ul>
</nav>