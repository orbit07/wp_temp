<div class="container two-column">
    <div>
        <?php get_template_part( 'template-parts/common/breadcrumb' ); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php get_template_part( 'template-parts/article/content' ); ?>
            <footer class="article-footer">
                <?php get_template_part( 'template-parts/article/cta' ); ?>
            </footer>
        </article>
    </div>
    <?php get_template_part( 'template-parts/common/sidebar' ); ?>
</div>
