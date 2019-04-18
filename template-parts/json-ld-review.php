<?php if( !is_singular() ) return; ?>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Review",
  "itemReviewed": {
    "@type": "Thing",
    "name": ""
  },
  "reviewRating": {
    "@type": "Rating",
    "ratingValue": "",
    "bestRating": "10"
  },
  "reviewBody": "<?php echo get_the_content();?>"
  "datePublished": "<?php echo get_the_date('c'); ?>",
  "dateModified": "<?php echo get_the_modified_date('c'); ?>",
  "author": {
    "@type": "Person",
    "name": "<?php echo get_userdata($post->post_author)->display_name; ?>"
  },
  "publisher": {
    "@type": "Organization",
    "name": "<?php echo bloginfo( 'name' ); ?>",
  },
}
</script>
