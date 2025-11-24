<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Customize Astra archive loop to use our own template parts.
 */
function dx_setup_custom_archive_loop() {

    if ( ! ( is_archive() || is_home() || is_tag() || is_search() ) ) {
        return;
    }

    if ( class_exists( 'Astra_Loop' ) ) {
        $loop = Astra_Loop::get_instance();
        // Remove Astra's default template part callbacks for archives/search.
        remove_action( 'astra_template_parts_content', array( $loop, 'template_parts_post' ) );
        remove_action( 'astra_template_parts_content', array( $loop, 'template_parts_search' ) );
        remove_action( 'astra_template_parts_content', array( $loop, 'template_parts_default' ) );
    }

    add_action( 'astra_template_parts_content', 'dx_archive_entry_template' );
}
add_action( 'astra_content_loop', 'dx_setup_custom_archive_loop', 1 );

/**
 * Entry template selector for archives/search/tag.
 */
function dx_archive_entry_template() {

    if ( is_search() ) {
        get_template_part( 'template-parts/archive/content', 'search' );
        return;
    }

    if ( is_tag() ) {
        get_template_part( 'template-parts/archive/content', 'tag' );
        return;
    }

    if ( is_post_type_archive( 'case' ) ) {
        get_template_part( 'template-parts/archive/content', 'case' );
        return;
    }

    if ( is_post_type_archive( 'document' ) ) {
        get_template_part( 'template-parts/archive/content', 'document' );
        return;
    }

    if ( is_post_type_archive( 'movie' ) ) {
        get_template_part( 'template-parts/archive/content', 'movie' );
        return;
    }

    if ( is_post_type_archive( 'event' ) ) {
        get_template_part( 'template-parts/archive/content', 'event' );
        return;
    }

    // Default: 通常の投稿・その他のアーカイブ。
    get_template_part( 'template-parts/archive/content', 'post' );
}
