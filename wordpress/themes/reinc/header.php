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
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <?php wp_head(); ?>
    <?php global $post; ?>
</head>
<body <?php body_class('all-pages '); ?> data-theme="<?php bloginfo('template_url'); ?>">
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<header class="header navbar">
    <div class="container">
        <div class="header-login">
            <a class="btn-link" href="<?php echo get_page_link(1037); ?>"><?php _e('Acessar Intranet', 'natio-lang'); ?></a>
        </div>
        <a class="navbar-brand" href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php bloginfo('name');?>" /></a>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            Menu
            </button>
            <div class="toggle-lang">
                <nav class="">
                    <a class="pt-br <?php the_action_lang('pt_BR'); ?>" rel="pt-BR" href="<?php if($post->post_type == 'page'): echo get_bloginfo('home')."/?page_id=".$post->ID."&lang=pt-BR" ; else: echo "?lang=pt-BR"; endif; ?>" tabindex="0" title="Veja o site em Portugu??s" ><span>POR</span></a>
                    <a class="en <?php the_action_lang('en_US'); ?>" rel="EN" href="<?php if($post->post_type == 'page'): echo get_bloginfo('home')."/?page_id=".$post->ID."&lang=en" ; else: echo "?lang=en"; endif; ?>" tabindex="0"  title="Veja o site em Ingl??s" ><span>ENG</span></a>
                </nav>
            </div>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <?php wp_reset_postdata(); ?>
            <?php wp_nav_menu( array(
                'theme_location' => 'menu-header',
                'menu_class'      => 'menu',
                'echo'            => true,
                'items_wrap'      => '<ul class="nav navbar-nav">%3$s</ul>',
            ) ); ?>
            <?php wp_reset_postdata(); ?>
        </div><!--/.nav-collapse -->
        <!-- /.search-form -->
    </div><!--/.nav-collapse -->
</header>
<section class="all-search hidden-print">
    <div class="container">
        <div class="row">
            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="all-form col-xs-12 col-sm-12 col-md-12 ">
                    <input type="text" class="input-text-site" placeholder="<?php _e('O que podemos ajud??-lo a encontrar?', 'natio-lang'); ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" />
                    <div class="btn-search-group">
                        <button type="submit" class="btn-search" >
                            <i class="fa fa-search"></i>
                        </button>
                        <!-- <input type="submit" id="searchsubmit" class="btn-search" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" /> -->
                    </div>
                    <!-- /.btn-search-group -->
                </div>
                <!-- /.all-form -->
            </form>
        </div>
    </div>
    <!-- /.container -->
</section>
<!-- /.all-search -->
