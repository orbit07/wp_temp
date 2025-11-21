<?php
/**
 * Front page template.
 */

get_header();

$home_source_id = get_queried_object_id() ?: get_option( 'page_on_front' );

$slides = [];
if ( function_exists( 'get_field' ) ) {
    if ( $home_source_id ) {
        $slides = get_field( 'home_slides', $home_source_id ) ?: [];
    }

    if ( empty( $slides ) ) {
        // 以前のオプションページ保存データがあれば引き継ぐ。
        $slides = get_field( 'home_slides', 'option' ) ?: [];
    }
}

if ( empty( $slides ) ) {
    $fallback = new WP_Query( [
        'post_type'      => [ 'post', 'page' ],
        'posts_per_page' => 1,
    ] );

    if ( $fallback->have_posts() ) {
        while ( $fallback->have_posts() ) {
            $fallback->the_post();
            $slides[] = [
                'slide_source' => 'post',
                'slide_post'   => get_the_ID(),
            ];
        }
        wp_reset_postdata();
    }
}
?>

<section class="hero hero-carousel" data-carousel data-autoplay="true" data-interval="7000">
    <div class="container">
        <div class="carousel-track">
            <?php foreach ( $slides as $slide ) :
                $is_post   = ( $slide['slide_source'] ?? 'post' ) === 'post';
                $post_id   = $is_post ? ( $slide['slide_post'] ?? null ) : null;
                $link      = $is_post && $post_id ? get_permalink( $post_id ) : ( $slide['slide_link'] ?? '#' );
                $subtitle  = $slide['slide_subtitle'] ?? '';
                $title     = $slide['slide_title'] ?? '';
                $cta_label = $slide['slide_cta'] ?? __( '詳しく見る', 'custom-media' );

                if ( $is_post && $post_id ) {
                    $title    = $title ?: get_the_title( $post_id );
                    $subtitle = $subtitle ?: ( get_post_type_object( get_post_type( $post_id ) )->labels->singular_name ?? '' );
                }

                $image_id  = $slide['slide_image']['id'] ?? null;
                $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : '';
                if ( $is_post && $post_id && ! $image_url ) {
                    $image_url = get_the_post_thumbnail_url( $post_id, 'large' );
                }
                ?>
                <article class="hero-slide">
                    <?php if ( $image_url ) : ?>
                        <div class="hero-slide__media" style="background-image: url('<?php echo esc_url( $image_url ); ?>');"></div>
                    <?php endif; ?>
                    <div class="hero-slide__body">
                        <?php if ( $subtitle ) : ?>
                            <p class="eyebrow"><?php echo esc_html( $subtitle ); ?></p>
                        <?php endif; ?>
                        <?php if ( $title ) : ?>
                            <h1><?php echo esc_html( $title ); ?></h1>
                        <?php endif; ?>
                        <div class="hero-buttons">
                            <a class="button" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $cta_label ); ?></a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <?php if ( count( $slides ) > 1 ) : ?>
            <div class="carousel-nav">
                <button class="carousel-nav__btn" data-prev><?php esc_html_e( '前へ', 'custom-media' ); ?></button>
                <div class="carousel-dots"></div>
                <button class="carousel-nav__btn" data-next><?php esc_html_e( '次へ', 'custom-media' ); ?></button>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="container section-block">
    <div class="section-header">
        <h2><?php esc_html_e( '最新コラム', 'custom-media' ); ?></h2>
    </div>
    <?php
    $column_query = new WP_Query( [
        'post_type'      => 'post',
        'posts_per_page' => 10,
    ] );
    ?>
    <?php if ( $column_query->have_posts() ) : ?>
        <div class="card-carousel" data-carousel data-visible="3" data-autoplay="false">
            <div class="carousel-track">
                <?php
                while ( $column_query->have_posts() ) :
                    $column_query->the_post();
                    ?>
                    <article class="card">
                        <a href="<?php the_permalink(); ?>" class="card__link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium' ); ?>
                            <?php endif; ?>
                            <div class="card-body">
                                <?php if ( $subtitle = get_post_meta( get_the_ID(), 'subtitle', true ) ) : ?>
                                    <p class="eyebrow">&ldquo;<?php echo esc_html( $subtitle ); ?>&rdquo;</p>
                                <?php endif; ?>
                                <div class="meta"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></div>
                                <h3><?php the_title(); ?></h3>
                                <div class="tags"><?php the_tags( '', ' ' ); ?></div>
                            </div>
                        </a>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <div class="carousel-nav">
                <button class="carousel-nav__btn" data-prev><?php esc_html_e( '前へ', 'custom-media' ); ?></button>
                <div class="carousel-dots"></div>
                <button class="carousel-nav__btn" data-next><?php esc_html_e( '次へ', 'custom-media' ); ?></button>
            </div>
        </div>
    <?php else : ?>
        <p><?php esc_html_e( '記事がありません。', 'custom-media' ); ?></p>
    <?php endif; ?>
</section>

<section class="container section-block">
    <div class="section-header">
        <h2><?php esc_html_e( 'タグクラウド', 'custom-media' ); ?></h2>
    </div>
    <div class="tag-cloud">
        <?php wp_tag_cloud(); ?>
    </div>
</section>

<section class="container section-block">
    <div class="section-header">
        <h2><?php esc_html_e( 'サービス＆ソリューション', 'custom-media' ); ?></h2>
    </div>
    <div class="grid cards">
        <?php
        $services = new WP_Query( [
            'post_type'      => 'service',
            'posts_per_page' => -1,
            'meta_key'       => 'service_order',
            'orderby'        => [ 'meta_value_num' => 'ASC', 'date' => 'DESC' ],
        ] );
        ?>
        <?php if ( $services->have_posts() ) : while ( $services->have_posts() ) : $services->the_post(); ?>
            <article class="card">
                <a href="<?php the_permalink(); ?>" class="card__link">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'medium' ); ?>
                    <?php endif; ?>
                    <div class="card-body">
                        <h3><?php the_title(); ?></h3>
                        <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
                    </div>
                </a>
            </article>
        <?php endwhile; wp_reset_postdata(); else : ?>
            <p><?php esc_html_e( 'サービス情報がありません。', 'custom-media' ); ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="container section-block">
    <div class="section-header">
        <h2><?php esc_html_e( 'お役立ち資料＆動画ライブラリ', 'custom-media' ); ?></h2>
    </div>
    <?php
    $resources = new WP_Query( [
        'post_type'      => [ 'document', 'movie' ],
        'posts_per_page' => 10,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ] );
    ?>
    <?php if ( $resources->have_posts() ) : ?>
        <div class="card-carousel" data-carousel data-visible="3" data-autoplay="false">
            <div class="carousel-track">
                <?php while ( $resources->have_posts() ) : $resources->the_post(); ?>
                    <article class="card">
                        <a href="<?php the_permalink(); ?>" class="card__link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium' ); ?>
                            <?php endif; ?>
                            <div class="card-body">
                                <?php if ( $subtitle = get_post_meta( get_the_ID(), 'subtitle', true ) ) : ?>
                                    <p class="eyebrow">&ldquo;<?php echo esc_html( $subtitle ); ?>&rdquo;</p>
                                <?php endif; ?>
                                <h3><?php the_title(); ?></h3>
                                <div class="tags"><?php the_tags( '', ' ' ); ?></div>
                            </div>
                        </a>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <div class="carousel-nav">
                <button class="carousel-nav__btn" data-prev><?php esc_html_e( '前へ', 'custom-media' ); ?></button>
                <div class="carousel-dots"></div>
                <button class="carousel-nav__btn" data-next><?php esc_html_e( '次へ', 'custom-media' ); ?></button>
            </div>
        </div>
    <?php else : ?>
        <p><?php esc_html_e( '資料・動画がありません。', 'custom-media' ); ?></p>
    <?php endif; ?>
</section>

<section class="container section-block">
    <div class="section-header">
        <h2><?php esc_html_e( '事例', 'custom-media' ); ?></h2>
    </div>
    <?php
    $cases = new WP_Query( [
        'post_type'      => 'case',
        'posts_per_page' => 10,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ] );
    ?>
    <?php if ( $cases->have_posts() ) : ?>
        <div class="card-carousel" data-carousel data-visible="3" data-autoplay="false">
            <div class="carousel-track">
                <?php while ( $cases->have_posts() ) : $cases->the_post(); ?>
                    <article class="card">
                        <a href="<?php the_permalink(); ?>" class="card__link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium' ); ?>
                            <?php endif; ?>
                            <div class="card-body">
                                <h3><?php the_title(); ?></h3>
                                <div class="tags"><?php the_tags( '', ' ' ); ?></div>
                            </div>
                        </a>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <div class="carousel-nav">
                <button class="carousel-nav__btn" data-prev><?php esc_html_e( '前へ', 'custom-media' ); ?></button>
                <div class="carousel-dots"></div>
                <button class="carousel-nav__btn" data-next><?php esc_html_e( '次へ', 'custom-media' ); ?></button>
            </div>
        </div>
    <?php else : ?>
        <p><?php esc_html_e( '事例がありません。', 'custom-media' ); ?></p>
    <?php endif; ?>
</section>

<section class="container section-block newsletter">
    <div class="newsletter__body">
        <div>
            <p class="eyebrow"><?php esc_html_e( 'メルマガ登録', 'custom-media' ); ?></p>
            <h2><?php esc_html_e( '最新情報をメールでお届けします', 'custom-media' ); ?></h2>
            <p><?php esc_html_e( '新着コラムやイベント情報をいち早くお知らせします。ぜひご登録ください。', 'custom-media' ); ?></p>
        </div>
        <div class="newsletter__cta">
            <a class="button" href="#cta-contact"><?php esc_html_e( '登録する', 'custom-media' ); ?></a>
        </div>
    </div>
    <?php
    $cases = new WP_Query( [
        'post_type'      => 'case',
        'posts_per_page' => 10,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ] );
    ?>
    <?php if ( $cases->have_posts() ) : ?>
        <div class="card-carousel" data-carousel data-visible="3" data-autoplay="false">
            <div class="carousel-track">
                <?php while ( $cases->have_posts() ) : $cases->the_post(); ?>
                    <article class="card">
                        <a href="<?php the_permalink(); ?>" class="card__link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium' ); ?>
                            <?php endif; ?>
                            <div class="card-body">
                                <h3><?php the_title(); ?></h3>
                                <div class="tags"><?php the_tags( '', ' ' ); ?></div>
                            </div>
                        </a>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <div class="carousel-nav">
                <button class="carousel-nav__btn" data-prev><?php esc_html_e( '前へ', 'custom-media' ); ?></button>
                <div class="carousel-dots"></div>
                <button class="carousel-nav__btn" data-next><?php esc_html_e( '次へ', 'custom-media' ); ?></button>
            </div>
        </div>
    <?php else : ?>
        <p><?php esc_html_e( '事例がありません。', 'custom-media' ); ?></p>
    <?php endif; ?>
</section>

<section class="container section-block">
    <?php custom_media_render_cta_buttons(); ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-carousel]').forEach((carousel) => {
        const track = carousel.querySelector('.carousel-track');
        const slides = Array.from(track ? track.children : []);
        if (!track || slides.length === 0) {
            return;
        }

        const visible = parseInt(carousel.dataset.visible || '1', 10);
        carousel.style.setProperty('--visible', visible);

        let index = 0;
        const maxIndex = Math.max(0, slides.length - visible);

        const dotsContainer = carousel.querySelector('.carousel-dots');
        const dots = [];
        if (dotsContainer) {
            slides.forEach((_, dotIndex) => {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.addEventListener('click', () => {
                    index = Math.min(dotIndex, maxIndex);
                    update();
                });
                dotsContainer.appendChild(dot);
                dots.push(dot);
            });
        }

        const update = () => {
            index = Math.min(Math.max(index, 0), maxIndex);
            const offset = (100 / visible) * index;
            track.style.transform = `translateX(-${offset}%)`;
            dots.forEach((dot, idx) => {
                dot.classList.toggle('is-active', idx === index);
            });
        };

        const prev = carousel.querySelector('[data-prev]');
        const next = carousel.querySelector('[data-next]');
        prev?.addEventListener('click', () => {
            index = index - 1 < 0 ? maxIndex : index - 1;
            update();
        });
        next?.addEventListener('click', () => {
            index = index + 1 > maxIndex ? 0 : index + 1;
            update();
        });

        const autoplay = carousel.dataset.autoplay === 'true';
        const interval = parseInt(carousel.dataset.interval || '5000', 10);
        let timer = null;

        const start = () => {
            if (!autoplay) return;
            if (timer) {
                clearInterval(timer);
            }
            timer = setInterval(() => {
                index = index + 1 > maxIndex ? 0 : index + 1;
                update();
            }, interval);
        };

        const stop = () => {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        };

        carousel.addEventListener('mouseenter', stop);
        carousel.addEventListener('mouseleave', start);

        update();
        start();
    });
});
</script>

<?php get_footer(); ?>
