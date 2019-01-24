<?php
if(is_amp() && !is_active_sidebar('amp-slide-menu')) return;
if(!is_amp() && !is_active_sidebar('slide-widget')) return;
?>

<div id="slide-contents-4536">
    <input id="slide-toggle" type="checkbox" class="display-none">
    <label id="slide-mask" for="slide-toggle" class="display-none mask"></label>
    <div id="slide-menu">
        <div id="slide-menu-inner">
            <label for="slide-toggle" class="close-button"><i class="fas fa-times"></i>CLOSE</label>
            <?php
            if(is_amp()) {
                if(is_active_sidebar('amp-slide-menu')) dynamic_sidebar('amp-slide-menu');
            } else {
                if(is_active_sidebar('slide-widget')) dynamic_sidebar('slide-widget');
            }
            ?>
        </div>
        <label for="slide-toggle" class="close-button"><i class="fas fa-times"></i>CLOSE</label>
    </div>
</div>
