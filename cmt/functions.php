<?php
/**
 * Theme bootstrap and feature registration.
 */

define( 'CUSTOM_MEDIA_VERSION', '1.0.0' );

add_action( 'after_setup_theme', 'custom_media_setup' );
function custom_media_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );

    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'custom-media' ),
        'footer'  => __( 'Footer Menu', 'custom-media' ),
    ] );
}

add_action( 'wp_enqueue_scripts', 'custom_media_assets' );
function custom_media_assets() {
    wp_enqueue_style( 'custom-media-style', get_stylesheet_uri(), [], CUSTOM_MEDIA_VERSION );
}

add_action( 'widgets_init', 'custom_media_widgets' );
function custom_media_widgets() {
    register_sidebar( [
        'name'          => __( 'Primary Sidebar', 'custom-media' ),
        'id'            => 'primary-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );
}

add_action( 'init', 'custom_media_register_cpts' );
function custom_media_register_cpts() {
    $cpts = [
        'case'     => __( 'Cases', 'custom-media' ),
        'document' => __( 'Documents', 'custom-media' ),
        'movie'    => __( 'Movies', 'custom-media' ),
        'service'  => __( 'Services', 'custom-media' ),
        'event'    => __( 'Events', 'custom-media' ),
    ];

    foreach ( $cpts as $slug => $label ) {
        register_post_type( $slug, [
            'label'               => $label,
            'public'              => true,
            'has_archive'         => true,
            'menu_position'       => 5,
            'supports'            => [ 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ],
            'show_in_rest'        => true,
            'publicly_queryable'  => true,
            'rewrite'             => [ 'slug' => $slug ],
            'show_in_nav_menus'   => true,
        ] );
    }
}

function custom_media_default_layout( $post_type ) {
    $defaults = [
        'post'     => 'two',
        'case'     => 'two',
        'document' => 'one',
        'movie'    => 'one',
    ];

    return $defaults[ $post_type ] ?? 'one';
}

add_filter( 'acf/load_value/name=layout_type', 'custom_media_load_layout_default', 10, 3 );
function custom_media_load_layout_default( $value, $post_id, $field ) {
    if ( $value ) {
        return $value;
    }

    $post_type = get_post_type( $post_id );
    return custom_media_default_layout( $post_type );
}

function custom_media_render_cta_buttons() {
    ?>
    <div class="cta-block">
        <h3><?php esc_html_e( '資料ダウンロード / お問い合わせ', 'custom-media' ); ?></h3>
        <div class="hero-buttons">
            <a class="button" href="#cta-document"><?php esc_html_e( '資料DL', 'custom-media' ); ?></a>
            <a class="button secondary" href="#cta-event"><?php esc_html_e( 'セミナー / イベント', 'custom-media' ); ?></a>
            <a class="button" href="#cta-contact"><?php esc_html_e( '問い合わせ', 'custom-media' ); ?></a>
        </div>
    </div>
    <?php
}

// Local ACF definitions to mirror the specification.
add_action( 'acf/init', 'custom_media_register_acf_fields' );
function custom_media_register_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( [
        'key'    => 'group_layout_type',
        'title'  => 'レイアウト選択',
        'fields' => [
            [
                'key'           => 'field_layout_type',
                'label'         => 'レイアウト選択',
                'name'          => 'layout_type',
                'type'          => 'radio',
                'choices'       => [
                    'one' => '1カラム',
                    'two' => '2カラム',
                ],
                'layout'        => 'horizontal',
                'default_value' => 'one',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'post',
                ],
            ],
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'case',
                ],
            ],
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'document',
                ],
            ],
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'movie',
                ],
            ],
        ],
    ] );

    acf_add_local_field_group( [
        'key'    => 'group_sidebar_banner',
        'title'  => 'サイドバーバナー',
        'fields' => [
            [
                'key'   => 'field_sidebar_banner_show',
                'label' => '表示する',
                'name'  => 'sidebar_banner_show',
                'type'  => 'true_false',
                'ui'    => 1,
            ],
            [
                'key'   => 'field_sidebar_banner_img',
                'label' => 'サイドバーバナー画像',
                'name'  => 'sidebar_banner_img',
                'type'  => 'image',
                'return_format' => 'array',
            ],
            [
                'key'   => 'field_sidebar_banner_link',
                'label' => 'サイドバーバナーリンク',
                'name'  => 'sidebar_banner_link',
                'type'  => 'url',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'post',
                ],
            ],
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'case',
                ],
            ],
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'document',
                ],
            ],
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'movie',
                ],
            ],
        ],
    ] );
}

function custom_media_related_cases( $post_id ) {
    $tags = wp_get_post_tags( $post_id, [ 'fields' => 'ids' ] );
    $categories = wp_get_post_categories( $post_id, [ 'fields' => 'ids' ] );

    $tax_query = [];
    if ( $tags ) {
        $tax_query[] = [
            'taxonomy' => 'post_tag',
            'field'    => 'term_id',
            'terms'    => $tags,
        ];
    }
    if ( $categories ) {
        $tax_query[] = [
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => $categories,
        ];
    }

    $args = [
        'post_type'      => 'case',
        'posts_per_page' => 4,
        'tax_query'      => $tax_query,
    ];

    return new WP_Query( $args );
}
