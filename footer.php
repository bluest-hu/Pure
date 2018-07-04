<?php
	$theme_info = wp_get_theme();
?>

<footer class="main-footer" id="main-footer">
	<div class="footer-content">
		Powered by <a href="https://wordpress.org/" title="code is poetry">WordPress</a><br>
		Theme <a href="<?php echo $theme_info->display('ThemeURI'); ?>"><?php echo $theme_info->display( 'Name' ); ?></a>

		v<?php echo $theme_info->display( 'Version' ); ?>

		by<?php echo $theme_info->display( 'Author' ); ?>
	</div>
</footer>

<?php
wp_enqueue_script( 'pure-jquery' );
wp_enqueue_script( 'pure-prism-js' );
wp_enqueue_script( 'pure-lazyload-js' );

wp_footer();
if (get_option('pure_theme_analytics') != '') {
	echo trim( stripslashes( get_option( 'pure_theme_analytics' ) ) );
}
?>

<script>
    jQuery(function () {
        Prism.highlightAll();
        jQuery(".post img").lazyload();

        //var $BgImage = $("#customHeaderBackgroundImage");
        //var bgImageWidth = <?php //echo get_custom_header()->width ;?>//;
        //var $Body = $("body");
        //var wiewPortWidth = $Body.width();
        //var justfy = function () {
        //}
    });
</script>

</body>
</html>