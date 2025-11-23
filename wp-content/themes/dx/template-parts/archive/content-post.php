<?php
/**
 * アーカイブ用：通常投稿（コラム）カード
 */
?>
<article <?php post_class( 'dx-archive-item dx-archive-item--post' ); ?>>
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

            <p class="dx-archive-item__meta">
                <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
                    <?php echo esc_html( get_the_date() ); ?>
                </time>
            </p>
        </div>
    </a>
</article>
