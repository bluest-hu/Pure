<?php $theme_info = wp_get_theme(); ?>
<footer class="main-footer" id="main-footer">
  <div class="footer-content">
    Powered by <a href="https://wordpress.org/"
                  title="code is poetry">WordPress</a><br>
    ♥︎ Theme <a
      href="<?php echo esc_html( $theme_info->display( 'ThemeURI' ) ); ?>"><?php echo esc_html( $theme_info->display( 'Name' ) ); ?></a>

    v<?php echo esc_html( $theme_info->display( 'Version' ) ); ?> by <?php echo $theme_info->display( 'Author' ); ?>
    <br>
    <?php if ( get_option( 'zh_cn_l10n_icp_num' ) ) { ?>
      <a href="http://beian.miit.gov.cn"
         rel="nofollow"><?php echo esc_html( get_option( 'zh_cn_l10n_icp_num' ) ); ?></a>
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
       value="<?php echo get_option( 'pure_theme_google_analytics_id' ) ?>"/>
<?php
// 如果是 AMP 不加载 JavaScript
if ( theme_pure_is_amp() ) {
  return false;
}

get_template_part( 'dist/footer_script' );
get_template_part( 'inc/sw.php' );

if ( is_single() ) {
  if ( get_option( 'pure_theme_single_ads_script' ) != '' ) {
    echo trim( stripslashes( get_option( 'pure_theme_single_ads_script' ) ) );
  }
}

if ( get_option( 'pure_theme_analytics' ) != '' ) {
  echo trim( stripslashes( get_option( 'pure_theme_analytics' ) ) );
};

wp_footer();
?>
</body>
</html>
<!--total <?php echo esc_html( get_num_queries() ); ?> query-->
<!--using <?php echo esc_html( number_format( memory_get_peak_usage() / 1024 / 1024, 2, '.', '' ) ); ?>MB memory-->
