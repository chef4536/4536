<?php

add_action( 'wp_head_4536', function() {
  global $post;
  if( !is_singular() ) return;
  $author = get_userdata( $post->post_author )->display_name;
  $posted_date = get_the_date('c');
  $modified_date = get_the_modified_date('c');
  ?>
  <script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "Article",
      "mainEntityOfPage": {
        "@type":"WebPage",
        "@id":"<?php the_permalink(); ?>"
      },
    "headline": "<?php the_title();?>",
    "datePublished": "<?php echo $posted_date; ?>",
    "dateModified": "<?php echo $modified_date; ?>",
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
      "name": "<?php echo $author; ?>"
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
  <?php
  $review_name = get_post_meta( $post->ID, 'review_name', true );
  $review_rating = get_post_meta( $post->ID, 'review_rating', true );
  if( empty( $review_name ) || empty( $review_rating ) ) return;
  ?>
  <script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "Review",
    "itemReviewed": {
      "@type": "Thing",
      "name": "<?php echo $review_name; ?>"
    },
    "reviewRating": {
      "@type": "Rating",
      "ratingValue": "<?php echo $review_rating; ?>",
      "bestRating": "10"
    },
    "datePublished": "<?php echo $posted_date; ?>",
    "author": {
      "@type": "Person",
      "name": "<?php echo $author; ?>"
    },
    "publisher": {
      "@type": "Organization",
      "name": "<?php echo bloginfo( 'name' ); ?>",
    },
  }
  </script>
<?php });
