<?php $theme_info = wp_get_theme(); ?>
  <footer class="main-footer" id="main-footer">
    <div class="footer-content">
      Powered by <a href="https://wordpress.org/"
                    title="code is poetry">WordPress</a><br>
     ♥︎ Theme <a href="<?php echo esc_html($theme_info->display('ThemeURI')); ?>"><?php echo esc_html($theme_info->display('Name')); ?></a>

      v<?php echo esc_html($theme_info->display('Version')); ?> by <?php echo $theme_info->display('Author'); ?>
      <br>
      <?php if (get_option('zh_cn_l10n_icp_num')) { ?>
        <a href="http://beian.miit.gov.cn" rel="nofollow"><?php echo esc_html(get_option('zh_cn_l10n_icp_num')); ?></a>
      <?php } ?>
    </div>
  </footer>

  <div class="sw-update-notice" id="swUpdateNotice">
    ☞ 站点内容发生了更新
    <br>
    请点击获取最新内容！
  </div>

  <input type="hidden"
         id="googleAnalyticsId"
         value="<?php echo get_option('pure_theme_google_analytics_id')?>" />
  <?php get_template_part('dist/footer_script'); ?>

  <script>
    const dom = document.getElementById('swUpdateNotice');

    if ('serviceWorker' in navigator) {
      dom.addEventListener('click', () => {
        try {
          dom.style.display = 'none';
          window.location.reload();
          navigator.serviceWorker.getRegistration().then(reg => {
            reg.waiting.postMessage("skipWaiting");
          });
        } catch (e) {
          window.location.reload();
        }
      })

      function showSWUpdateNotice() {
        if (dom) {
          dom.style.display = 'inline-block';
        }
      }

      window.addEventListener('load', function() {
        // 防止爬虫在抓抓取的时候 sw 注册失败产生错误
        if (location.protocol !== 'https:' &&
          (location.hostname !== '127.0.0.1' && location.hostname !== 'localhost')) {
          return false;
        }
        //  todo 这是有问题的
        const isLogin = (<?php echo is_user_logged_in() ? 'true' : 'false' ;?>);
        const serviceWorker = navigator.serviceWorker;

        serviceWorker.register('/wp-json/wp_theme_pure/v1/service-worker.js', {scope: '/'})
          .then(function(registration) {
              // console.log('ServiceWorker registration successful with scope: ', registration.scope);
              if (isLogin) {
                registration.unregister().then(function (flag) {
                  console.log('user is login, ServiceWorker unregister ' + (flag ? 'success' : 'fail'));
                });
              }

              // if (registration.waiting) {
              //   showSWUpdateNotice();
              //   return;
              // }

              // need update
              registration.addEventListener('updatefound', () => {
                const newWorker = registration.installing;

                newWorker.addEventListener('statechange', () => {
                  if (newWorker.state === 'installed') {
                    if (navigator.serviceWorker.controller) {
                      showSWUpdateNotice();
                    }
                  }
                });
            });
          }).catch(function(err) {
              console.log('ServiceWorker registration failed: ', err);
          });

        serviceWorker.addEventListener('controllerchange', function () {
          showSWUpdateNotice();
        });
      });
    }
  </script>
  <?php
  if (is_single()) {
    if (get_option('pure_theme_single_ads_script') != '') {
      echo trim(stripslashes(get_option('pure_theme_single_ads_script')));
    }
  }

  if (get_option('pure_theme_analytics') != '') {
    echo trim(stripslashes(get_option('pure_theme_analytics')));
  };
  ?>
  <?php wp_footer(); ?>
  </body>
</html>
<!--total <?php echo esc_html(get_num_queries()); ?> query-->
<!--using <?php echo esc_html(number_format(memory_get_peak_usage() / 1024 / 1024, 2, '.', '')); ?>MB memory-->
