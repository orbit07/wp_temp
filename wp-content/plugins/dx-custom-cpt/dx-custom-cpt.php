<?php
/**
 * Plugin Name: DX Custom Post Types
 * Description: Registers custom post types for the DX site (service, case, document, movie, event).
 * Version: 1.0.1
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

        // ▼ service だけ別設定を与える
        if ( $slug === 'service' ) {

            $args = array(
                'label'           => $label,
                'labels'          => array(
                    'name'          => $label,
                    'singular_name' => $label,
                ),
                'public'          => true,

                // 🔥 一覧ページは固定ページに任せるので false
                'has_archive'     => false,

                'show_in_rest'    => true,
                'menu_position'   => 20,
                'menu_icon'       => 'dashicons-media-document',
                'supports'        => array( 'title', 'editor', 'thumbnail', 'excerpt' ),

                // 🔥 固定ページ /service/ と同じ slug を使う
                //    （ただし has_archive が false なので競合しない）
                'rewrite'         => array( 'slug' => 'service', 'with_front' => false ),
            );

        } else {

            // ▼ その他の C P T（case/document/movie/event）
            $args = array(
                'label'           => $label,
                'labels'          => array(
                    'name'          => $label,
                    'singular_name' => $label,
                ),
                'public'          => true,
                'has_archive'     => true,
                'show_in_rest'    => true,
                'menu_position'   => 20,
                'menu_icon'       => 'dashicons-media-document',
                'supports'        => array( 'title', 'editor', 'thumbnail', 'excerpt' ),

                // slug は各 CPT のスラッグのまま
                'rewrite'         => array( 'slug' => $slug, 'with_front' => false ),
            );
        }

        // イベントの追加サポート
        if ( 'event' === $slug ) {
            $args['supports'][] = 'custom-fields';
        }

        register_post_type( $slug, $args );
    }
}
add_action( 'init', 'dx_register_custom_post_types' );

/**
 * Prevent archives for the service post type.
 */
function dx_disable_service_archive( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( $query->is_post_type_archive( 'service' ) ) {
        $query->set_404();
    }
}
add_action( 'pre_get_posts', 'dx_disable_service_archive' );
