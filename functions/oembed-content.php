<?php

$data = $wpdb->prepare("
    DELETE FROM $wpdb->postmeta
    WHERE meta_key LIKE %s
    AND meta_value = %s
", '_oembed_%', '{{unknown}}');
//$wpdb->query($data);