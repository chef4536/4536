<?php
if (fixed_footer()!=='menu') {
    return;
}
if (empty(fixed_footer_menu_item('share'))) {
    return;
}
?>
<div id="fixed-footer-share-menu-contents">
    <input id="share-menu-toggle" type="checkbox" data-display="none">
    <label id="share-menu-mask" for="share-menu-toggle" class="mask t-0 b-0 r-0 l-0" data-display="none" data-position="absolute" data-bg-color="black"></label>
    <div id="fixed-footer-sns" data-display="none" class="pa-4 b-0 r-0 l-0" data-bg-color="white">
        <?php sns_button_4536(); ?>
        <label data-display="flex" data-justify-content="center" data-align-items="center" for="share-menu-toggle" class="flex close-button pt-4"><?php echo icon_4536('close', '', 24); ?>CLOSE</label>
    </div>
</div>
