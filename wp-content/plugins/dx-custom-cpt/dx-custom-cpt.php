<?php
/**
 * Plugin Name: DX Custom Post Types
 * Description: Registers custom post types for the DX site (service, case, document, movie, event).
 * Version: 1.0.0
 * Author: Your Name
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register custom post types.
 */
function dx_register_custom_post_types() {

    $post_types = array(
        'service'  => 'サービス',
        'case'     => '事例',
        'document' => '資料',
        'movie'    => '動画',
        'event'    => 'イベント',
    );

    foreach ( $post_types as $slug => $label ) {

        $args = array(
            'label'           => $label,
            'labels'          => array(
                'name'          => $label,
                'singular_name' => $label,
                'add_new'       => $label . 'を追加',
                'add_new_item'  => $label . 'を追加',
                'edit_item'     => $label . 'を編集',
                'new_item'      => '新しい' . $label,
                'view_item'     => $label . 'を表示',
                'search_items'  => $label . 'を検索',
                'not_found'     => $label . 'が見つかりません。',
            ),
            'public'          => true,
            'has_archive'     => true,
            'show_in_rest'    => true,
            'menu_position'   => 20,
            'menu_icon'       => 'dashicons-media-document',
            'supports'        => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            'rewrite'         => array( 'slug' => $slug, 'with_front' => false ),
        );

        if ( 'event' === $slug ) {
            $args['supports'][] = 'custom-fields';
        }

        register_post_type( $slug, $args );
    }
}
add_action( 'init', 'dx_register_custom_post_types' );
