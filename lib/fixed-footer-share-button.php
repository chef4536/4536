<?php
if(fixed_footer()!=='menu') return;
if(empty(fixed_footer_menu_item('share'))) return;
?>
<div id="fixed-footer-share-menu-contents">
    <input id="share-menu-toggle" type="checkbox" class="display-none">
    <label id="share-menu-mask" for="share-menu-toggle" class="display-none mask"></label>
    <div id="fixed-footer-menu-sns" class="display-none">
        <?php sns_button_4536('fixed_footer'); ?>
        <label for="share-menu-toggle" class="close-button"><i class="fas fa-times"></i>CLOSE</label>
    </div>
</div>