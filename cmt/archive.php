<?php get_header(); ?>
<div class="container">
    <div class="archive-header">
        <h1><?php the_archive_title(); ?></h1>
        <?php the_archive_description( '<p class="description">', '</p>' ); ?>
    </div>
    <div class="grid cards">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article class="card">
                <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium' ); } ?>
                <div class="card-body">
                    <div class="meta">
                        <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                        <?php the_terms( get_the_ID(), 'post_tag', '<span>#', ', #', '</span>' ); ?>
                    </div>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p><?php echo esc_html( get_the_excerpt() ); ?></p>
                </div>
            </article>
        <?php endwhile; else : ?>
            <p><?php esc_html_e( '投稿がありません。', 'custom-media' ); ?></p>
        <?php endif; ?>
    </div>
    <div class="pagination">
        <?php the_posts_pagination(); ?>
    </div>
</div>
<?php get_footer(); ?>
