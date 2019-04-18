<?php if( !is_singular() ) return; ?>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Article",
    "mainEntityOfPage": {
      "@type":"WebPage",
      "@id":"<?php the_permalink(); ?>"
    },
  "headline": "<?php the_title();?>",
  "datePublished": "<?php echo get_the_date('c'); ?>",
  "dateModified": "<?php echo get_the_modified_date('c'); ?>",
  "image": {
    "@type": "ImageObject",
      <?php
      $image_id = get_post_thumbnail_id();
      $image_url = wp_get_attachment_image_src($image_id, true);
      ?>
    "url": "<?php echo $image_url[0]; ?>",
    "width": 800,
    "height": 533
  },
  "author": {
    "@type": "Person",
    "name": "<?php echo get_userdata($post->post_author)->display_name; ?>"
  },
  "publisher": {
    "@type": "Organization",
    "name": "<?php echo bloginfo( 'name' ); ?>",
    "logo": {
      "@type": "ImageObject",
      "url": "<?php echo get_site_icon_url(); ?>",
      "width": 32,
      "height": 32
    }
  },
  "description": "<?php echo description_4536();?>"
}
</script>
