<?php
get_header();
?>
<?php
if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        $selected = get_field( 'layout_type' );
        $layout   = $selected ?: custom_media_default_layout( get_post_type() );

        if ( 'two' === $layout ) {
            get_template_part( 'template-parts/layout/layout-2column' );
        } else {
            get_template_part( 'template-parts/layout/layout-1column' );
        }
    endwhile;
endif;
?>
<?php
get_footer();
