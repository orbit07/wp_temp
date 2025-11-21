<?php
/*
Template Name: Recruit Page
*/
get_header();
?>
<div class="container">
    <?php get_template_part( 'template-parts/common/breadcrumb' ); ?>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
            <div class="entry-content">
                <section class="cta-block">
                    <h3><?php esc_html_e( '企業メッセージ', 'custom-media' ); ?></h3>
                    <p><?php echo wp_kses_post( get_post_meta( get_the_ID(), 'recruit_message', true ) ?: __( '企業メッセージをここに入力してください。', 'custom-media' ) ); ?></p>
                </section>

                <section class="recruit-positions">
                    <h3><?php esc_html_e( '募集職種', 'custom-media' ); ?></h3>
                    <?php
                    $positions = get_post_meta( get_the_ID(), 'recruit_positions', true );
                    if ( is_array( $positions ) && ! empty( $positions ) ) :
                        foreach ( $positions as $position ) :
                            ?>
                            <div class="position">
                                <strong><?php echo esc_html( $position['title'] ?? '' ); ?></strong>
                                <p><?php echo esc_html( $position['description'] ?? '' ); ?></p>
                            </div>
                            <?php
                        endforeach;
                    else :
                        ?>
                        <div class="position">
                            <strong><?php esc_html_e( '職種名', 'custom-media' ); ?></strong>
                            <p><?php esc_html_e( '募集職種の概要をここに記載します。', 'custom-media' ); ?></p>
                        </div>
                    <?php endif; ?>
                </section>

                <section class="cta-block">
                    <h3><?php esc_html_e( '外部ATSへのリンク', 'custom-media' ); ?></h3>
                    <a class="button" href="<?php echo esc_url( get_post_meta( get_the_ID(), 'recruit_ats_url', true ) ?: '#' ); ?>"><?php esc_html_e( '応募する', 'custom-media' ); ?></a>
                </section>
            </div>
        </article>
    <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
