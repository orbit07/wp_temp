<?php get_header(); ?>
<div class="container two-column">
    <div>
        <?php get_template_part( 'template-parts/common/breadcrumb' ); ?>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="event-meta">
                        <div>
                            <strong><?php esc_html_e( '開催日時', 'custom-media' ); ?>:</strong>
                            <span><?php echo esc_html( get_post_meta( get_the_ID(), 'event_date', true ) ?: __( '未設定', 'custom-media' ) ); ?></span>
                        </div>
                        <div>
                            <strong><?php esc_html_e( '登壇者', 'custom-media' ); ?>:</strong>
                            <span><?php echo esc_html( get_post_meta( get_the_ID(), 'event_speakers', true ) ?: __( '調整中', 'custom-media' ) ); ?></span>
                        </div>
                    </div>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="featured-image"><?php the_post_thumbnail( 'large' ); ?></div>
                    <?php endif; ?>
                </header>

                <div class="entry-content"><?php the_content(); ?></div>

                <section class="cta-block">
                    <h3><?php esc_html_e( '申込フォーム', 'custom-media' ); ?></h3>
                    <?php echo wp_kses_post( get_post_meta( get_the_ID(), 'event_form_embed', true ) ?: __( '外部フォームをここに埋め込みます。', 'custom-media' ) ); ?>
                </section>

                <section class="cta-block">
                    <h3><?php esc_html_e( '過去動画はこちら', 'custom-media' ); ?></h3>
                    <p><?php esc_html_e( '過去セミナーのアーカイブ動画を視聴できます。', 'custom-media' ); ?></p>
                    <a class="button" href="<?php echo esc_url( get_post_meta( get_the_ID(), 'event_past_movie', true ) ?: '#' ); ?>"><?php esc_html_e( '動画を見る', 'custom-media' ); ?></a>
                </section>

                <?php custom_media_render_cta_buttons(); ?>
            </article>
        <?php endwhile; endif; ?>
    </div>
    <?php get_template_part( 'template-parts/common/sidebar' ); ?>
</div>
<?php get_footer(); ?>
