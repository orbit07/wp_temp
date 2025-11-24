<?php
/**
 * Template for Service archive but showing contents of fixed page "service"
 */

get_header();

// 固定ページ "service" を取得
$page = get_page_by_path( 'service' );

// WP_Post が見つからない場合のフォールバック
if ( ! $page instanceof WP_Post ) {
    echo '<p>固定ページ「サービス」が見つかりません。</p>';
    get_footer();
    exit;
}

// WordPress のループ環境を固定ページに差し替え
$GLOBALS['post'] = $page;
setup_postdata( $page );
?>

<div id="primary" <?php astra_primary_class(); ?>>

    <?php astra_primary_content_top(); ?>

    <article>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </article>

    <?php astra_primary_content_bottom(); ?>

</div>

<?php
wp_reset_postdata();
get_footer();
