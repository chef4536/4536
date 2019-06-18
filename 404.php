<?php get_header(); ?>

<div id="contents-wrapper" class="w-100 max-w-100">
    <div id="contents-inner">
        <main id="main" class="w-100 post-bg-color post-color" role="main">
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
        media_section_4536( 'music' );
        media_section_4536( 'movie' );
        media_section_4536( 'pickup' );
        ?>
    </div>
</div>

<?php
get_sidebar();
get_footer();
?>
