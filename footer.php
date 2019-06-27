<?php

echo '</div>'; //#main-container

if (is_singular()) {
    media_section_4536('music');
}

media_section_4536('movie'); //サブメディア

if (!is_amp() && is_active_sidebar('footer-top')) { //フッター上?>
  <div id="footer-top-widget-area">
    <div class="inner p-r w-100 ma-auto py-4 px-2">
      <?php dynamic_sidebar('footer-top') ?>
    </div>
  </div>
<?php }

echo '</div>'; //#main-column

?>

<div id="site-bottom" class="gradation">
  <?php wave_shape('footer'); ?>
  <footer id="footer" class="footer" itemscope itemtype="http://schema.org/WPFooter" role="contentinfo">
    <div class="container ma-auto pa-3">
      <div>
        <?php
        if (!none_header_footer()) {
            if (!is_amp()) {
                if (is_active_sidebar('footer-left') || is_active_sidebar('footer-center') || is_active_sidebar('footer-right')) { ?>
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
            'items_wrap' => '<ul data-display="flex" data-justify-content="center">%3$s</ul>',
          ];
            if (has_nav_menu('navbar_footer')) {
                echo '<div class="global-nav">' . wp_nav_menu($defaults) . '</div>';
            }
        } ?>
      </div>
      <div id="copyright" data-text-align="center" class="meta mt-4 mb-4">
        <?php
        $name = (site_title()) ? site_title() : get_bloginfo('name');
        $link = '<a href="'.home_url().'">'.$name.'</a>';
        ?>
        <span>Copyright&copy;&nbsp;<?php echo $link; ?>,&nbsp;<?php the_date('Y'); ?>&nbsp;All&nbsp;Rights&nbsp;Reserved.</span>
      </div>
      <?php
      if (fixed_footer() && !none_header_footer()) {
        echo '<div data-display="none-md" class="pb-5"></div>';
      } ?>
    </div>
  </footer>
</div>

<?php
if (!none_header_footer()) {
          get_template_part('template-parts/fixed-footer');
          get_template_part('template-parts/fixed-footer-search');
          if (is_amp()) {
              if (!fixed_footer()) {
                  echo '<a class="page-top" href="#header"><i class="fas fa-angle-up"></i></a>';
              }
          } else {
              wp_footer();
              if (is_likebox() && is_singular()) {
                  get_template_part('template-parts/likebox');
              }
              if (add_html_js_body()) {
                  echo add_html_js_body();
              }
              echo '<a id="page-top" class="page-top d-n" href="#header"><i class="fas fa-angle-up"></i></a>';
          }
      } else {
          if (!is_amp()) {
              wp_footer();
          }
      }
echo '</body></html>';
