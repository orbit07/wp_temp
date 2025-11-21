</main>
<footer class="site-footer">
    <div class="container">
        <p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
        <?php if ( has_nav_menu( 'footer' ) ) : ?>
            <?php wp_nav_menu( [
                'theme_location' => 'footer',
                'menu_class'     => 'nav-menu',
                'container'      => false,
            ] ); ?>
        <?php endif; ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
