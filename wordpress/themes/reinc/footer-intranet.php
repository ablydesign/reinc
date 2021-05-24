<div id="download-overlay" class="download-container" style="display: none;">
    <div class="download-content">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/loading.gif" />
        <h2><?php _e('Aguarde...', 'natio-lang'); ?></h2>
        <h3><?php _e('Gerando a Planilha para Download', 'natio-lang'); ?></h3>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div>
                <div class="col-xs-6 pull-left intranet-infor">
                    <div class="footer-intranet-infor">
                        <strong>ReINC</strong> <span>Intranet</span>
                    </div>
                </div>
                <div class="col-xs-6 pull-right footer-menu">
                    <?php wp_nav_menu( array( 'theme_location' => 'menu-intranet') ); ?>
                </div>
            </div>
            <section class="copy">
                <div class="">
                    <div class="col-xs-12 col-sm-8 col-md-8">Copyright© <?php echo date('Y'); ?> ReINC - Rede de Agentes Promotores de Empreendimentos Inovadores</div>
                    <div class="developer col-xs-12 col-sm-4 col-md-4">
                        <?php _e('Desenvolvido por:', 'natio-lang'); ?> <strong><a href="http://www.natiocriativo.com/" target="_blank">natio criativo</a></strong>
                    </div>
                    <!-- /.developer -->
                </div>
                <!-- /.row -->
            </section>
        </div><!-- /.row -->
    </div><!-- /.container -->
</footer>
<!-- /.footer -->
<?php wp_footer(); ?>
</body>
</html>
