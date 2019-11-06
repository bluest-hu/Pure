<?php $theme_info = wp_get_theme(); ?>
  <footer class="main-footer" id="main-footer">
    <div class="footer-content">
      Powered by <a href="https://wordpress.org/" title="code is poetry">WordPress</a><br>
      Theme <a href="<?php echo esc_html($theme_info->display('ThemeURI')); ?>"><?php echo esc_html($theme_info->display('Name')); ?></a>

      v<?php echo esc_html($theme_info->display('Version')); ?> by <?php echo $theme_info->display('Author'); ?>
      <br>
      <?php if (get_option('zh_cn_l10n_icp_num')) { ?>
        <a href="http://www.miitbeian.gov.cn" rel="nofollow"><?php echo esc_html(get_option('zh_cn_l10n_icp_num')); ?></a>
      <?php } ?>
    </div>
  </footer>

  <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
          // 防止爬虫在抓抓取的时候 sw 注册失败产生错误
          if (location.protocol !=== 'https' && 
            (location.hostname !== '127.0.0.1' || location.hostname !== 'localhost')) {
            return false;
          }

          const isLogin = (<?php echo is_user_logged_in() ? 'true' : 'false' ;?>);
          const serviceWorker = navigator.serviceWorker;

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
  <?php include(get_stylesheet_directory() .'/dist/footer_script.php'); ?>
  <?php
  if (is_single()) {
    if (get_option('pure_theme_single_ads_script') != '') {
      echo trim(stripslashes(get_option('pure_theme_single_ads_script')));
    }
  }
  ?>
  <!--total <?php echo esc_html(get_num_queries()); ?> query-->
  <?php wp_footer(); ?>
  </body>
</html>
