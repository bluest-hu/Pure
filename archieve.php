<?php

/**
 * Template Name: Archive Template
 */

?>

<?php get_header();?>


<div class="post-wrap content-width">
    <h1 class="post-title">404</h1>

	<?php wp_get_archives('type=monthly'); ?>

</div>



<?php get_footer();?>
