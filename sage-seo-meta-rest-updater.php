<?php
/**
 * Plugin Name: Sage SEO Meta REST Updater
 * Description: Adds a REST endpoint to update Yoast SEO meta for posts after n8n publishing.
 * Version: 1.0.0
 * Requires at least: 5.0
 * Tested up to: 6.6
 * Author: Sage IT Developer
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('rest_api_init', function () {
    register_rest_route('sage-seo/v1', '/update-meta', [
        'methods'  => 'POST',
        'callback' => 'sage_seo_update_meta_callback',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        },
        'args' => [
            'post_id' => [
                'required' => true,
                'type' => 'integer',
            ],
        ],
    ]);
});

function sage_seo_update_meta_callback(WP_REST_Request $request) {
    $post_id = intval($request->get_param('post_id'));

    if (!$post_id || get_post_status($post_id) === false) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Invalid post_id',
        ], 400);
    }

    update_post_meta($post_id, '_yoast_wpseo_title', sanitize_text_field((string) $request->get_param('seo_title')));
    update_post_meta($post_id, '_yoast_wpseo_metadesc', sanitize_textarea_field((string) $request->get_param('meta_description')));
    update_post_meta($post_id, '_yoast_wpseo_canonical', esc_url_raw((string) $request->get_param('canonical_url')));
    update_post_meta($post_id, '_yoast_wpseo_opengraph-title', sanitize_text_field((string) $request->get_param('social_title')));
    update_post_meta($post_id, '_yoast_wpseo_opengraph-description', sanitize_textarea_field((string) $request->get_param('social_description')));
    update_post_meta($post_id, '_yoast_wpseo_twitter-title', sanitize_text_field((string) $request->get_param('social_title')));
    update_post_meta($post_id, '_yoast_wpseo_twitter-description', sanitize_textarea_field((string) $request->get_param('social_description')));
    update_post_meta($post_id, '_yoast_wpseo_focuskw', sanitize_text_field((string) $request->get_param('focus_keyword')));

    return new WP_REST_Response([
        'success' => true,
        'post_id' => $post_id,
        'updated' => [
            '_yoast_wpseo_title',
            '_yoast_wpseo_metadesc',
            '_yoast_wpseo_canonical',
            '_yoast_wpseo_opengraph-title',
            '_yoast_wpseo_opengraph-description',
            '_yoast_wpseo_twitter-title',
            '_yoast_wpseo_twitter-description',
            '_yoast_wpseo_focuskw',
        ],
    ], 200);
}
