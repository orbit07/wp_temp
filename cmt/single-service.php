<?php
get_header();
?>
<div class="container two-column">
    <div>
        <?php get_template_part( 'template-parts/common/breadcrumb' ); ?>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="featured-image"><?php the_post_thumbnail( 'large' ); ?></div>
                    <?php endif; ?>
                </header>
                <div class="entry-content"><?php the_content(); ?></div>

                <section class="service-meta">
                    <div>
                        <h3><?php esc_html_e( '導入メリット', 'custom-media' ); ?></h3>
                        <p><?php echo wp_kses_post( get_post_meta( get_the_ID(), 'benefits', true ) ?: __( 'サービスの導入メリットをここに記載します。', 'custom-media' ) ); ?></p>
                    </div>
                    <div>
                        <h3><?php esc_html_e( '支援プロセス', 'custom-media' ); ?></h3>
                        <p><?php echo wp_kses_post( get_post_meta( get_the_ID(), 'process', true ) ?: __( '支援プロセスの概要をここに記載します。', 'custom-media' ) ); ?></p>
                    </div>
                </section>

                <section class="related-cases">
                    <h3><?php esc_html_e( '関連事例', 'custom-media' ); ?></h3>
                    <div class="grid cards">
                        <?php
                        $related = custom_media_related_cases( get_the_ID() );
                        if ( $related->have_posts() ) :
                            while ( $related->have_posts() ) :
                                $related->the_post();
                                ?>
                                <article class="card">
                                    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium' ); } ?>
                                    <div class="card-body">
                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <p><?php echo esc_html( get_the_excerpt() ); ?></p>
                                    </div>
                                </article>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p>' . esc_html__( '関連事例がありません。', 'custom-media' ) . '</p>';
                        endif;
                        ?>
                    </div>
                </section>

                <?php custom_media_render_cta_buttons(); ?>
            </article>
        <?php endwhile; endif; ?>
    </div>
    <?php get_template_part( 'template-parts/common/sidebar' ); ?>
</div>
<?php get_footer(); ?>
