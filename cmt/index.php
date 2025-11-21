<?php
/**
 * Fallback index template.
 *
 * Ensures theme validity and provides a basic archive-style layout when no specific
 * template exists. Mirrors archive grid styling with pagination.
 *
 * @package custom-media
 */

get_header();
?>

<main class="container">
  <h1><?php bloginfo('name'); ?></h1>
  <div class="archive-grid">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <article class="card">
        <?php if ( has_post_thumbnail() ) : ?>
          <a href="<?php the_permalink(); ?>" class="card-thumb"><?php the_post_thumbnail('medium'); ?></a>
        <?php endif; ?>
        <div class="card-body">
          <div class="card-meta">
            <time datetime="<?php echo esc_attr( get_the_date('c') ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
          </div>
          <h2 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <p class="card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
          <div class="card-tags"><?php the_tags('', ' '); ?></div>
        </div>
      </article>
    <?php endwhile; else : ?>
      <p><?php esc_html_e('No posts found.', 'custom-media'); ?></p>
    <?php endif; ?>
  </div>

  <div class="pagination">
    <?php the_posts_pagination( array(
      'mid_size'  => 2,
      'prev_text' => __('Prev', 'custom-media'),
      'next_text' => __('Next', 'custom-media'),
    ) ); ?>
  </div>
</main>

<?php get_footer(); ?>
