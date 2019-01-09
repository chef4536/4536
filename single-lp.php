<?php get_header(); ?>

<main role="main" class="padding-wrap-main-4536">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
    <article class="post">
        <header>
            <h1 class="post-title"><?php the_title(); ?></h1>
            <?php the_post_thumbnail_4536(); //アイキャッチ ?>
        </header>
        <div class="article-body" itemprop="articleBody">
            <?php
            $content = apply_filters( 'the_content', get_the_content() );
            $content = str_replace( ']]>', ']]&gt;', $content );
            if(is_amp() && empty($content)) {
                echo '<p>'.auto_description_4536().'</p>'.
                    '<div class="to-mobile-page button-4536 background-color-orange">'.
                    '<a class="color-white-4536" href="'.get_the_permalink().'">続きを読む</a></div>';
            } else {
                the_content();
                wp_link_pages();
            } ?>
        </div>
    </article>

<?php
endwhile; endif;
wp_reset_postdata();
?>

</main>

</div>
<footer id="footer" itemscope itemtype="http://schema.org/WPFooter" role="contentinfo">
<div class="inner padding-20px-10px">
    <div id="copyright">
        <?php
        $name = (site_title()) ? site_title() : get_bloginfo('name');
        $link = '<a href="'.home_url().'">'.$name.'</a>';
        echo '<span>Copyright&copy;&nbsp;'.$link.',&nbsp;All&nbsp;Rights&nbsp;Reserved.</span>';
        ?>
    </div>
</div>
</footer>

<?php if(!is_amp()) {
wp_enqueue_script('main',get_bloginfo('template_url') . '/js/main.js', array());
echo add_html_js_body();
//echo add_custom_fields_html_js_body();
wp_footer();
}
?>
</body>
</html>