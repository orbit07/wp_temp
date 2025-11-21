<?php
/**
 * Front page template.
 *
 * Displays the static page selected in site settings while keeping the theme header and footer.
 *
 * @package custom-media
 */

get_header();
?>

<main class="container">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php get_template_part( 'template-parts/common/breadcrumb' ); ?>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p><?php esc_html_e( '表示するページがありません。', 'custom-media' ); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
