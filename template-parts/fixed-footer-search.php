<?php
if(fixed_footer()!=='menu') return;
if(empty(fixed_footer_menu_item('search'))) return;
?>
<div id="fixed-search-contents">
    <input id="search-toggle" type="checkbox" class="d-n">
    <label id="search-mask" for="search-toggle" class="d-n mask"></label>
    <div id="fixed-search" class="d-n">
        <div id="fixed-search-form">
            <?php get_search_form(); ?>
        </div>
        <label for="search-toggle" class="close-button"><i class="fas fa-times"></i>CLOSE</label>
    </div>
</div>