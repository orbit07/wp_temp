<?php
/**
 * アーカイブ用：通常投稿（コラム）カード
 */
?>
<article <?php post_class( 'dx-archive-item dx-archive-item--post' ); ?>>

    <!-- リンクはサムネ＋本文部分のみ -->
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

        </div><!-- /.dx-archive-item__body -->

    </a><!-- /.dx-archive-item__link ここで閉じる -->

    <!-- 👇 ここから下はリンクの外に出す！ -->
    <div class="entry-meta ast-related-cat-style--badge ast-related-tag-style--underline">

        <!-- カテゴリ -->
        <?php
        $cats = get_the_category();
        if ( $cats ) :
        ?>
            <span class="ast-taxonomy-container cat-links default">
                <?php foreach ( $cats as $i => $cat ) : ?>
                    <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" rel="category tag">
                        <?php echo esc_html( $cat->name ); ?>
                    </a><?php if ( $i < count( $cats ) - 1 ) echo ', '; ?>
                <?php endforeach; ?>
            </span>
        <?php endif; ?>

        &nbsp;

        <!-- 日付 -->
        <span class="posted-on">
            <span class="published" itemprop="datePublished">
                <?php echo esc_html( get_the_date() ); ?>
            </span>
        </span>

        &nbsp;

        <!-- タグ -->
        <?php
        $tags = get_the_tags();
        if ( $tags ) :
        ?>
            <span class="ast-taxonomy-container tags-links default">
                <?php foreach ( $tags as $i => $tag ) : ?><a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" rel="tag"><?php echo esc_html( $tag->name ); ?></a><?php if ( $i < count( $tags ) - 1 ) echo ', '; ?><?php endforeach; ?>
            </span>
        <?php endif; ?>

    </div><!-- /.entry-meta -->

</article>
