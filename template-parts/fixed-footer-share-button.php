<?php
if(fixed_footer()!=='menu') return;
if(empty(fixed_footer_menu_item('share'))) return;
?>
<div id="fixed-footer-share-menu-contents">
    <input id="share-menu-toggle" type="checkbox" class="d-n">
    <label id="share-menu-mask" for="share-menu-toggle" class="d-n mask"></label>
    <div id="fixed-footer-menu-sns" class="d-n">
        <?php sns_button_4536('fixed_footer_menu'); ?>
        <label for="share-menu-toggle" class="close-button"><i class="fas fa-times"></i>CLOSE</label>
    </div>
</div>
