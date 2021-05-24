<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

    <link href="//www.google-analytics.com" rel="dns-prefetch">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
    <!--[if lte IE 8]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">

    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href="<?php echo get_template_directory_uri(); ?>/assets/css/intranet.css" rel='stylesheet' type='text/css'>

    <?php wp_head(); ?>
    <?php global $current_user; ?>
    <?php get_currentuserinfo(); ?>
</head>
<body <?php body_class('page-intranet'); ?> data-theme="<?php bloginfo('template_url'); ?>">
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<header class="header navbar">
    <div class="intranet-bar">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 pull-left intranet-infor">
                    <div>
                        <strong>ReINC</strong> <span>Intranet</span>
                    </div>
                </div>
                <div class="col-xs-6 pull-right loggin-infor">
                    <div>
                        <i class="fa fa-"></i> Olá, <strong><?php echo $current_user->display_name; ?></strong>
                    </div>
                    <div>
                        <a href="<?php echo wp_logout_url( home_url() ); ?>">Sair</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="center-align">
                <a class="navbar-brand" href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php bloginfo('name');?>" /></a>
            </div>
            <nav class="container-navigation">
                <?php wp_nav_menu( array( 'theme_location' => 'menu-intranet', 'items_wrap' => '<ul class="nav navbar-nav">%3$s</ul>' )); ?>
            </nav>
        </div>
    </div>
</header>
