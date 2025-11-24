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

/**
 * 追加スタイル
 */
function dx_enqueue_custom_css() {
    wp_enqueue_style(
        'dx-custom-css',
        get_stylesheet_directory_uri() . '/custom.css',
        array(),
        filemtime( get_stylesheet_directory() . '/custom.css' )
    );
}
add_action( 'wp_enqueue_scripts', 'dx_enqueue_custom_css' );

/**
 * 投稿（post）のパンくずを「column」固定ページを親にする
 */
add_filter( 'astra_breadcrumb_trail_items', function( $items ) {

    if ( is_single() && get_post_type() === 'post' ) {

        // 投稿タイトル（最後の要素）
        $post_title = array_pop( $items );

        // コラムの固定ページ
        $column_page = get_page_by_path( 'column' );

        if ( $column_page ) {

            $home = $items[0]; // "<a href="/">ホーム</a>" のHTML文字列

            $column_html = '<a href="' . get_permalink( $column_page ) . '">' .
                           esc_html( get_the_title( $column_page ) ) .
                           '</a>';

            return array(
                $home,
                $column_html,
                $post_title,
            );
        }

        // フォールバック
        $items[] = $post_title;
    }

    return $items;

}, 20 );

/**
 * 投稿一覧（is_home）に archive クラスを付与する
 */
add_filter( 'body_class', function( $classes ) {

    if ( is_home() ) {
        $classes[] = 'archive';
        $classes[] = 'post-archive'; // 任意：判別しやすい独自クラス
    }

    return $classes;
});


/**
 * サービス（service）のパンくずを固定ページ「サービス」で統一
 */
add_filter( 'astra_breadcrumb_trail_items', function( $items ) {

    // 固定ページ（service）
    $service_page = get_page_by_path( 'service' );

    // サービス一覧 (/service/)
    if ( is_post_type_archive( 'service' ) && $service_page ) {

        return array(
            '<a href="' . home_url( '/' ) . '">ホーム</a>',
            '<span>' . esc_html( get_the_title( $service_page ) ) . '</span>',
        );
    }

    // 個別ページ
    if ( is_singular( 'service' ) && $service_page ) {

        $post_title = array_pop( $items ); // 記事タイトル（HTML）

        return array(
            '<a href="' . home_url( '/' ) . '">ホーム</a>',
            '<a href="' . get_permalink( $service_page ) . '">' . esc_html( get_the_title( $service_page ) ) . '</a>',
            $post_title,
        );
    }

    return $items;

}, 20 );

/**
 * 記事ごとに背景画像を設定
 */
add_action( 'wp_head', function() {

    if ( is_single() ) {

        // カスタムフィールド背景画像
        $bg = get_post_meta( get_the_ID(), 'bg_image', true );

        // 画像があれば url(...)、なければ none をセット
        $css_value = $bg ? 'url("' . esc_url( $bg ) . '")' : 'none';

        echo '<style>
            body.single {
                --single-bg-image: ' . $css_value . ';
            }
        </style>';
    }

});
