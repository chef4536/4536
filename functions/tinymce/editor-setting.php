<?php

//TinyMCEエディタの拡張
add_filter('before_wp_tiny_mce', function($init) {
    ob_start();
    require_once(get_template_directory() . '/css/inline.min.css');
    $admin_style_color = ob_get_clean();
    $css = $admin_style_color.add_inline_style_4536();
    $css = str_replace('#contents-inner', 'body', $css );
    $css = str_replace('.article-body', '', $css );
    if( get_option('first_tinymce_active_editor') && !get_user_option('rich_editing') ) { ?>
    <script>
        $(function() {
            if(!tinyMCE.activeEditor) $('.wp-editor-wrap .switch-tmce').trigger('click');
        })
    </script>
    <?php } ?>
    <script>
        $(window).load(function() {
            tinyMCE.activeEditor.dom.addStyle( <?php echo json_encode($css); ?> );
        });
    </script>
<?php });

//クラスやIDを追加
add_filter( 'tiny_mce_before_init', function($initArray) {
	$initArray['body_id'] = 'primary'; // id
	$initArray['body_class'] = 'edit-post-visual-editor post simple1 simple2 simple3 pop cool cool2 cool3'; // class
	return $initArray;
});

//管理画面にCSS追加
add_action( 'after_setup_theme', function() {
    add_editor_style('style.css'); //メインのCSS
    add_editor_style('editor-style.css'); //管理画面のCSS
    $custom_font = (add_google_fonts()) ? '|'.add_google_fonts() : '';
    $font_url[] = '//fonts.googleapis.com/css?family=Nunito'.$custom_font;
    $font_url[] = '//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css';
    $font_url = str_replace( ',', '%2C', $font_url );
    add_editor_style( $font_url );
});
