<?php

//$brand = app()->name;
$urls  = app()->urls;
$navItems = array(
    array('label'=>'Home',      'url'=>$urls->get('homePage')),
    array('label'=>'Profile',   'url'=>$urls->get('profilePage')),
    array('label'=>'About',     'url'=>$urls->get('aboutPage')),
    array('label'=>'Contact',   'url'=>$urls->get('contactPage')),
    array('label'=>'Login',     'url'=>$urls->get('loginPage'), 'visible'=> !logged_in()),
    array('label'=>'Sign Up',   'url'=>$urls->get('signupPage'), 'visible'=> !logged_in()),
    array('label'=>'Services',  'url'=>$urls->get('serviceListingPage')),
    array('label'=>'Logout ('.user()->name.')', 'url'=>$urls->get('logout'), 'visible'=>logged_in())
);
$theme = app()->theme;
?>

<div class="navbar navbar-static-top hidden-desktop">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a href="<?php echo $urls->get('homePage') ?>" class="brand">
                <img style="width: 50px" src="<?php echo $theme->getPubUrl('img/logo_small.png') ?>"/>
            </a>
            <div class="nav-collapse">
                <ul id="nav-list" class="nav">
                    <?php foreach($navItems as $navItem) { ?>
                        <?php if(isset($navItem['visible']) && !$navItem['visible']) continue; ?>
                        <li>
                            <a href="<?php echo $navItem['url'] ?>"><?php echo $navItem['label'] ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container visible-desktop" >

    <div class="logobg" >
        <img class="logobg-img" src="<?php echo $theme->getPubUrl('img/bg_logo.png') ?>" />
    </div>
    <div class="logo"><img src="<?php echo $theme->getPubUrl('img/logo.png') ?>" /></div>

    <div class="row signin">
        <?php if(!logged_in()) { ?>
        <form class="offset4">
            <table cellpadding="0" cellspacing="0" class="signintable">
                <tr>
                    <td valign="top">
                        <input type="text" placeholder="Username" class="headerusername" /><br />
                        <input type="checkbox" class="headerrememberme" /> Keep me signed in</td>
                    <td valign="top" style="padding-left:12px;padding-right:12px;">
                        <input type="password" placeholder="Password" class="headerpassword" /><br />
                        <a href="#">Forgot password?</a>
                    </td>
                    <td valign="top"><input type="image" class="headersignin" src="<?php echo $theme->getPubUrl('img/btn_signin.png') ?>" /></td>
                </tr>
            </table>
        </form>
        <?php } ?>
    </div>

    <div class="row-fluid mainNav">

        <div class="pilotNav span3 offset2">
            <a href="#"><img class="background" src="<?php echo $theme->getPubUrl('img/nav_pilot.png') ?>" /></a>
        </div>
        <div class="airlineNav span3">
            <img class="background" src="<?php echo $theme->getPubUrl('img/nav_airlines_on.png') ?>" />
        </div>
        <div class="globalnav span4">
            <a href="<?php echo $urls->get('homePage') ?>">Home</a>&nbsp;&nbsp;<span style="font-size:15px;">//</span>&nbsp;
            <a href="#">About</a>&nbsp;&nbsp;<span style="font-size:15px;">//</span>&nbsp;
            <a href="#">Blog</a>&nbsp;&nbsp;<span style="font-size:15px;">//</span>&nbsp;
            <a href="#">Contact</a>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="row-fluid mainNav">
        
    </div>
</div>
