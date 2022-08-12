<?php
/**
* Plugin Name: FeedWordPress DeDupe
* Plugin URI: https://tugatech.com.pt
* Description: A simple plugin to try avoid duplicates when using FeedWordPress. No settings, just activate and done.
* Version: 1.0
* Author: DJPRMF
* Author URI: https://tugatech.com.pt
**/


/**
 * Lets start avoiding the duplicate posts made by FeedWordPress
 */
 
function fwp_syndication_dedupe($item, $post)
{
    // This is the URL of the original blog post
    $link = $item["guid"];

    // This will search for other posts with the same link in the meta content
    $existing = new WP_Query(array(
        "post_status" => "publish",
        "meta_key" => "syndication_permalink",
        "meta_value" => $link
    ));

    // If a post is found return null to avoid the publish.
    if ($existing->post_count) {
        return null;
    }

    // If the post doesnt exist, continue as normal with the FeedWordPress action
    return $item;
}

add_filter("syndicated_item", "fwp_syndication_dedupe");