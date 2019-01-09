<?php
if(fixed_footer()!=='menu') return;
if(empty(fixed_footer_menu_item('search'))) return;
?>
<div id="fixed-search-contents">
    <input id="search-toggle" type="checkbox" class="display-none">
    <label id="search-mask" for="search-toggle" class="display-none mask"></label>
    <div id="fixed-search" class="display-none">
        <div id="fixed-search-form">
            <?php get_search_form(); ?>
        </div>
        <label for="search-toggle" class="close-button"><i class="fas fa-times"></i>CLOSE</label>
    </div>
</div>