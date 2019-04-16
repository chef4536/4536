<?php get_header(); ?>

<div id="contents-wrapper">
    <div id="contents-inner">
        <main id="main" class="padding-wrap-main-4536 post-bg-color post-color" role="main">
            <article>
                <div class="post">
                    <h1 id="_404-title">ページが見つかりませんでした！</h1>
                    <p>
                        <img src="<?php echo get_template_directory_uri(); ?>/img/404.png" alt="404" title="404" width="750" height="565" />
                    </p>
                </div>
            </article>
        </main>
        <?php
        get_template_part('template-parts/music');
        get_template_part('template-parts/movie');
        get_template_part('template-parts/pickup');
        ?>
    </div>
</div>

<?php
get_sidebar();
get_footer();
?>
