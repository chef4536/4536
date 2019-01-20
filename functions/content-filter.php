<?php

add_action('the_content', function($content) {
    
    //単純置換
    //ワンポイントフレーム
    $content = str_replace('<i class="fa fa-check-circle-o"></i>', '<i class="far fa-check-circle"></i>', $content);
    
    return $content;
});