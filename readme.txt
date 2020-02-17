=== WP Cloud Builds ===

Contributors: scottopolis, sarahg
Tags: netlify, gatsby
Requires at least: 4.5
Tested up to: 5.2.0
Stable tag: 0.41.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Trigger a build on a webhook-friendly CI service, like Gatsby Cloud or Netlify 
when posts or pages are created or updated.

== Description ==

This plugin calls a webhook on WordPress actions (updating or creating a post or page).

For example, if you are using Gatsby, you can trigger a rebuild on Netlify which will update your static front end.

== Installation ==

* Install and activate the plugin.
* Create a new webook on your CI service:

** Netlify
1) Navigate to Build and Deploy => Continuous deployment, build hooks.
2) Add a deploy notification under Build and Deploy => Deploy Notifications. 
3) Click Add notification => Outgoing Webhook, enter this url: https://YOURSITEDOMAIN.com/wp-json/wp-cloud-builds/notifications

** Gatsby Cloud:
1) Set up a new site on the Gatsby Cloud dashboard.
2) Navigate to General => Webhook and copy the Publish webhook.

* Add your build hook to the plugin settings and save.

== Changelog ==

= 0.1.0 = 

* Beta release