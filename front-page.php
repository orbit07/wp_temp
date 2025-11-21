<?php get_header(); ?>
<section class="hero">
    <div class="container">
        <h1><?php bloginfo( 'name' ); ?></h1>
        <p><?php bloginfo( 'description' ); ?></p>
        <div class="hero-buttons">
            <a class="button" href="#cta-document"><?php esc_html_e( '資料DL', 'custom-media' ); ?></a>
            <a class="button secondary" href="#cta-event"><?php esc_html_e( 'セミナー / イベント', 'custom-media' ); ?></a>
            <a class="button" href="#cta-contact"><?php esc_html_e( '問い合わせ', 'custom-media' ); ?></a>
        </div>
    </div>
</section>

<section class="container">
    <div class="archive-header">
        <h2><?php esc_html_e( '最新記事', 'custom-media' ); ?></h2>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>"><?php esc_html_e( 'すべて見る', 'custom-media' ); ?></a>
    </div>
    <div class="grid cards">
        <?php
        $latest = new WP_Query( [ 'post_type' => 'post', 'posts_per_page' => 3 ] );
        if ( $latest->have_posts() ) :
            while ( $latest->have_posts() ) :
                $latest->the_post();
                ?>
                <article class="card">
                    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium' ); } ?>
                    <div class="card-body">
                        <div class="meta"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></div>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php echo esc_html( get_the_excerpt() ); ?></p>
                    </div>
                </article>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>' . esc_html__( '記事がありません。', 'custom-media' ) . '</p>';
        endif;
        ?>
    </div>
</section>

<section class="container">
    <div class="archive-header">
        <h2><?php esc_html_e( 'サービス', 'custom-media' ); ?></h2>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><?php esc_html_e( '一覧を見る', 'custom-media' ); ?></a>
    </div>
    <div class="grid cards">
        <?php
        $services = new WP_Query( [ 'post_type' => 'service', 'posts_per_page' => 3 ] );
        if ( $services->have_posts() ) :
            while ( $services->have_posts() ) :
                $services->the_post();
                ?>
                <article class="card">
                    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium' ); } ?>
                    <div class="card-body">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php echo esc_html( get_the_excerpt() ); ?></p>
                    </div>
                </article>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>' . esc_html__( 'サービス情報がありません。', 'custom-media' ) . '</p>';
        endif;
        ?>
    </div>
</section>

<section class="container">
    <div class="archive-header">
        <h2><?php esc_html_e( 'イベント / セミナー', 'custom-media' ); ?></h2>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>"><?php esc_html_e( '一覧を見る', 'custom-media' ); ?></a>
    </div>
    <div class="grid cards">
        <?php
        $events = new WP_Query( [ 'post_type' => 'event', 'posts_per_page' => 3 ] );
        if ( $events->have_posts() ) :
            while ( $events->have_posts() ) :
                $events->the_post();
                ?>
                <article class="card">
                    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium' ); } ?>
                    <div class="card-body">
                        <div class="meta"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></div>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php echo esc_html( get_the_excerpt() ); ?></p>
                    </div>
                </article>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>' . esc_html__( 'イベントがありません。', 'custom-media' ) . '</p>';
        endif;
        ?>
    </div>
</section>

<section class="container">
    <?php custom_media_render_cta_buttons(); ?>
</section>
<?php get_footer(); ?>
