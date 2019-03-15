<?php

function breadcrumb() {

  global $post;
  $post_id = $post->ID;
  $post_url = get_the_permalink( $post_id );
  $post_title = $post->post_title;
  $page_count_url = '';
  $page_count_name = '';
  if( is_paged() ) {
    $page_count = get_query_var( 'paged' );
    $page_count_url = '/page/' . $page_count;
    $page_count_name = '（ページ' . $page_count . '）';
  }
  $object = get_queried_object();

  $pos = 1;

  //ブログ投稿インデックス
  $site_name = get_bloginfo('name');
  $site_url = site_url();
  if( is_home() ) {
    $site_name .= $page_count_name;
    $site_url = rtrim( $site_url, '/' ) . $page_count_url ;
  }
  $arr[ $pos ] = [
    'name' => $site_name,
    'url' => $site_url,
  ];

  switch ( true ) {

    //フロントページ
    // case is_front_page():
    //   $arr[ $pos ] = [
    //     'url' => $post_url,
    //     'name' => $post_title,
    //   ];
    //   break;

    //カテゴリー、タグ、タクソノミーのアーカイブ
    case is_category():
    case is_tag():
    case is_tax():
      if( $object->parent !== 0 ) {
        $ancestors_id = array_reverse( get_ancestors( $object->term_id, $object->taxonomy ) );
        foreach ( $ancestors_id as $id ) {
          $pos = $pos + 1;
          $arr[ $pos ] = [
            'name' => get_term( $id, $object->taxonomy )->name,
            'url' => get_term_link( $id, $object->taxonomy ),
          ];
        }
      }
      $arr[ $pos + 1 ] = [
        'name' => get_term( $object->term_id, $object->taxonomy )->name . $page_count_name,
        'url' => rtrim( get_term_link( $object->term_id, $object->taxonomy ), '/' ) . $page_count_url,
      ];
      break;

    //オーサーアーカイブ
    case is_author():
      $arr[ $pos + 1 ] = [
        'name' => $object->display_name . $page_count_name,
        'url' => rtrim( get_author_posts_url($object->ID), '/' ) . $page_count_url,
      ];
      break;

  }

  $elm = [];
  foreach( $arr as $key => $value ) {
    $elm[] = '{
      "@type": "ListItem",
      "position": ' . $key . ',
      "name": ' . $value['name'] . ',
      "item": ' . $value['url'] . '
    }';
  }
  $elm = implode( ',', $elm );


  //-------- dev mode --------------------
  // echo '<pre>'.$elm.'</pre>';
  echo '<pre>';var_dump($arr);echo'</pre>';
  // var_dump( $object );
  // var_dump( $arr );
  return;
  //-------- dev mode --------------------

}

?>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [ <?php echo $elm; ?> ]
}
</script>
