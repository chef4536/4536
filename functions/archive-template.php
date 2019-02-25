<?php

function archive_template_4536($page_4536) { ?>
    <div id="contents-wrapper">
        <div id="contents-inner">
            <main id="main" class="padding-wrap-main-4536" role="main">
                <section id="post-search" class="clearfix">
                    <?php
                    if(is_category()||is_tag()||is_tax()) $title = single_term_title("", false);
                    if(is_day()) $title = get_the_time('Y年m月d日');
                    if(is_month()) $title = get_the_time('Y年m月');
                    if(is_year()) $title = get_the_time('Y年');
                    if(is_author()) $title = esc_html(get_queried_object()->display_name);
                    if(isset($_GET['paged']) && !empty($_GET['paged'])) $title = 'ブログアーカイブ';
                    $title = '<h1 id="archive-title">「'.$title.'」の記事一覧</h1>';
                    global $s;
                    global $wp_query;
                    if(is_search()) $title = '<h1 id="archive-title">「'.esc_html($s).'」の検索結果 '.$wp_query->found_posts.' 件</h1>';
                    if($page_4536==='movie') $title = '<h1 id="archive-title">「'.esc_html(get_option('sub_media_name')).'」一覧</h1>';
                    if($page_4536==='music') $title = '<h1 id="archive-title">「'.esc_html(get_option('main_media_name')).'」一覧</h1>';
                    echo $title; ?>
                    <div class="archive-wrap flexbox-row-wrap">
                        <?php post_list_template_4536($page_4536); ?>
                    </div>
                </section>
                <?php pagination($wp_query->max_num_pages); ?>
            </main>
            <?php
            if($page_4536!=='music') get_template_part('template-parts/music');
            if($page_4536!=='movie') get_template_part('template-parts/movie');
            if(!is_tag('pickup')) get_template_part('template-parts/pickup');
            ?>
        </div>
    </div>
<?php }

function post_list_template_4536($page_4536) {

    $thumbnail_size = $page_4536;

    if($page_4536==='new-post') {
        $post_list_style_mobile = new_post_list_style_mobile();
        $post_list_style_pc = new_post_list_style_pc();
        $thumbnail_size = new_post_list_style_pc();
        if(new_post_list_style_mobile()==='big') $thumbnail_size = 'big';
    } else {
        $post_list_style_mobile = archive_post_list_style_mobile();
        $post_list_style_pc = archive_post_list_style_pc();
        $thumbnail_size = archive_post_list_style_pc();
        if(archive_post_list_style_mobile()==='big') $thumbnail_size = 'big';
    }

    $post_list_style_mobile = ($post_list_style_mobile==='') ? '' : 'list-'.$post_list_style_mobile;
    $post_list_style_pc = ($post_list_style_pc==='') ? ' post-list-pc' : ' list-'.$post_list_style_pc;
    if($post_list_style_mobile===$post_list_style_pc) $post_list_style_pc = '';
    $style = $post_list_style_mobile.$post_list_style_pc;

    $count = '';
    $rand = rand(4, 9);
    $line_clamp = '';
    if(line_clamp()==='2line') $line_clamp = ' line-clamp-2';
    if(line_clamp()==='3line') $line_clamp = ' line-clamp-3';

    if ( have_posts() ) : while ( have_posts() ) : the_post(); $count++;
    $ptime = (posted_date_datetime()==='date') ? get_the_date() : get_the_date().get_the_time(); ?>
        <article class="post-list <?php echo $style; ?>">
            <a class="clearfix" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                <?php echo thumbnail_4536($thumbnail_size)['thumbnail']; ?>
                <div class="post-info">
                    <h2 class="post-title<?php echo $line_clamp; ?>"><?php the_title(); ?></h2>
                    <div class="post-meta">
                        <div class="excerpt display-none">
                            <?php echo custom_excerpt_4536(get_the_content(), custom_excerpt_length()); ?>
                        </div>
                        <?php echo ($ptime) ? '<div class="posted-date"><i class="far fa-calendar-check"></i><span>'.$ptime.'</span></div>' : ''; ?>
                    </div>
                </div>
            </a>
        </article>
        <?php
        if( $count===$rand && $page_4536==='new-post' && is_active_sidebar('sp-infeed-ad') ) { //インフィード広告 ?>
            <div class="post-list clearfix infeed-ad <?php echo $style; ?>">
                <?php dynamic_sidebar('sp-infeed-ad'); ?>
            </div>
        <?php }
    endwhile;
    else:
        echo '<p class="padding-0-1em margin-1em-0">記事がありませんでした。</p>';
    endif;
    wp_reset_postdata();

}
