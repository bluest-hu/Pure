<?php
$theme_info = wp_get_theme();
?>

<footer class="main-footer" id="main-footer">
  <div class="footer-content">
    Powered by <a href="https://wordpress.org/" title="code is poetry">WordPress</a><br>
    Theme <a href="<?php echo esc_html($theme_info->display('ThemeURI')); ?>"><?php echo esc_html($theme_info->display('Name')); ?></a>

    v<?php echo esc_html($theme_info->display('Version')); ?>

    by <?php echo $theme_info->display('Author'); ?>
    <br>
    <?php if (get_option('zh_cn_l10n_icp_num')) { ?>
      <a href="http://www.miitbeian.gov.cn" rel="nofollow"><?php echo esc_html(get_option('zh_cn_l10n_icp_num')); ?></a>
    <?php } ?>
  </div>
</footer>

<?php
wp_footer();
?>

<script>
  if ('serviceWorker' in navigator) {
      window.addEventListener('load', function() {
        const isLogin = <?php echo is_user_logged_in() ? 'true' : 'false' ;?>;
        const serviceWorker = navigator.serviceWorker
        
        serviceWorker.register('/wp-json/wp_theme_pure/v1/service-worker.js', {scope: '/'})
        .then(function(registration) {
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
            if (isLogin) {
              registration.unregister().then(function (flag) {
                console.log('user is login, ServiceWorker unregister ' + (flag ? 'success' : 'fail'));
              });
            }
        }).catch(function(err) {
            console.log('ServiceWorker registration failed: ', err);
        });
      });
  }
</script>

<script src="<%= htmlWebpackPlugin.files.js %>"></script>
<?php
if (is_single()) {
}
?>
</body>
<!--total <?php echo esc_html(get_num_queries()); ?> query-->
</html>
