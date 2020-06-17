<!---------NEWS 最新情報----------
NEWS 最新情報
使用例
wp-content/themes/x-corporate/includes/module/hero.php:123
-------------------------------->

<?php
/** 投稿カテゴリーのスラッグが[news]のものを3件取得 */
$news_posts = get_posts(
    array(
        'posts_per_page' => 3,      // 表示件数
        'category_name'  => 'news', // カテゴリIDもしくはスラッグ名
    )
);
?>

<?php if($news_posts): foreach($news_posts as $post): setup_postdata($post); ?>
    <li class="hero-news__item">
        <a href="<?php the_permalink() ?>">
            <?php the_time('Y.m.d'); ?>
            <?php the_title(); ?>
        </a>
    </li>
<?php endforeach; endif; ?>
