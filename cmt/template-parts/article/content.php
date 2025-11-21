<header class="entry-header">
    <?php if ( is_singular() ) : ?>
        <h1 class="entry-title"><?php the_title(); ?></h1>
    <?php else : ?>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php endif; ?>
    <div class="meta">
        <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
        <?php the_terms( get_the_ID(), 'post_tag', '<span>#', ', #', '</span>' ); ?>
    </div>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="featured-image">
            <?php the_post_thumbnail( 'large' ); ?>
        </div>
    <?php endif; ?>
</header>
<div class="entry-content">
    <?php the_content(); ?>
</div>
