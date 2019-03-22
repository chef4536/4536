<?php

add_action('customize_register', function( $wp_customize ) {

	/*	テーマカスタマイザーにテキストエリア追加
	/*-------------------------------------------*/
	if( class_exists('WP_Customize_Control') ):
		class Textarea_Control extends WP_Customize_Control {
			public $type = 'textarea';
			public function render_content() { ?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<textarea rows="13" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
				</label>
			<?php }
		}
	endif;

	//既存のセクションに追加
	//ロゴ画像
  $wp_customize->add_setting( 'header_logo_url' );
  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_logo_url', [
    'section' => 'header_image',
    'settings' => 'header_logo_url',
    'label' => 'ロゴ画像',
    'description' => '（横幅238px・高さ48px）',
  ]));
  //ヘッダー背景画像
  $wp_customize->add_setting( 'header_background_url' );
  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_background_url', [
	  'section' => 'header_image',
	  'settings' => 'header_background_url',
	  'label' => 'ヘッダー背景画像',
  ]));
  //ヘッダー背景画像の大きさ
  $wp_customize->add_setting( 'header_background_size', [
    'default' => 'cover',
  ]);
  $list = [
    'cover' => 'フルスクリーン',
    'auto' => '元の大きさ',
    'contain' => '画面に合わせる',
  ];
  $wp_customize->add_control( 'header_background_size', [
    'section' => 'header_image',
    'settings' => 'header_background_size',
    'label' => '画像のサイズ',
    'type' => 'select',
    'choices' => $list,
  ]);
  //ヘッダー背景画像の位置
  $wp_customize->add_setting( 'header_background_position', [
    'default' => 'center center',
  ]);
  $list = [
    'left top' => '左上',
    'center top' => '上',
    'right top' => '右上',
    'left center' => '左',
    'center center' => '中央',
    'right center' => '右',
    'left bottom' => '左下',
    'center bottom' => '下',
    'right bottom' => '右下',
  ];
  $wp_customize->add_control( 'header_background_position', [
    'section' => 'header_image',
    'settings' => 'header_background_position',
    'label' => '画像の位置',
    'type' => 'select',
    'choices' => $list,
  ]);
  //ヘッダー背景画像の繰り返し
  $wp_customize->add_setting( 'header_background_repeat', [
    'default' => 'no-repeat',
  ]);
  $list = [
    'no-repeat' => '繰り返さない',
    'repeat' => '繰り返す',
  ];
  $wp_customize->add_control( 'header_background_repeat', [
    'section' => 'header_image',
    'settings' => 'header_background_repeat',
    'label' => '画像の繰り返し',
    'type' => 'select',
    'choices' => $list,
  ]);
  //ヘッダー背景画像の高さ
  $list = [
    'mobile' => 'スマホ',
    'pc' => 'PC',
  ];
  foreach($list as $device => $desc) {
    $wp_customize->add_setting( 'header_background_height_'.$device, [
      'default' => null,
    ]);
    $wp_customize->add_control( 'header_background_height_'.$device, [
      'section' => 'header_image',
      'settings' => 'header_background_height_'.$device,
      'label' => '画像の高さ（'.$desc.'）',
      'description' => '背景画像の高さを明確に指定したい場合だけ数値を入力。未入力の場合は中の要素分の高さになります。',
      'type' => 'text',
    ]);
  }

	//デザイン設定
	$wp_customize->add_section( 'design', [
    'title' => 'デザイン',
    'priority' => 20,
	]);
  //レイアウトリスト
  $layout_list = [
      'left-content' => '2カラム（右サイドバー：デフォルト）',
      'right-content' => '2カラム（左サイドバー）',
      'center-content' => '1カラム（サイドバーなし）',
  ];
  //トップページレイアウト
  $wp_customize->add_setting( 'layout_home', [
      'default' => 'left-content',
  ]);
  $wp_customize->add_control( 'layout_home', [
      'section' => 'design',
      'settings' => 'layout_home',
      'label' =>'トップページのレイアウト（PC）',
      'type' => 'select',
      'choices'    => $layout_list,
  ]);
  //記事レイアウト
  $wp_customize->add_setting( 'layout_singular', [
      'default' => 'left-content',
  ]);
  $wp_customize->add_control( 'layout_singular', [
      'section' => 'design',
      'settings' => 'layout_singular',
      'label' =>'記事のレイアウト（PC）',
      'type' => 'select',
      'choices'    => $layout_list,
  ]);
  //アーカイブページレイアウト
  $wp_customize->add_setting( 'layout_archive', [
      'default' => 'left-content',
  ]);
  $wp_customize->add_control( 'layout_archive', [
      'section' => 'design',
      'settings' => 'layout_archive',
      'label' =>'アーカイブページのレイアウト（PC）',
      'type' => 'select',
      'choices'    => $layout_list,
  ]);
  $width_list = [
      'width-780' => '780px',
      'width-880' => '880px',
      'width-980' => '980px',
      'width-1080' => '1080px（デフォルト）',
      'width-1180' => '1180px',
      'width-1280' => '1280px',
      'width-1380' => '1380px',
      'width-1480' => '1480px',
  ];
  //トップ横幅
  $wp_customize->add_setting( 'body_width_home', array (
      'default' => 'width-1080',
  ));
  $wp_customize->add_control( 'body_width_home', array(
      'section' => 'design',
      'settings' => 'body_width_home',
      'label' =>'トップページの横幅（最大幅）',
      'type' => 'select',
      'choices'    => $width_list,
  ));
  //シングル横幅
  $wp_customize->add_setting( 'body_width_singular', array (
      'default' => 'width-1080',
  ));
  $wp_customize->add_control( 'body_width_singular', array(
      'section' => 'design',
      'settings' => 'body_width_singular',
      'label' =>'記事の横幅（最大幅）',
      'type' => 'select',
      'choices'    => $width_list,
  ));
  //アーカイブ横幅
  $wp_customize->add_setting( 'body_width_archive', array (
      'default' => 'width-1080',
  ));
  $wp_customize->add_control( 'body_width_archive', array(
      'section' => 'design',
      'settings' => 'body_width_archive',
      'label' =>'アーカイブページの横幅（最大幅）',
      'type' => 'select',
      'choices'    => $width_list,
  ));
  //記事一覧のデザインスマホ
  $post_style_list = [
      null => 'シンプル（デフォルト）',
      'big' => 'ビッグ（1列）',
  ];
  //トップページモバイル
  $wp_customize->add_setting( 'new_post_list_style_mobile', [
      'default' => null,
  ]);
  $wp_customize->add_control( 'new_post_list_style_mobile', [
      'section' => 'design',
      'settings' => 'new_post_list_style_mobile',
      'label' => '新着記事一覧デザイン（スマホ）',
      'type' => 'select',
      'choices' => $post_style_list,
  ]);
  //アーカイブページモバイル
  $wp_customize->add_setting( 'archive_post_list_style_mobile', [
      'default' => null,
  ]);
  $wp_customize->add_control( 'archive_post_list_style_mobile', [
      'section' => 'design',
      'settings' => 'archive_post_list_style_mobile',
      'label' => 'アーカイブ記事一覧デザイン（スマホ）',
      'type' => 'select',
      'choices' => $post_style_list,
  ]);
  //関連記事モバイル
  $wp_customize->add_setting( 'related_post_list_style_mobile', [
      'default' => null,
  ]);
  $wp_customize->add_control( 'related_post_list_style_mobile', [
      'section' => 'design',
      'settings' => 'related_post_list_style_mobile',
      'label' => '関連記事一覧デザイン（スマホ）',
      'type' => 'select',
      'choices' => $post_style_list,
  ]);
  //PC用
  $post_style_list += [
      '2-5' => '2列',
      '3-3' => '3列',
      '4-2' => '4列',
  ];
  unset($post_style_list['big']);
  //トップページPC
  $wp_customize->add_setting( 'new_post_list_style_pc', [
      'default' => null,
  ]);
  $wp_customize->add_control( 'new_post_list_style_pc', [
      'section' => 'design',
      'settings' => 'new_post_list_style_pc',
      'label' => '新着記事一覧デザイン（PC）',
      'type' => 'select',
      'choices' => $post_style_list,
  ]);
  //アーカイブページPC
  $wp_customize->add_setting( 'archive_post_list_style_pc', [
      'default' => null,
  ]);
  $wp_customize->add_control( 'archive_post_list_style_pc', [
      'section' => 'design',
      'settings' => 'archive_post_list_style_pc',
      'label' => 'アーカイブ記事一覧デザイン（PC）',
      'type' => 'select',
      'choices' => $post_style_list,
  ]);
  //関連記事PC
  $wp_customize->add_setting( 'related_post_list_style_pc', [
      'default' => null,
  ]);
  $wp_customize->add_control( 'related_post_list_style_pc', [
      'section' => 'design',
      'settings' => 'related_post_list_style_pc',
      'label' => '関連記事一覧デザイン（PC）',
      'type' => 'select',
      'choices' => $post_style_list,
  ]);
  //関連記事の表示数
  $wp_customize->add_setting( 'related_post_count', [
      'default' => 10,
  ]);
  $wp_customize->add_control( 'related_post_count', [
      'section' => 'design',
      'settings' => 'related_post_count',
      'label' => '関連記事の表示数',
      'description' => '数字のみ入力してください（例：10記事→10、6記事→6、非表示→0または空白）',
      'type' => 'number',
  ]);
  //抜粋の文字数
  $wp_customize->add_setting( 'custom_excerpt_length', [
      'default' => 80,
  ]);
  $wp_customize->add_control( 'custom_excerpt_length', [
      'section' => 'design',
      'settings' => 'custom_excerpt_length',
      'label' => '抜粋の長さ',
      'description' => '数字のみ入力してください（例：100文字→100、200文字→200）',
      'type' => 'number',
  ]);
  //文字を丸める
  $wp_customize->add_setting( 'line_clamp', [
      'default' => null,
  ]);
  $wp_customize->add_control( 'line_clamp', [
      'section' => 'design',
      'settings' => 'line_clamp',
      'label' => '記事一覧のタイトルが指定行より長い場合に文字を省略する',
      'type' => 'radio',
      'choices'    => [
          null => '文字を省略しない',
          '2line' => '2行で省略',
          '3line' => '3行で省略',
      ],
  ]);
  //固定ヘッダー
  $wp_customize->add_setting( 'fixed_header', array (
      'default' => false,
  ));
  $wp_customize->add_control( 'fixed_header', array(
      'section' => 'design',
      'settings' => 'fixed_header',
      'label' =>'固定ヘッダー',
      'type' => 'checkbox',
  ));
  //固定フッター
  $wp_customize->add_setting( 'fixed_footer', [
      'default' => null,
  ]);
  $wp_customize->add_control( 'fixed_footer', [
      'section' => 'design',
      'settings' => 'fixed_footer',
      'label' =>'固定フッター',
      'type' => 'radio',
      'choices' => [
        null => '非表示（デフォルト）',
        'menu' => 'メニューを表示',
				'share' => 'シェアボタン',
        'overlay' => 'オーバーレイ広告',
      ],
  ]);
  //固定フッターメニューリスト
  $fixed_footer_menu_list = [
      'home' => 'ホームに戻る',
      'search' => '検索',
      'share' => 'シェア',
      'slide-menu' => 'スライドメニュー',
      'top' => 'トップに戻る',
      'prev' => '前の記事',
      'next' => '次の記事',
  ];
  foreach ($fixed_footer_menu_list as $default => $name) {
      $wp_customize->add_setting( 'fixed_footer_menu_'.$default, [
          'default' => true,
      ]);
      $wp_customize->add_control( 'fixed_footer_menu_'.$default, [
          'section' => 'design',
          'settings' => 'fixed_footer_menu_'.$default,
          'label' => $name,
          'type' => 'checkbox',
      ]);
  }

//ページ設定
$wp_customize->add_section( 'page_setting', [
    'title' => 'ページ設定',
    'priority' => 30,
]);
    //Googleフォント
    $wp_customize->add_setting( 'add_google_fonts', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'add_google_fonts', [
        'section' => 'page_setting',
        'settings' => 'add_google_fonts',
        'label' => 'Googleフォント追加',
        'description' =>'<a href="https://fonts.google.com/" target="_blank" >Googleフォントの公式サイト</a>を参考にフォント名だけ入力すると、自分の好きなフォントを使用することができます。パラメーター（:800など）を付けると動作しませんので外してください。',
        'type' => 'text',
    ]);
    //Googleフォントの適用箇所
    $wp_customize->add_setting( 'is_google_fonts', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'is_google_fonts', [
        'section' => 'page_setting',
        'settings' => 'is_google_fonts',
        'label' =>'Googleフォントの適用箇所',
        'type' => 'select',
        'choices' => [
            null => '選択してください',
            'body' => 'すべてのフォントに適用',
            '#sitename a' => 'サイトのタイトル',
            'h2,h3,h4,h5' => '見出し',
        ],
    ]);
    //同じカテゴリ内でリンク
    $wp_customize->add_setting( 'next_prev_in_same_term', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'next_prev_in_same_term', [
        'section' => 'page_setting',
        'settings' => 'next_prev_in_same_term',
        'label' =>'前後記事のリンク',
        'type' => 'radio',
        'choices'    => [
            null => 'すべての記事（デフォルト）',
            'true' => '同じカテゴリだけ',
        ],
    ]);
    //タイトルと日付の順番
    $wp_customize->add_setting( 'post_title_date', [
        'default' => 'title_date',
    ]);
    $wp_customize->add_control( 'post_title_date', [
        'section' => 'page_setting',
        'settings' => 'post_title_date',
        'label' =>'日付とタイトルの順番',
        'type' => 'radio',
        'choices'    => [
            null => '日付→タイトル',
            'title_date' => 'タイトル→日付',
        ],
    ]);
    //検索エンジンに伝える記事の日時
    $wp_customize->add_setting( 'post_datetime', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'post_datetime', [
        'section' => 'page_setting',
        'settings' => 'post_datetime',
        'label' =>'検索エンジンに伝える記事の日時',
        'type' => 'radio',
        'choices'    => [
            null => '公開日',
            'update' => '更新日',
        ],
    ]);
    //投稿日 or 投稿日時
    $wp_customize->add_setting( 'posted_date_datetime', [
        'default' => 'date',
    ]);
    $wp_customize->add_control( 'posted_date_datetime', [
        'section' => 'page_setting',
        'settings' => 'posted_date_datetime',
        'label' =>'投稿日 or 投稿日時',
        'type' => 'radio',
        'choices' => [
            'date' => '投稿日',
            'datetime' => '投稿日時',
        ],
    ]);
    //更新日 or 更新日時
    $wp_customize->add_setting( 'modified_date_datetime', [
        'default' => 'date',
    ]);
    $wp_customize->add_control( 'modified_date_datetime', [
        'section' => 'page_setting',
        'settings' => 'modified_date_datetime',
        'label' =>'更新日 or 更新日時',
        'type' => 'radio',
        'choices' => [
            'date' => '更新日',
            'datetime' => '更新日時',
            null => '非表示',
        ],
    ]);
    //固定ページの投稿日時・更新日時の表示
    $wp_customize->add_setting( 'is_page_time_mtime', [
        'default' => false,
    ]);
    $wp_customize->add_control( 'is_page_time_mtime', [
        'section' => 'page_setting',
        'settings' => 'is_page_time_mtime',
        'label' =>'固定ページに投稿日と更新日を表示する',
        'type' => 'checkbox',
    ]);
    //この記事を書いた人
    $list = [
        'single' => '記事ページ',
        'page' => '固定ページ',
        'media' => 'メディアページ'
    ];
    foreach($list as $post_type => $label) {
        $wp_customize->add_setting( 'profile_'.$post_type, [
            'default' => true,
        ]);
        $wp_customize->add_control( 'profile_'.$post_type, [
            'section' => 'page_setting',
            'settings' => 'profile_'.$post_type,
            'label' =>'プロフィールの表示（'.$label.'）',
            'type' => 'checkbox',
        ]);
    }
    //前後の記事
    $wp_customize->add_setting( 'post_prev_next', [
        'default' => true,
    ]);
    $wp_customize->add_control( 'post_prev_next', [
        'section' => 'page_setting',
        'settings' => 'post_prev_next',
        'label' => '前後の記事を表示する',
        'type' => 'checkbox',
    ]);

//見出し
$wp_customize->add_section( 'heading_style', [
  'title' => '見出し',
  'priority' => 30,
  'description' => '見出しのデザインと色を変更できます。',
]);
    //見出しスタイル
    $h_style_list = [
      null => '装飾なし',
      'simple1' => 'シンプル1',
      'simple2' => 'シンプル2',
      'simple3' => 'シンプル3',
      'pop' => 'ポップ',
      'cool' => 'クール',
      'cool2' => 'クール2',
      'cool3' => 'クール3',
    ];
    //見出しリスト
    $menu_list = [
        null => '1',
        'simple1' => '2',
        'simple2' => '3',
        'simple3' => '4'
    ];
    foreach ($menu_list as $default => $number) {
        $wp_customize->add_setting( 'h'.$number.'_style', [
            'default' => $default,
        ]);
        $wp_customize->add_control( 'h'.$number.'_style', [
            'section' => 'heading_style',
            'settings' => 'h'.$number.'_style',
            'label' =>'記事内見出し'.$number,
            'priority' => $number.'0',
            'type' => 'select',
            'choices' => $h_style_list,
        ]);
    }
    //関連記事タイトル
    $wp_customize->add_setting( 'related_post_title_style', [
        'default' => 'simple1',
    ]);
    $wp_customize->add_control( 'related_post_title_style', [
        'section' => 'heading_style',
        'settings' => 'related_post_title_style',
        'label' => '関連記事のタイトル',
        'priority' => 50,
        'type' => 'select',
        'choices' => $h_style_list,
    ]);
    //ウィジェットタイトル
    $wp_customize->add_setting( 'sidebar_widget_title_style', [
        'default' => 'simple1',
    ]);
    $wp_customize->add_control( 'sidebar_widget_title_style', [
        'section' => 'heading_style',
        'settings' => 'sidebar_widget_title_style',
        'label' => 'ウィジェットのタイトル（本文内以外）',
        'priority' => 60,
        'type' => 'select',
        'choices' => $h_style_list,
    ]);

//メディア設定
$wp_customize->add_section( 'media', [
    'title' => 'メディア関連',
    'description' => '<span style="font-weight:bold">※4536の画像表示に関しての詳細は<a href="https://4536.jp/image-thumbnail" target="_blank" >こちら</a></span>',
    'priority' => 30,
]);

    //サムネイル画像の縦横の比率
    $wp_customize->add_setting( 'thumbnail_size', [
        'default' => 'thumbnail-wide',
    ]);
    $wp_customize->add_control( 'thumbnail_size', [
        'section' => 'media',
        'settings' => 'thumbnail_size',
        'label' => 'サムネイル（記事一覧の画像）の縦と横の比率',
        'type' => 'radio',
        'choices' => [
            'thumbnail-wide' => '横長（デフォルト）',
            'thumbnail' => '正方形',
        ],
    ]);
    //サムネイルの表示方法
    $wp_customize->add_setting( 'thumbnail_display', [
        'default' => 'image',
    ]);
    $wp_customize->add_control( 'thumbnail_display', [
        'section' => 'media',
        'settings' => 'thumbnail_display',
        'label' => 'サムネイルの表示方法',
        'type' => 'radio',
        'choices' => [
            'image' => 'imgタグ（デフォルト）',
            'background-image' => '背景画像',
        ],
    ]);
    //サムネイルの画質
    $wp_customize->add_setting( 'thumbnail_quality', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'thumbnail_quality', [
        'section' => 'media',
        'settings' => 'thumbnail_quality',
        'label' => 'サムネイルの画質',
        'description' => '画質が高くなるほどキレイに表示されますが、若干読み込み速度は下がります。',
        'type' => 'radio',
        'choices' => [
            null => '最適化（デフォルト）',
            'high' => '高画質',
        ],
    ]);
    //NEWアイコン
    $wp_customize->add_setting( 'new_icon_date', [
        'default' => 1,
    ]);
    $wp_customize->add_control( 'new_icon_date', [
        'section' => 'media',
        'settings' => 'new_icon_date',
        'label' => 'NEWアイコンを表示する期間',
        'description' => '数字のみ入力してください（例：1日→1、1週間→7、非表示→未入力）',
        'type' => 'number',
    ]);
    //アイキャッチ画像の表示
    $wp_customize->add_setting( 'is_post_thumbnail', [
        'default' => 'image',
    ]);
    $wp_customize->add_control( 'is_post_thumbnail', [
        'section' => 'media',
        'settings' => 'is_post_thumbnail',
        'label' => 'アイキャッチ画像の表示',
        'description' => '主にフリー素材を使っている場合や本文中で同じ画像を使うことが多い場合は「背景画像」を、それ以外の場合は「通常の画像（imgタグ）」を選択してください。',
        'type' => 'radio',
        'choices' => [
            'image' => 'imgタグ（デフォルト）',
            'background_image' => '背景画像として表示する',
            null => '表示しない',
        ],
    ]);
    //アイキャッチ画像の取得方法
    $wp_customize->add_setting( 'get_post_first_image', [
        'default' => 'get_save',
    ]);
    $wp_customize->add_control( 'get_post_first_image', [
        'section' => 'media',
        'settings' => 'get_post_first_image',
        'label' =>'サムネイルに使用する画像',
        'type' => 'select',
        'choices' => [
            'get_save' => '記事中最初の画像またはYouTube動画を表示（アイキャッチ画像として保存）',
            'get' => '記事中最初の画像を使用（アイキャッチ画像として保存しない）',
            'original' => 'あらかじめアイキャッチ画像をアップロードしてセットする',
            null => 'アイキャッチ画像を設定しない場合はテーマ側の画像を使用',
        ],
    ]);
    //オリジナルのサムネイル
    $wp_customize->add_setting( 'original_thumbnail' );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'original_thumbnail', [
        'section' => 'media',
        'settings' => 'original_thumbnail',
        'label' => 'オリジナルのサムネイル',
    ]));
    //カスタムブログカード
    $wp_customize->add_setting( 'blogcard_thumbnail_display', [
        'default' => 'image',
    ]);
    $wp_customize->add_control( 'blogcard_thumbnail_display', [
        'section' => 'media',
        'settings' => 'blogcard_thumbnail_display',
        'label' =>'オリジナルブログカードの画像の表示方法',
        'type' => 'radio',
        'choices'    => [
            'image' => 'imgタグ（デフォルト）',
            'background-image' => '背景画像',
        ],
    ]);
    //レイジーロード
    $wp_customize->add_setting( 'is_lazy_load', [
        'default' => false,
    ]);
    $wp_customize->add_control( 'is_lazy_load', [
        'section' => 'media',
        'settings' => 'is_lazy_load',
        'label' =>'レイジーロード',
        'description' => '画像（img）とYouTubeなどの動画（iframe）を遅延読み込みします。詳細は<a href="https://4536.jp/lazy-load" target="_blank" >こちらのページ</a>をご覧ください。',
        'type' => 'checkbox',
    ]);

//検索
$wp_customize->add_section( 'search', [
    'title' => '検索機能',
    'priority' => 30,
]);
    //デフォルト検索 or Googleカスタム検索
    $wp_customize->add_setting( 'search_style', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'search_style', [
        'section' => 'search',
        'settings' => 'search_style',
        'label' =>'検索機能切り替え',
        'description' => 'WordPress標準の検索機能か、Googleカスタム検索かを選択できます。',
        'type' => 'radio',
        'choices' => [
            null => 'WordPress標準の検索',
            'google_custom_search' => 'Googleカスタム検索',
        ],
    ]);
    //Googleカスタム検索のコード
    $wp_customize->add_setting( 'google_custom_search_result', [
        'default' => null,
    ]);
    $wp_customize->add_control( new Textarea_Control( $wp_customize, 'google_custom_search_result', [
        'section' => 'search',
        'settings' => 'google_custom_search_result',
        'label' =>'検索結果コードを貼り付けてください。',
    ]));
    //Googleカスタム検索のスラッグ
    $wp_customize->add_setting( 'google_custom_search_slug', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'google_custom_search_slug', [
        'section' => 'search',
        'settings' => 'google_custom_search_slug',
        'label' =>'Googleカスタム検索の結果を表示するページのスラッグを入力してください。',
        'type' => 'text',
    ]);

//SNS関連
$wp_customize->add_section( 'SNS', [
    'title' => 'SNS',
    'priority' => 30,
]);
    //記事上SNSの表示切り替え
    $list = [
        'single' => '記事ページ',
        'page' => '固定ページ',
        'media' => 'メディアページ',
    ];
    foreach($list as $post_type => $label) {
        $wp_customize->add_setting( 'is_sns_top_'.$post_type, [
            'default' => true,
        ]);
        $wp_customize->add_control( 'is_sns_top_'.$post_type, [
            'section' => 'SNS',
            'settings' => 'is_sns_top_'.$post_type,
            'label' =>'記事上にシェアボタンを表示する（'.$label.'）',
            'type' => 'checkbox',
            'priority' => 5,
        ]);
    }
    //記事下SNSの表示切り替え
    foreach($list as $post_type => $label) {
        $wp_customize->add_setting( 'is_sns_bottom_'.$post_type, array (
            'default' => true,
        ));
        $wp_customize->add_control( 'is_sns_bottom_'.$post_type, array(
            'section' => 'SNS',
            'settings' => 'is_sns_bottom_'.$post_type,
            'label' =>'記事下にシェアボタンを表示する（'.$label.'）',
            'type' => 'checkbox',
            'priority' => 5,
        ));
    }
    //SNSデザイン
    $wp_customize->add_setting( 'sns_style', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'sns_style', [
        'section' => 'SNS',
        'settings' => 'sns_style',
        'label' => 'シェアボタンのデザイン',
        'type' => 'select',
        'choices' => [
            null => 'オリジナル',
            'simple1' => 'シンプル1',
            'simple2' => 'シンプル2',
            'rich' => 'リッチ',
        ],
        'priority' => 5,
    ]);
    //シェアタイトル
    $wp_customize->add_setting( 'sns_share_text', array (
        'default' => 'この記事をシェアする',
    ));
    $wp_customize->add_control( 'sns_share_text', array(
        'section' => 'SNS',
        'settings' => 'sns_share_text',
        'label' =>'SNSシェアタイトル',
        'type' => 'text',
        'priority' => 5,
    ));
    //Twitterカード
    $wp_customize->add_setting( 'twitter_card', array (
        'default' => 'summary',
    ));
    $wp_customize->add_control( 'twitter_card', array(
        'section' => 'SNS',
        'settings' => 'twitter_card',
        'label' => 'Twitterカードの形',
        'type' => 'radio',
        'choices'    => [
            'summary' => '小さいカード（正方形の画像）',
            'summary_large_image' => '大きいカード（横長の大きい画像）',
        ],
        'priority' => 10,
    ));
    //Twitterのvia
    $wp_customize->add_setting( 'twitter_via', array (
        'default' => true,
    ));
    $wp_customize->add_control( 'twitter_via', array(
        'section' => 'SNS',
        'settings' => 'twitter_via',
        'label' =>'Twitterのviaを表示する',
        'description' => '記事がTweetされた時の「@〇〇」を表示します。',
        'type' => 'checkbox',
        'priority' => 20,
    ));
    //フォロータイトル
    $wp_customize->add_setting( 'follow_section_title', array (
        'default' => '最新情報をお届けします',
    ));
    $wp_customize->add_control( 'follow_section_title', array(
        'section' => 'SNS',
        'settings' => 'follow_section_title',
        'label' =>'フォロー',
        'type' => 'text',
        'priority' => 40,
    ));
    //いいねボタン
    $wp_customize->add_setting( 'is_likebox', array (
        'default' => false,
    ));
    $wp_customize->add_control( 'is_likebox', array(
        'section' => 'SNS',
        'settings' => 'is_likebox',
        'label' =>'いいねボックスを表示する',
        'description' => 'サイト管理者がプロフィール画面でFacebook（ページ）のIDを入力する必要があります。',
        'type' => 'checkbox',
        'priority' => 50,
    ));
    //Twitterフォローボタン
    $wp_customize->add_setting( 'is_twitter_follow', array (
        'default' => false,
    ));
    $wp_customize->add_control( 'is_twitter_follow', array(
        'section' => 'SNS',
        'settings' => 'is_twitter_follow',
        'label' =>'Twitterフォローボタンを表示する',
        'description' => 'サイト管理者がプロフィール画面でTwitterのIDを入力する必要があります。',
        'type' => 'checkbox',
        'priority' => 60,
    ));
    //Twitterフォローボタン
    $wp_customize->add_setting( 'is_feedly_follow', array (
        'default' => true,
    ));
    $wp_customize->add_control( 'is_feedly_follow', array(
        'section' => 'SNS',
        'settings' => 'is_feedly_follow',
        'label' =>'feedlyフォローボタンを表示する',
        'type' => 'checkbox',
        'priority' => 70,
    ));

//コメント欄
$wp_customize->add_section( 'comments', [
    'title' => 'コメント設定',
]);
    //コメント欄の表示
    $list = [
        'single' => true,
        'page' => false,
        'media' => true,
    ];
    foreach($list as $post_type => $default) {
        $wp_customize->add_setting( 'is_comments_'.$post_type, [
            'default' => $default,
        ]);
    }
    $list = [
        'single' => '記事ページ',
        'page' => '固定ページ',
        'media' => 'メディアページ',
    ];
    foreach($list as $post_type => $label) {
        $wp_customize->add_control( 'is_comments_'.$post_type, [
            'section' => 'comments',
            'settings' => 'is_comments_'.$post_type,
            'label' =>'コメント欄を表示する（'.$label.'）',
            'type' => 'checkbox',
        ]);
    }
    //メールアドレス表示
    $wp_customize->add_setting( 'comments_email', array (
        'default' => true,
    ));
    $wp_customize->add_control( 'comments_email', array(
        'section' => 'comments',
        'settings' => 'comments_email',
        'label' =>'メールアドレス入力欄の表示',
        'type' => 'checkbox',
    ));
    //ウェブサイト削除
    $wp_customize->add_setting( 'comments_website', array (
        'default' => true,
    ));
    $wp_customize->add_control( 'comments_website', array(
        'section' => 'comments',
        'settings' => 'comments_website',
        'label' =>'ウェブサイト入力欄の表示',
        'type' => 'checkbox',
    ));
    //Cookie削除
    $wp_customize->add_setting( 'comments_cookies', array (
        'default' => true,
    ));
    $wp_customize->add_control( 'comments_cookies', array(
        'section' => 'comments',
        'settings' => 'comments_cookies',
        'label' =>'「次回のコメントで使用するため〜」の表示',
        'type' => 'checkbox',
    ));
    //「メールアドレスが公開されることはありません」を削除
    $wp_customize->add_setting( 'comments_mail_address_text', array (
        'default' => true,
    ));
    $wp_customize->add_control( 'comments_mail_address_text', array(
        'section' => 'comments',
        'settings' => 'comments_mail_address_text',
        'label' =>'「メールアドレスが公開されることはありません」の表示',
        'type' => 'checkbox',
    ));

//目次
$wp_customize->add_section( 'table_of_contents', [
    'title' => '目次',
]);
    //読み込み方選択
    $wp_customize->add_setting( 'is_toc', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'is_toc', [
        'section' => 'table_of_contents',
        'settings' => 'is_toc',
        'label' => '目次を表示するページ',
        'description' => '見出し2の手前に表示します。別の場所に表示する場合はウィジェットの目次をお使いください',
        'type' => 'radio',
        'choices'    => [
            null => '読み込まない（デフォルト）',
            'single' => '記事ページのみ',
            'page' => '固定ページのみ',
            'single_page' => '記事ページと固定ページ',
            'singular' => '目次が生成できるすべてのページ',
        ],
    ]);
    //読み込み方選択
    $wp_customize->add_setting( 'toc_headline_level', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'toc_headline_level', [
        'section' => 'table_of_contents',
        'settings' => 'toc_headline_level',
        'label' => '対象の見出し',
        'type' => 'radio',
        'choices'    => [
            null => '見出し2まで',
            'h3' => '見出し3まで',
            'h4' => '見出し4まで',
            'h5' => '見出し5まで',
        ],
    ]);
    //何個以上で表示するか
    $wp_customize->add_setting( 'toc_headline_count', [
        'default' => 3,
    ]);
    $wp_customize->add_control( 'toc_headline_count', [
        'section' => 'table_of_contents',
        'settings' => 'toc_headline_count',
        'label' => 'いくつ見出しがあれば表示するか',
        'type' => 'select',
        'choices'    => [
            1 => '1つ以上',
            2 => '2つ以上',
            3 => '3つ以上',
            4 => '4つ以上',
            5 => '5つ以上',
            6 => '6つ以上',
        ],
    ]);
    //何個以上で表示するか
    $wp_customize->add_setting( 'toc_title', [
        'default' => '目次',
    ]);
    $wp_customize->add_control( 'toc_title', [
        'section' => 'table_of_contents',
        'settings' => 'toc_title',
        'label' => '目次のタイトル',
        'type' => 'text',
    ]);

//ソースコードのハイライト
$wp_customize->add_section( 'code_highlight', array (
    'title' => 'ソースコードのハイライト表示',
));
    //読み込み方選択
    $wp_customize->add_setting( 'is_code_highlight', array (
        'default' => null,
    ));
    $wp_customize->add_control( 'is_code_highlight', array(
        'section' => 'code_highlight',
        'settings' => 'is_code_highlight',
        'label' => 'Highlight.jsの読み込み方',
        'type' => 'radio',
        'choices'    => [
            null => '読み込まない（デフォルト）',
            'all' => 'すべてのページで読み込み',
            'in_category' => '指定したカテゴリーに属するページだけ読み込み',
        ],
    ));
    //カテゴリー選択
    $wp_customize->add_setting( 'code_highlight_category', array (
        'default' => null,
    ));
    $wp_customize->add_control( 'code_highlight_category', array(
        'section' => 'code_highlight',
        'settings' => 'code_highlight_category',
        'label' => 'Highlight.jsを読み込むカテゴリー',
        'description' => 'IDかスラッグを入力してください。複数指定する場合は、半角コンマで区切って入力してください。指定したカテゴリ以外のページでHighlight.jsを読み込みません。',
        'type' => 'text',
    ));

//既存の設定項目に追加
    //サイトに表示するタイトル
    $wp_customize->add_setting( 'site_title', array (
        'default' => null,
    ));
    $wp_customize->add_control( 'site_title', array(
        'section' => 'title_tagline',
        'settings' => 'site_title',
        'label' =>'サイト上に表示するタイトル。',
        'description' => 'サイト上に表示するタイトルを変更できます（入力しない場合は、一般→「サイトタイトル」の文字が表示されます）。検索結果のサイトタイトルには、一般→「サイトタイトル」で入力した文字が使われます。',
        'type' => 'text',
    ));
    //トップページのディスクリプション表示切り替え
    $wp_customize->add_setting( 'is_home_description', array (
        'default' => true,
    ));
    $wp_customize->add_control( 'is_home_description', array(
        'section' => 'title_tagline',
        'settings' => 'is_home_description',
        'label' =>'トップにキャッチフレーズを表示する',
        'type' => 'checkbox',
    ));

//吹き出し
$wp_customize->add_section( 'balloon', array (
    'title' => '吹き出し',
));
    //左からの吹き出し
    $wp_customize->add_setting( 'balloon_left_image' );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'balloon_left_image', [
        'section' => 'balloon',
        'settings' => 'balloon_left_image',
        'label' => '左からの吹き出し画像',
        'priority' => 10,
    ]));
    //左figcaption
    $wp_customize->add_setting( 'balloon_left_figcaption', array (
        'default' => '画像の説明',
    ));
    $wp_customize->add_control( 'balloon_left_figcaption', array(
        'section' => 'balloon',
        'settings' => 'balloon_left_figcaption',
        'label' => '左吹き出し画像下の説明（初期状態）',
        'type' => 'text',
        'priority' => 10,
    ));
    //右からの吹き出し
    $wp_customize->add_setting( 'balloon_right_image' );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'balloon_right_image', [
        'section' => 'balloon',
        'settings' => 'balloon_right_image',
        'label' => '右からの吹き出し画像',
        'priority' => 50,
    ]));
    //右figcaption
    $wp_customize->add_setting( 'balloon_right_figcaption', array (
        'default' => '画像の説明',
    ));
    $wp_customize->add_control( 'balloon_right_figcaption', array(
        'section' => 'balloon',
        'settings' => 'balloon_right_figcaption',
        'label' => '右吹き出し画像下の説明（初期状態）',
        'type' => 'text',
        'priority' => 50,
    ));
    //画像サイズ
    $wp_customize->add_setting( 'balloon_image_size', [
        'default' => '60',
    ]);
    $wp_customize->add_control( 'balloon_image_size', [
        'section' => 'balloon',
        'settings' => 'balloon_image_size',
        'label' => '吹き出し画像の横幅',
        'type' => 'radio',
        'priority' => 100,
        'choices'    => [
            '60' => '60px',
            '80' => '80px',
            '100' => '100px',
        ],
    ]);
    //吹き出し画像加工
    $wp_customize->add_setting( 'balloon_image_style_option', [
        'default' => 'border_border_radius',
    ]);
    $wp_customize->add_control( 'balloon_image_style_option', [
        'section' => 'balloon',
        'settings' => 'balloon_image_style_option',
        'label' => '吹き出し画像のスタイル',
        'type' => 'radio',
        'priority' => 100,
        'choices'    => [
            null => '加工しない',
            'border_border_radius' => '画像を丸くして枠線をつける',
        ],
    ]);

//その他
$wp_customize->add_section( 'etc', array (
    'title' => 'その他',
));
    //JavaScriptの読み込み
    $wp_customize->add_setting( 'javascript_load', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'javascript_load', [
        'section' => 'etc',
        'settings' => 'javascript_load',
        'label' =>'JavaScriptの読み込み方法',
        'description' => '非同期で読み込むことでページの読み込み速度が上がりますが、不具合が生じる場合は同期的に読み込んでください。',
        'type' => 'radio',
        'choices'    => [
            null => '同期',
            'async' => '非同期（async）',
            'defer' => '非同期（defer）',
        ],
    ]);
    //カスタムブログカード
    $wp_customize->add_setting( 'custom_blogcard', [
        'default' => false,
    ]);
    $wp_customize->add_control( 'custom_blogcard', [
        'section' => 'etc',
        'settings' => 'custom_blogcard',
        'label' =>'ブログカード表示切り替え',
        'description' => 'オリジナルのブログカードに変更します。CSSで見た目を調整できます。',
        'type' => 'checkbox',
    ]);
    //コピー禁止
    $wp_customize->add_setting( 'copy_guard', [
        'default' => false,
    ]);
    $wp_customize->add_control( 'copy_guard', [
        'section' => 'etc',
        'settings' => 'copy_guard',
        'label' => 'コピーガード',
        'description' => 'サイト内のコンテンツを選択できないようにしてコピーを防ぎます。',
        'type' => 'checkbox',
    ]);
    //カエレバのタグ変換
    $wp_customize->add_setting( 'kaereba_convert', [
        'default' => 'amp',
    ]);
    $wp_customize->add_control( 'kaereba_convert', [
        'section' => 'etc',
        'settings' => 'kaereba_convert',
        'label' => 'カエレバのタグ変換',
        'type' => 'radio',
        'choices'    => [
            'amp' => 'AMPページだけ変換',
            'singular_amp' => 'AMPページと通常の記事ページ',
        ],
    ]);
    //カエレバのデザイン
    $wp_customize->add_setting( 'kaereba_design', [
        'default' => 'amp',
    ]);
    $wp_customize->add_control( 'kaereba_design', [
        'section' => 'etc',
        'settings' => 'kaereba_design',
        'label' => 'カエレバにオリジナルスタイルを適用',
        'type' => 'radio',
        'choices'    => [
            'amp' => 'AMPページだけ適用',
            'singular_amp' => 'AMPページと通常の記事ページ',
            null => '適用しない（自分でCSSを編集できる方向け）',
        ],
    ]);
    //ウィジェット自動生成解除
    $wp_customize->add_setting( 'is_widget_wpautop', [
        'default' => true,
    ]);
    $wp_customize->add_control( 'is_widget_wpautop', [
        'section' => 'etc',
        'settings' => 'is_widget_wpautop',
        'label' => 'ウィジェットの自動タグ追加機能',
        'description' => 'pタグやbrタグが自動で追加されないようにします。',
        'type' => 'checkbox',
    ]);


});

//カスタムヘッダー
$custom_header = [
    'random-default' => false,
    'width' => 640,
    'height' => 320,
    'flex-height' => true,
    'flex-width' => true,
    'default-text-color' => '',
    'header-text' => false,
    'uploads' => true,
    'default-image' => '',
];
add_theme_support( 'custom-header', $custom_header );
