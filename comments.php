<div id="comments">
<?php if(have_comments()): ?>
  <p id="comments-title">コメント</p>
  <ol class="comment-list">
      <?php if(is_amp()) {
        $args = [
            'echo' => false
        ];
        $comments = wp_list_comments($args);
        echo convert_content_to_amp($comments);
    } else {
        wp_list_comments();
    } ?>
  </ol>
<?php endif;
    $args = [
        'title_reply' => 'コメントを残す',
        'lavel_submit' => ('Submit Comment'),
    ];
    if(is_amp()) {
        echo '<div id="respond" class="comment-respond">'.
                '<a class="comments-from-amp" href="'.get_the_permalink().'#respond">コメントを残す</a>'.
            '</div>';
    } else {
        comment_form($args);
    }
?>
</div>