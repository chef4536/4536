<?php
$slug = null;
$query = 's';
$target = null;
if(search_style()==="google_custom_search") {
    $slug = google_custom_search_slug();
    $query = 'q';
}
if( is_amp() && is_ssl() ) $target = 'target="_top"';
$search_form = '<form id="searchform" class="d-f" role="search" method="get" action="'.home_url().'/'.$slug.'" '.$target.'>'.
    '<input type="search" value="'.get_search_query().'" name="'.$query.'" id="'.$query.'" placeholder="キーワード" />'.
    '<button type="submit" id="searchsubmit"><i class="fas fa-search" aria-hidden="true"></i></button>'.
    '</form>';
if( is_amp() && !is_ssl() ) $search_form = null;
echo $search_form;
