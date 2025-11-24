<?php
/**
 * Template for Service archive but showing contents of fixed page "service"
 */

get_header();

// 固定ページ "service" を取得
$page = get_page_by_path( 'service' );

if ( $page ) :
    // 固定ページの内容を表示するため WP_Query を上書き
    setup_postdata( $page );
    ?>

    <div id="primary" <?php astra_primary_class(); ?>>

        <?php astra_primary_content_top(); ?>

        <article id="post-<?php echo $page->ID; ?>" <?php post_class(); ?>>
            <div class="entry-content">
                <?php echo apply_filters( 'the_content', $page->post_content ); ?>
            </div>
        </article>

        <?php astra_primary_content_bottom(); ?>

    </div>

<?php else : ?>

    <p>固定ページ「サービス」が見つかりません。</p>

<?php endif;

get_footer();
