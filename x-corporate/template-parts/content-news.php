<!---------NEWS 最新情報----------
NEWS 最新情報
使用例
wp-content/themes/x-corporate/includes/module/hero.php:123
-------------------------------->

<li class="hero-news__item">
    <p>
        <span>
            <?php if ( 'post' === get_post_type() ) x_corporate_posted_on(); ?>
        </span>
        <?php the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); ?>
    </p>
</li>