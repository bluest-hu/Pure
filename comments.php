/**
 * Created by PhpStorm.
 * User: huguowei
 * Date: 2018/2/28
 * Time: 17:18
 */


 <div class="comment">
    <?php
    if ( comments_open() || get_comments_number() ) {
        comments_template();
    }
    ;?>
</div>