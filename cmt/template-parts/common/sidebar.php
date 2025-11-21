<?php
/**
 * Sidebar with popular posts, related documents, CTA, and optional banner.
 */
?>
<aside class="sidebar" aria-label="Sidebar">
    <div class="widget popular-posts">
        <h3 class="widget-title"><?php esc_html_e( '人気記事', 'custom-media' ); ?></h3>
        <ul>
            <?php
            $popular = new WP_Query( [
                'post_type'      => 'post',
                'posts_per_page' => 5,
                'orderby'        => 'comment_count',
            ] );
            if ( $popular->have_posts() ) :
                while ( $popular->have_posts() ) :
                    $popular->the_post();
                    ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php
                endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </ul>
    </div>

    <div class="widget related-docs">
        <h3 class="widget-title"><?php esc_html_e( '関連資料', 'custom-media' ); ?></h3>
        <ul>
            <?php
            $documents = new WP_Query( [
                'post_type'      => 'document',
                'posts_per_page' => 3,
            ] );
            if ( $documents->have_posts() ) :
                while ( $documents->have_posts() ) :
                    $documents->the_post();
                    ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php
                endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </ul>
    </div>

    <div class="widget sidebar-cta">
        <h3 class="widget-title"><?php esc_html_e( '資料DL / 問い合わせ', 'custom-media' ); ?></h3>
        <a class="button" href="#cta-document"><?php esc_html_e( '資料DL', 'custom-media' ); ?></a>
        <a class="button secondary" href="#cta-contact"><?php esc_html_e( '問い合わせ', 'custom-media' ); ?></a>
    </div>

    <?php
    $show = get_field( 'sidebar_banner_show' );
    $img  = get_field( 'sidebar_banner_img' );
    $link = get_field( 'sidebar_banner_link' );

    if ( $show && $img ) :
        ?>
        <div class="sidebar-bnr">
            <a href="<?php echo esc_url( $link ); ?>">
                <img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ?? '' ); ?>" />
            </a>
        </div>
    <?php endif; ?>
</aside>
