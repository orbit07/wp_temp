<?php
/**
 * Simple breadcrumb placeholder compatible with Yoast output.
 */
?>
<nav class="breadcrumb" aria-label="Breadcrumb">
    <?php if ( function_exists( 'yoast_breadcrumb' ) ) : ?>
        <?php yoast_breadcrumb(); ?>
    <?php else : ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'custom-media' ); ?></a>
        <span aria-hidden="true"> / </span>
        <span><?php the_title(); ?></span>
    <?php endif; ?>
</nav>
