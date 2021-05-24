<footer class="footer ">
    <div class="container">
        <div class="row">
            <nav class="nav-footer col-xs-12 col-sm-3 col-md-3 hidden-print">
                <?php wp_nav_menu( array(
                    'theme_location' => 'menu-footer',
                    'menu'            => '',
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'menu-footer',
                    'menu_id'         => '',
                    'echo'            => true,
                    'fallback_cb'     => 'wp_page_menu',
                    'before'          => '',
                    'after'           => '',
                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '<ul class="menu-footer">%3$s</ul>',
                    'depth'           => 0,
                    'walker'          => ''
                ) ); ?>
            </nav><!--/.nav-collapse -->
            <section class="news-footer col-xs-12 col-sm-5 col-md-5 hidden-print">
                <form id="newsletter-form">
                    <label for=""><?php _e('Receba Informações da ReINC:', 'natio-lang')?></label>
                    <input type="text" name="name" placeholder="<?php _e('Escreva seu nome', 'natio-lang'); ?>" class="input-news name"/>
                    <input type="email" name="email" placeholder="<?php _e('Escreva seu e-mail', 'natio-lang'); ?>" class="input-news email"/>
                    <input type="submit" class="btn-news" value="<?php _e('Enviar', 'natio-lang'); ?>"/>
                </form>
            </section>
            <!-- /.news-footer -->
            <address class="footer-address col-xs-12 col-sm-4 col-md-4">
                <p class="phone"><?php _e('Tel', 'natio-lang');?>: 21 2533. 3353 / 2510.6484 </p>
                <p>Secretaria Executiva REDETEC </p>
                <p><?php _e('End', 'natio-lang');?>: Avenida Beira Mar 406, Sala 1108 </p>
                <p><?php _e('Edifício', 'natio-lang');?> São Miguel, Centro</p>
                <p>Rio de Janeiro | RJ - CEP: 20.020-900</p>
            </address>

            <section class="copy">
                <div class="">
                    <div class="col-xs-12 col-sm-8 col-md-8">Copyright© <?php echo date('Y'); ?> ReINC - <?php _e('Rede de Agentes Promotores de Empreendimentos Inovadores', 'natio-lang'); ?></div>
                    <div class="developer col-xs-12 col-sm-4 col-md-4">
                        <?php _e('Desenvolvido por:', 'natio-lang'); ?> <strong><a href="http://www.natiocriativo.com/" target="_blank">natio criativo</a></strong>
                    </div>
                    <!-- /.developer -->
                </div>
                <!-- /.row -->
            </section>
            <a class="cd-top hidden-print" href="#0">
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </a>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</footer>
<!-- /.footer -->
<?php wp_footer(); ?>
</body>
</html>
