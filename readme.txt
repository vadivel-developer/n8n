=== Sage SEO Meta REST Updater ===
Contributors: sageit
Tags: yoast, rest api, seo, automation, n8n
Requires at least: 5.0
Tested up to: 6.6
Stable tag: 1.0.0

Adds a custom REST endpoint for updating Yoast SEO meta after n8n publishes a WordPress post.

== Installation ==
1. Upload the plugin folder to /wp-content/plugins/
2. Activate the plugin in WordPress admin
3. Use the endpoint:
   /wp-json/sage-seo/v1/update-meta

== Endpoint ==
POST /wp-json/sage-seo/v1/update-meta

Expected JSON:
{
  "post_id": 123,
  "seo_title": "My SEO Title",
  "meta_description": "My meta description",
  "canonical_url": "https://example.com/post/",
  "social_title": "My social title",
  "social_description": "My social description",
  "focus_keyword": "my focus keyword"
}
