<?php
	$theme_info = wp_get_theme();
?>

<footer class="main-footer" id="main-footer">
	<div class="footer-content">
		Powered by <a href="https://wordpress.org/" title="code is poetry">WordPress</a><br>
		Theme <a href="<?php echo $theme_info->display('ThemeURI'); ?>"><?php echo $theme_info->display( 'Name' ); ?></a>

		v<?php echo $theme_info->display( 'Version' ); ?>

		by<?php echo $theme_info->display( 'Author' ); ?>
        <br>
    <?php if (get_option( 'zh_cn_l10n_icp_num' )){ ?>
        <a href="http://www.miitbeian.gov.cn" rel="nofollow"><?php echo get_option( 'zh_cn_l10n_icp_num' );?></a>
    <?php } ?>
	</div>
</footer>

<?php
if (is_single()) {
	wp_enqueue_script( 'pure-prism-js' );
}

wp_enqueue_script( 'pure-lazyload-js' );

wp_footer();
if (get_option('pure_theme_analytics') != '') {
	echo trim( stripslashes( get_option( 'pure_theme_analytics' ) ) );
}
?>

<script>
	document.addEventListener('DOMContentLoaded', function () {
    	lazyload(document.querySelectorAll(".post-entry img"));
	}, false);
</script>

<?php

if (is_single()) {

?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        Prism.highlightAll();
    }, false);
</script>
<?php
}
?>
</body>
</html>
