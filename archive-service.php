<?php get_header(); ?>
<div class="container">
    <div class="archive-header">
        <h1><?php post_type_archive_title(); ?></h1>
        <form class="service-filter" method="get">
            <label for="service-cat">カテゴリフィルタ（任意）</label>
            <?php
            wp_dropdown_categories( [
                'show_option_all' => __( 'すべてのカテゴリ', 'custom-media' ),
                'name'            => 'cat',
                'id'              => 'service-cat',
                'taxonomy'        => 'category',
                'hide_empty'      => false,
                'value_field'     => 'slug',
                'selected'        => get_query_var( 'category_name' ),
            ] );
            ?>
            <button class="button" type="submit"><?php esc_html_e( '絞り込む', 'custom-media' ); ?></button>
        </form>
    </div>

    <div class="grid cards">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article class="card">
                <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium' ); } ?>
                <div class="card-body">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p><?php echo esc_html( get_the_excerpt() ); ?></p>
                </div>
            </article>
        <?php endwhile; else : ?>
            <p><?php esc_html_e( 'サービスが見つかりません。', 'custom-media' ); ?></p>
        <?php endif; ?>
    </div>
    <div class="pagination"><?php the_posts_pagination(); ?></div>
</div>
<?php get_footer(); ?>
