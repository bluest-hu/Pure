<?php
	$theme_info = wp_get_theme();
?>

<footer class="main-footer" id="main-footer">
	<div class="footer-content">
		Powered by <a href="https://wordpress.org/" title="code is poetry">WordPress</a><br>
		Theme <a href="<?php echo esc_html($theme_info->display('ThemeURI')); ?>"><?php echo esc_html($theme_info->display( 'Name' )); ?></a>

		v<?php echo esc_html($theme_info->display( 'Version' )); ?>

		by<?php echo esc_html($theme_info->display( 'Author' )); ?>
        <br>
    <?php if (get_option( 'zh_cn_l10n_icp_num' )){ ?>
        <a href="http://www.miitbeian.gov.cn" rel="nofollow"><?php echo esc_html(get_option( 'zh_cn_l10n_icp_num' ));?></a>
    <?php } ?>
	</div>
</footer>

<?php
if (is_single()) {
	wp_enqueue_script( 'pure-prism-js' );
}

wp_enqueue_script( 'pure-lazyload-js' );

wp_footer();
?>

<script>
	document.addEventListener('DOMContentLoaded', function () {
    	lazyload(document.querySelectorAll(".post-entry img"));
	}, false);

    // if ('serviceWorker' in navigator) {
    //     window.addEventListener('load', function() {
    //         navigator.serviceWorker.register('/wp-json/wp_theme_pure/v1/get_sw_js', {scope: '/'}).then(function(registration) {
    //             // Registration was successful
    //             console.log('ServiceWorker registration successful with scope: ', registration.scope);
    //         }).catch(function(err) {
    //             // registration failed :(
    //             console.log('ServiceWorker registration failed: ', err);
    //         });
    //     });
    // }
</script>

<?php

if (is_single()) {?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        Prism.highlightAll();
    }, false);
</script>
<?php
}
?>
</body>
<!--total <?php echo esc_html(get_num_queries()); ?> query-->
</html>
