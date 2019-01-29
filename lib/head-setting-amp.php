<html amp>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1,viewport-fit=cover">
        <link rel="canonical" href="<?php the_permalink() ?>" />
        <?php if(!empty(add_google_fonts())) { ?>
        <link href="https://fonts.googleapis.com/css?family=<?php echo add_google_fonts(); ?>" rel="stylesheet">
        <?php } ?>
        <link rel="stylesheet" href="<?php echo fontawesome_url(); ?>" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <?php
        get_template_part('lib/amp-script');
        custom_seo_meta_4536();
        ogp_setting_4536();
        ?>
        <style amp-boilerplate>
            body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}
            }
        </style>
        <noscript>
            <style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style>
        </noscript>
        <?php
        amp_css();
        if( amp_add_html_js_head() ) echo amp_add_html_js_head();
        ?>
    </head>