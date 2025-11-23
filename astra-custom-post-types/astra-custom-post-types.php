<?php
/**
 * Plugin Name: Astra Custom Post Types
 * Description: Registers custom post types used by the Astra site.
 * Version: 1.0.0
 * Author: Custom Media
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'astra_register_custom_post_types' ) ) {
    function astra_register_custom_post_types() {
        $post_types = array(
            'service'  => 'サービス',
            'case'     => '事例',
            'document' => '資料',
            'movie'    => '動画',
            'event'    => 'イベント',
        );

        foreach ( $post_types as $post_type => $label ) {
            register_post_type(
                $post_type,
                array(
                    'labels'       => array(
                        'name'          => $label,
                        'singular_name' => $label,
                    ),
                    'public'       => true,
                    'has_archive'  => true,
                    'show_in_rest' => true,
                    'rewrite'      => array( 'slug' => $post_type ),
                    'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
                )
            );
        }
    }
}
add_action( 'init', 'astra_register_custom_post_types' );

