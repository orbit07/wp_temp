<?php
/**
 * アーカイブ用：検索結果（サブタイトルがあれば表示）
 */
?>
<article <?php post_class( 'dx-archive-item dx-archive-item--search' ); ?>>
    <a href="<?php the_permalink(); ?>" class="dx-archive-item__link">

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="dx-archive-item__thumb">
                <?php the_post_thumbnail( 'medium' ); ?>
            </div>
        <?php endif; ?>

        <div class="dx-archive-item__body">
            <?php if ( $sub = get_post_meta( get_the_ID(), 'subtitle', true ) ) : ?>
                <p class="dx-archive-item__subtitle"><?php echo esc_html( $sub ); ?></p>
            <?php endif; ?>

            <h2 class="dx-archive-item__title"><?php the_title(); ?></h2>
        </div>
    </a>
</article>
