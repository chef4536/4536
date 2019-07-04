<?php

//テーマカスタマイザー関連
require_once( 'customizer/_init.php' );

//新エディタGutenberg関連
require_once( 'gutenberg/_init.php' );

//埋め込み関連
require_once( 'embed/_init.php' );

//ウィジェット関連
require_once( 'widgets/_init.php' );

//旧エディタTinyMCE関連
require_once( 'tinymce/_init.php' );

//データベース$wpdb関連
require_once( 'db.php' );

//独自のカスタムフィールド
require_once( 'custom-fields.php' );

//OGP
require_once( 'ogp.php' );

//構造化データ
require_once( 'json-ld.php' );

//カスタムフィールドの値を記事一覧に表示する
require_once( 'custom-fields-columns.php' );

//ディスクリプション
require_once( 'description.php' );

//AMP
require_once( 'amp.php' );

//画像・動画関係
require_once( 'img-movie-setting.php' );

//サムネイル
require_once( 'thumbnail.php' );

//レイジーロード
require_once( 'lazy-load.php' );

//アーカイブページのデザイン
require_once( 'archive-template.php' );

//カスタム投稿タイプ
require_once( 'custom-post-type.php' );

//パンくず
require_once( 'breadcrumb.php' );

//ショートコード
require_once( 'shortcode.php' );

//TOC（目次）
require_once( 'toc.php' );

//next,prevの付与
require_once( 'next-prev.php' );

//ページネーション
require_once( 'pagination.php' );

//小物系
require_once( 'setting.php' );

//本文のフィルター
require_once( 'content-filter.php' );

//ユーザー管理
require_once( 'user-profile.php' );

//SNSボタン
require_once( 'sns-button.php' );

//SNSボタン
require_once( 'wave-shape.php' );
