<?php
/**
 * Template for the Posts Page (コラム一覧)
 */

get_header();
?>

<div id="primary" <?php astra_primary_class(); ?>>

    <?php astra_primary_content_top(); ?>

    <section class="ast-archive-description">
        <!-- パンくず -->
        <?php astra_breadcrumb_trail(); ?>
        <!-- タイトル -->
        <h1 class="page-title ast-archive-title">
            <?php echo esc_html( get_the_title( get_option( 'page_for_posts' ) ) ); ?>
        </h1>		
    </section>

    <?php astra_content_loop(); ?>

    <?php astra_pagination(); ?>

    <?php astra_primary_content_bottom(); ?>

</div>

<?php
get_footer();
