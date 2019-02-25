<?php

echo '</div>'; //#wrapper

if(!is_amp() && is_active_sidebar('footer-top')) { //フッター上 ?>
    <div id="footer-top-widget-area">
        <div class="inner padding-20px-10px">
            <?php dynamic_sidebar('footer-top') ?>
        </div>
    </div>
<?php }

?>

<footer id="footer" class="footer" itemscope itemtype="http://schema.org/WPFooter" role="contentinfo">
    <div class="inner padding-20px-10px">
        <?php
        if(!is_amp()) {
            if( is_active_sidebar('footer-left') || is_active_sidebar('footer-center') || is_active_sidebar('footer-right') ) { ?>
            <div id="footer-contents-wrapper">
                <div class="footer-contents footer-left clearfix">
                    <?php dynamic_sidebar('footer-left'); ?>
                </div>
                <div class="footer-contents footer-center clearfix">
                    <?php dynamic_sidebar('footer-center'); ?>
                </div>
                <div class="footer-contents footer-right clearfix">
                    <?php dynamic_sidebar('footer-right'); ?>
                </div>
            </div>
            <?php }
        }

        $defaults = [
            'theme_location'  => 'navbar_footer',
            'container' => false,
            'fallback_cb' => false,
            'echo' => false,
            'items_wrap' => '<ul>%3$s</ul>',
        ];
        if(has_nav_menu('navbar_footer')) echo '<div id="footer-nav">'.wp_nav_menu($defaults).'</div>'; ?>

        <div id="copyright">
            <?php
            $name = (site_title()) ? site_title() : get_bloginfo('name');
            $link = '<a href="'.home_url().'">'.$name.'</a>';
            echo '<span>Copyright&copy;&nbsp;'.$link.',&nbsp;'.get_the_date('Y').'&nbsp;All&nbsp;Rights&nbsp;Reserved.</span>';
            ?>
        </div>
    </div>
</footer>

<?php
get_template_part('template-parts/fixed-footer');
get_template_part('template-parts/fixed-footer-share-button');
get_template_part('template-parts/fixed-footer-search');
get_template_part('template-parts/slide-menu');
if(is_amp()) {
    if(!fixed_footer()) echo '<a class="page-top" href="#header"><i class="fas fa-angle-up"></i></a>';
} else {
    wp_footer();
    if(is_likebox() && is_singular()) get_template_part('template-parts/likebox');
    if(add_html_js_body()) echo add_html_js_body();
    echo '<a id="page-top" class="page-top display-none" href="#header"><i class="fas fa-angle-up"></i></a>';
}
echo '</body></html>';
