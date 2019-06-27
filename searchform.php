<?php
$slug = null;
$query = 's';
$target = null;
if(search_style()==="google_custom_search") {
    $slug = google_custom_search_slug();
    $query = 'q';
}
if( is_amp() && is_ssl() ) $target = 'target="_top"';
$search_form = '<form id="searchform" data-display="flex" data-align-items="center" class="flex" role="search" method="get" action="'.home_url().'/'.$slug.'" '.$target.'>'.
    '<input type="search" value="'.get_search_query().'" name="'.$query.'" id="'.$query.'" placeholder="キーワード" class="flex pt-2 pb-2" />'.
    '<button type="submit" id="searchsubmit" class="pa-2 l-h-100">' . icon_4536('search', '', 24) .'</button>'.
    '</form>';
if( is_amp() && !is_ssl() ) $search_form = null;
echo $search_form;
