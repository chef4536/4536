<?php

add_filter( 'inline_style_4536', function( $css ) {

  global $post;
  $content = wpautop($post->post_content);

  //Googleフォント
  if(add_google_fonts()) $css[] = is_google_fonts().'{font-family:"'.add_google_fonts().'" !important}';

  //横幅とレイアウト
  if(is_singular()) {
      $custom_layout = get_post_meta($post->ID,'singular_layout_select',true);
      $body_width = body_width('body_width_singular');
      $custom_body_width = get_post_meta($post->ID,'singular_body_width_select',true);
      if($custom_body_width) $body_width = $custom_body_width;
  } elseif(is_archive()||is_search()) {
      $body_width = body_width('body_width_archive');
  } else {
      $body_width = body_width('body_width_home');
  }
  $width = str_replace('width-', '', $body_width);
  $body_width = '.'.$body_width.' ';
  $css[] = $body_width.'#header-image,'.$body_width.'#wrapper,'.$body_width.'.inner{max-width:'.$width.'px}';

  //アイキャッチ画像
  if(is_singular() && has_post_thumbnail()) {
      $src = get_the_post_thumbnail_4536()['src'];
      $class = get_the_post_thumbnail_4536()['class'];
      $padding = get_image_width_and_height_4536($src)['height'] / get_image_width_and_height_4536($src)['width'] * 100 . '%';
      if(is_likebox()||is_twitter_follow()||is_feedly_follow()||is_post_thumbnail_4536()==='background_image') {
          $css[] = '.'.$class.'{background-image:url("'.$src.'")}';
      }
      if(is_post_thumbnail_4536()==='background_image') $css[] = '#post-thumbnail-4536{height:0;padding-top:'.$padding.'}';
  }

  //ヘッダー背景画像
  if(header_background_url()) {
      $height_mobile = header_background_height_mobile();
      $height_pc = header_background_height_pc();
      $height_mobile = mb_convert_kana(strip_tags($height_mobile), 'n');
      $height_pc = mb_convert_kana(strip_tags($height_pc), 'n');
      $height_mobile = ($height_mobile && ctype_digit($height_mobile)) ? ';height:'.$height_mobile.'px' : '';
      $css[] = '#header{background-image:url("'.header_background_url().'");background-size:'.header_background_size().';background-position:'.header_background_position().';background-repeat:'.header_background_repeat().$height_mobile.'}';
      if($height_pc && ctype_digit($height_pc)) {
          $css[] =  '@media screen and (min-width: 768px) {#header{height:'.$height_pc.'px}}';
      }
  }

  //ヘッダー画像があれば
  if(has_header_image()) $css[] = '#header-image img{display:block;margin:0 auto}';

  //ディスクリプションがあったら
  if( (is_home() || is_front_page()) && !is_paged() && is_home_description() ) $css[] = '#top-description{font-style:italic;font-size:14px;text-align:center;line-height:1.4;margin:1em auto}';

  //文字丸める
  if(line_clamp()=='2line') $css[] = '.line-clamp-2{display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;overflow:hidden}';
  if(line_clamp()=='3line') $css[] = '.line-clamp-3{display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:3;overflow:hidden}';

  //吹き出し
  if(balloon_image_style_option()==='border_border_radius') { //吹き出し画像を丸くする
      $css[] = '.balloon figure img{border:1px solid #aaa;border-radius:50%}';
  }
  if(balloon_image_size()==='60') {
      $css[] = '.balloon-image-left,.balloon-image-right{width:60px}';
  } elseif(balloon_image_size()==='80') {
      $css[] = '.balloon-image-left,.balloon-image-right{width:80px}.balloon-text-right,.balloon-text-left{max-width:-webkit-calc(100% - 140px);max-width:calc(100% - 140px)}';
  } elseif(balloon_image_size()==='100') {
      $css[] = '.balloon-image-left,.balloon-image-right{width:100px}.balloon-text-right,.balloon-text-left{max-width:-webkit-calc(100% - 160px);max-width:calc(100% - 160px)}';
  }

  //ブログカードの背景画像
  if(blogcard_thumbnail_display()==='background-image') {
      $res = preg_match_all('/^(<p>)?(<a.+?>)?https?:\/\/'.preg_quote(get_this_site_domain_4536()).'\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+(<\/a>)?(<\/p>)?(<br ? \/>)?$/im', $content, $m);
      if($res) {
          foreach ($m[0] as $match) {
              $url = strip_tags($match);//URL
              $id = url_to_postid($url);//IDを取得（URLから投稿ID変換）
              if(!$id) continue;//IDを取得できない場合はループを飛ばす
              $src = get_the_post_thumbnail_url($id);
              if(empty($src)) get_some_image_url_4536($content);
              $class = get_thumbnail_class_4536($src);
              $css[] = '.'.$class.'{background-image:url("'.$src.'")}';
          }
      }
  }


  //カエレバの背景画像
  if((kaereba_convert()==='amp' && is_amp()) || kaereba_convert()==='singular_amp') {
      $search = '/<div class="(kaerebalink-image|booklink-image)".*?><a.+?><img.+?\/?><\/a><\/div>/i';
      $kaereba_search = preg_match_all($search, $content, $match);
      if($kaereba_search || is_admin()) {
          foreach($match[0] as $kaereba_image) {
              $img = null;
              $src = null;
              $class = null;
              if(preg_match('/<img.+?src=["\']([^"\']+?)["\'].+?\/?>/i', $kaereba_image, $image)) $src = $image[1];
              $class = get_thumbnail_class_4536($src);
              $css[] = '.'.$class.'{background-image:url("'.$src.'")}';
          }
      }
  }
  if(kaereba_design()==='amp' && is_amp() || kaereba_design()==='singular_amp') {
      $css[] = '.booklink-box,.kaerebalink-box{width:100%;margin:0 0 2em;padding:1em 1em 0 1em !important;border:1px solid;border-color:#eaeaea #ddd #d0d0d0;border-radius:2px;font-size:small;overflow: hidden;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-flow:row wrap;flex-flow:row wrap}.booklink-box:after,.kaerebalink-box:after{content:"";display:block;visibility:hidden;height:0;clear:both}.booklink-image-4536,.kaerebalink-image-4536{width:30%;display:-webkit-box;display:-ms-flexbox;display:flex;margin:0 1em 1em 0 !important}.booklink-image-4536 a,.kaerebalink-image-4536 a{width:100%;display:-webkit-box;display:-ms-flexbox;display:flex}.booklink-image-thumbnail,.kaerebalink-image-thumbnail{width:100%;background-repeat:no-repeat;background-position:center;background-size:contain}.booklink-info,.kaerebalink-info{margin:0 0 1em 0 !important;-webkit-box-flex:1;-ms-flex:1;flex:1}.booklink-name,.kaerebalink-name{font-weight:700;margin-bottom:10px}.booklink-name p,.kaerebalink-name p{margin-bottom:10px;line-height:1.4}.booklink-name a:hover,.kaerebalink-name a:hover{text-decoration:underline}.booklink-powered-date,.kaerebalink-powered-date{font-size:10px;font-weight:400}.booklink-detail{font-size:10px;margin-bottom:10px}.booklink-link2,.kaerebalink-link1{margin-top:10px;width:100%;text-align:center}.booklink-link2 div,.kaerebalink-link1 div{display:block !important;margin:5px 0 !important;line-height:1.4}.booklink-link2 div a,.kaerebalink-link1 div a{display:block;padding:10px;color:#fff}.shoplinkamazon a{background:#f90}.shoplinkkindle a{background:#1882c9}.shoplinkrakuten a{background:#bf0000}.shoplinkrakukobo a{background:#ff2626}.shoplinkyahoo a{background:#fc1d2f}.shoplinkyahooAuc a{color:#252525 !important;background:#ffdb00}.shoplinkwowma a{background:#f02d1f}.shoplinkseven a{background:#225093}.shoplinkbellemaison a{background:#83be00}.shoplinkcecile a{background:#6b053d}.shoplinkkakakucom a{background:#00138e}.shoplinkbk1 a{background:#0484d2}.shoplinkehon a{background:#00006a}.shoplinkkino a{background:#003e9d}.shoplinkjun a{color:#4b5854 !important;background:#d8c9b7}.shoplinktoshokan a{background:#29b6e9}'.
      '@media screen and (min-width: 768px) {.booklink-link2 div,.kaerebalink-link1 div{float:left;width:49%}.booklink-link2 div:nth-child(odd),.kaerebalink-link1 div:nth-child(odd){margin-right:2%!important}}';
  }

  //if(is_admin()) echo $css;

  //Gutenberg
  if(is_amp()) {
      if(preg_match_all('/<div.+?class=".*?wp-block-cover.*?".*?>/i', $content, $matches)) {
          foreach($matches[0] as $cover_block) {
              preg_match('/style=".*?background-image:url\((.+?)\).*?"/i', $cover_block, $url);
              $url = $url[1];
              $class = get_thumbnail_class_4536($url);
              $css[] = '.'.$class.'{background-image:url("'.$url.'")}';
          }
      }
  }

  if(thumbnail_display()==='background-image') {

      //Music
      $media_args = [
          'posts_per_page' => -1,
          'post_type' => 'music',
      ];
      $media_custom_posts = get_posts($media_args);
      //Movie
      $media_args = [
          'posts_per_page' => -1,
          'post_type' => 'movie',
      ];
      $media_custom_posts = array_merge($media_custom_posts,get_posts($media_args));
      //ループ
      if($media_custom_posts && !is_admin()) {
          foreach($media_custom_posts as $post) : setup_postdata( $post );
          $src = thumbnail_4536($post->post_type)['src'];
          $class = thumbnail_4536($post->post_type)['class'];
          $css[] = '.'.$class.'{background-image:url("'.$src.'")}';
          endforeach;
          wp_reset_postdata();
      }

      //Pickup
      $pickup_args = [
          'posts_per_page'=> -1,
          'post__not_in' => [get_the_ID()],
          'tag' => 'pickup',
      ];
      $pickup_custom_posts = get_posts($pickup_args);
      //ループ
      if($pickup_custom_posts && !is_admin()) {
          foreach($pickup_custom_posts as $post) : setup_postdata( $post );
          $src = thumbnail_4536('pickup')['src'];
          $class = thumbnail_4536('pickup')['class'];
          $css[] = '.'.$class.'{background-image:url("'.$src.'")}';
          endforeach;
          wp_reset_postdata();
      }

      //投稿記事
      $num = get_option('posts_per_page'); //取得件数
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      $off_set = ($paged == 1) ? 0 : $paged * $num - $num;
      $new_post_list_style = new_post_list_style_pc();
      if(new_post_list_style_mobile()==='big') $new_post_list_style = 'big';
      $new_post_args = [
          'posts_per_page' => $num,
          'offset' => $off_set,
      ];
      if(is_home()) $new_custom_posts = get_posts($new_post_args);
      //ループ
      if($new_custom_posts && !is_admin()) {
          foreach($new_custom_posts as $post) : setup_postdata( $post );
          $src = thumbnail_4536($new_post_list_style)['src'];
          $class = thumbnail_4536($new_post_list_style)['class'];
          $css[] = '.'.$class.'{background-image:url("'.$src.'")}';
          endforeach;
          wp_reset_postdata();
      }

      //関連記事
      $categories = get_the_category($post->ID);
      $category_ID = [];
      foreach($categories as $category) {
          $category_ID[] = $category->cat_ID;
      }
      $related_post_list_style = related_post_list_style_pc();
      if(related_post_list_style_mobile()==='big') $related_post_list_style = 'big';
      $related_args = [
          'post__not_in' => [get_the_ID()],
          'posts_per_page' => related_post_count(),
          'category__in' => $category_ID,
          'orderby' => 'relevance',
      ];
      if(is_single() && !empty(related_post_count())) $related_custom_posts = get_posts($related_args);
      //ループ
      if($related_custom_posts && !is_admin()) {
          foreach($related_custom_posts as $post) : setup_postdata( $post );
          $src = thumbnail_4536($related_post_list_style)['src'];
          $class = thumbnail_4536($related_post_list_style)['class'];
          $css[] = '.'.$class.'{background-image:url("'.$src.'")}';
          endforeach;
          wp_reset_postdata();
      }

      if(is_archive()) {
          //カテゴリーアーカイブ
          $customPosts = [];
          $args = [
              'posts_per_page' => $num,
              'offset' => $off_set,
              'category' => get_query_var('cat'),
          ];
          if(is_category()) $customPosts = get_posts($args);
          //タグ
          $args = [
              'posts_per_page' => $num,
              'offset' => $off_set,
              'tag' => get_query_var('tag'),
          ];
          if(is_tag()) $customPosts = array_merge($customPosts,get_posts($args));
          //検索
          $args = [
              'posts_per_page' => $num,
              'offset' => $off_set,
              's' => get_query_var('s'),
              'orderby' => 'relevance',
              'post_type' => 'any',
          ];
          if(is_search()) $customPosts = array_merge($customPosts,get_posts($args));
          //年
          $args = [
              'posts_per_page' => $num,
              'offset' => $off_set,
              'year' => get_query_var('year'),
          ];
          if(is_year()) $customPosts = array_merge($customPosts,get_posts($args));
          //月
          $args = [
              'posts_per_page' => $num,
              'offset' => $off_set,
              'year' => get_query_var('year'),
              'monthnum' => get_query_var('monthnum'),
          ];
          if(is_month()) $customPosts = array_merge($customPosts,get_posts($args));
          //日付
          $args = [
              'posts_per_page' => $num,
              'offset' => $off_set,
              'year' => get_query_var('year'),
              'monthnum' => get_query_var('monthnum'),
              'day' => get_query_var('day'),
          ];
          if(is_day()) $customPosts = array_merge($customPosts,get_posts($args));
          //著者
          $args = [
              'posts_per_page' => $num,
              'offset' => $off_set,
              'author' => get_query_var('author'),
          ];
          if(is_author()) $customPosts = array_merge($customPosts,get_posts($args));
          //ループ
          $archive_post_list_style = archive_post_list_style_pc();
          if(archive_post_list_style_mobile()==='big') $archive_post_list_style = 'big';
          if($customPosts && !is_admin()) {
              foreach($customPosts as $post) : setup_postdata( $post );
              $src = thumbnail_4536($archive_post_list_style)['src'];
              $class = thumbnail_4536($archive_post_list_style)['class'];
              $css[] = '.'.$class.'{background-image:url("'.$src.'")}';
              endforeach;
              wp_reset_postdata();
          }
      }

      //ウィジェット
      $widget_custom_posts = [];
      //新着記事
      $widget_args = [
          'posts_per_page' => widget_post_count_4536()['new_post_count'],
          'list_style' => 'widget',
      ];
      if(is_active_widget( false, false, 'new_post', true )) $widget_custom_posts = get_posts($widget_args);
      //ピックアップ
      $widget_args = [
          'posts_per_page' => widget_post_count_4536()['pickup_post_count'],
          'orderby' => 'relevance',
          'post__not_in' => [get_the_ID()],
          'tag' => [
              'pickup-sidebar',
              'pickup-widget',
          ],
          'list_style' => 'widget',
      ];
      if(is_active_widget( false, false, 'pickup_post', true )) $widget_custom_posts = array_merge($widget_custom_posts,get_posts($widget_args));
      //ループ
      if($widget_custom_posts && !is_admin()) {
          foreach($widget_custom_posts as $post) : setup_postdata( $post );
          $src = thumbnail_4536('widget')['src'];
          $class = thumbnail_4536('widget')['class'];
          $css[] = '.'.$class.'{background-image:url("'.$src.'")}';
          endforeach;
          wp_reset_postdata();
      }


  } // background-image一覧サムネ

  //前後の記事のサムネ
  $true = next_prev_in_same_term();
  $prevpost = get_previous_post($true); //前の記事
  $nextpost = get_next_post($true); //次の記事
  $list = [
      wp_get_attachment_url( get_post_thumbnail_id($prevpost->ID) ),
      wp_get_attachment_url( get_post_thumbnail_id($nextpost->ID) ),
  ];
  if(is_singular() && !is_admin() && thumbnail_display()==='background-image') {
      foreach($list as $src) {
          $class = get_thumbnail_class_4536($src);
          if($src) $css[] = '.'.$class.'{background-image:url("'.$src.'")}';
      }
  }

  //メディアセクション使ってるかどうか
  if(!is_admin()) {
      ob_start();
      get_template_part('template-parts/movie');
      $movie = ob_get_clean();
      ob_start();
      get_template_part('template-parts/music');
      $music = ob_get_clean();
      ob_start();
      get_template_part('template-parts/pickup');
      $pickup = ob_get_clean();
  }
  if($movie||$music||$pickup) {
      $css[] = '.media-section{position:relative;overflow:auto;clear:both;padding-bottom:1.5em}.media-section-title{margin:1em auto;font-size:20px;text-align:center}.media-content{display:inline-table;margin-right:10px;vertical-align:top}.media-content a{display:block}.media-content:last-child{margin-right:0}.media-content .post-info{margin-top:10px}.media-content .post-info .media-content-title{white-space:normal;font-size:9pt}';
  }
  if($movie) $css[] = '#movie{border-bottom:1px solid #000}.movie-content{width:196px}.thumbnail-movie-4536{width:196px;height:110px}';
  if($music) $css[] = '#music{border-bottom:1px solid #000}.music-content{width:150px}.thumbnail-music-4536{width:150px;height:150px}';
  if($pickup) {
      $height = (thumbnail_size()=='thumbnail') ? '150' : '113' ;
      $background = '';
      if(thumbnail_display()==='background-image') $background = '.pickup-content .thumbnail.background-thumbnail-4536{width:100%;height:0;padding-top:100%}.pickup-content .thumbnail-wide.background-thumbnail-4536{width:100%;height:0;padding-top:75%}';
      $css[] = '.pickup-content{width:150px}.thumbnail-pickup-4536{width:150px;height:'.$height.'px}'.$background;
  }

  //コピー禁止
  if( copy_guard() ) $css[] = 'body{-webkit-touch-callout:none;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}';

  //固定フッター
  if( fixed_footer() ) $css[] = '.footer{padding-bottom:60px}';

  //固定シェアボタン
  if( fixed_footer()==='share' ) $css[] = '#fixed-share-button-mask{position:absolute;top:0;left:0;right:0;bottom:0;opacity:.9;z-index:-1}';

  return $css;

});
