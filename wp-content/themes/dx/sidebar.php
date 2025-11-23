<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 固定ページをサイドバーとして読み込むユーティリティ.
 */
function dx_render_sidebar_page_by_slug( $slug ) {
    $page = get_page_by_path( $slug );
    if ( $page ) {
        echo '<div class="dx-sidebar-page dx-sidebar-page--' . esc_attr( $slug ) . '">';
        echo apply_filters( 'the_content', $page->post_content );
        echo '</div>';
    } elseif ( is_active_sidebar( 'sidebar-1' ) ) {
        // フォールバック: Astra標準ウィジェットエリア。
        dynamic_sidebar( 'sidebar-1' );
    }
}

// アーカイブ・検索などでサイドバー切り替え。
if ( is_post_type_archive( 'post' ) || is_home() ) {

    dx_render_sidebar_page_by_slug( 'sidebar-post' );

} elseif ( is_post_type_archive( 'case' ) ) {

    dx_render_sidebar_page_by_slug( 'sidebar-case' );

} elseif ( is_post_type_archive( 'document' ) || is_post_type_archive( 'movie' ) || is_post_type_archive( 'event' ) ) {

    dx_render_sidebar_page_by_slug( 'sidebar-cpt' );

} elseif ( is_tag() ) {

    dx_render_sidebar_page_by_slug( 'sidebar-tag' );

} elseif ( is_search() ) {

    dx_render_sidebar_page_by_slug( 'sidebar-search' );

} else {

    // それ以外のページでは Astra 標準サイドバー。
    if ( is_active_sidebar( 'sidebar-1' ) ) {
        dynamic_sidebar( 'sidebar-1' );
    }
}
