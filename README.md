# WP Cloud Builds 

This plugin triggers a Netlify deploy when a WordPress post is updated or created. It is meant to be used for headless WordPress with Gatsby as a front end.

Full tutorial for Netlify usage located here: [https://scottbolinger.com/headless-wordpress-with-gatsby/](https://scottbolinger.com/headless-wordpress-with-gatsby/)

## Usage

* Install and activate the plugin.
* Create a new webhook on your CI/CD service (see below for provider-specific steps)
* Add your webhook to the plugin settings and save.

#### Webhook setup: Netlify
1) Navigate to Build and Deploy => Continuous deployment, build hooks.
2) Add a deploy notification under Build and Deploy => Deploy Notifications. 
3) Click Add notification => Outgoing Webhook, enter this url: https://YOURSITEDOMAIN.com/wp-json/wp-cloud-builds/notifications

#### Webhook setup: Gatsby Cloud
1) Set up a new site on the Gatsby Cloud dashboard.
2) Navigate to General => Webhook and copy the Publish webhook.