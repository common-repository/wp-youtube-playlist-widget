=== Wordpress Youtube Playlist Widget ===
Contributors: srikanthlavudia, devsmind
Tags: youtube, playlist, videos, youtube-playlist, youtube-playlist-videos, youtube playlist, youtube playlist videos, embed youtube videos, youtube videos sidebar
Requires at least: 3.2
Tested up to: 4.6.1
Stable tag: 2.0
License: GPLv2 or later

Wordpress Youtube Playlist Widget plugin loads the list of videos from a given plublic youtube playlist ID using google API.

== Description ==

This plugin loads the list of videos from a given plublic youtube playlist ID using google API. To get started: 1) Click the "Activate" link to the left of this description, 2) <a href="https://console.developers.google.com/project">Create your Google API key</a>, and 3) Go to https://www.youtube.com/ page, and get any public playlist that you like to show on the website sidebar and save to the widget configuration box.

Major features in Wordpress Youtube Playlist Widget include:

* Automatically loads the list of videos based on the public Youtube Playlist ID once the configuration is stored into the widget box.
* When a particular video link is clicked by the user, they don't have to leave your website to watch the video, instead this plugin allows them to watch the video in a JQuery dialog box.
* After installing this plugin you can use the widget multiple times on multiple locations within the same page for showing different set of youtube videos by using different Youtube Playlist ID's.

PS: After installing this plugin you would require to generate your own Google API Key to load the youtube playlist videos.

= Whats's new in version 2.0 =

* Add shortcode capability for the plugin, so that users can load playlist widget on any page / post
* USAGE: [youtube-playlist api_key="{your google API key}" playlist_id="{public youtube playlist ID}" show_max="5" layout="h"], here "h" is for horizontal layout, youtube-playlist is the shortcode for this plugin

== Installation ==

1. Upload the Youtube Playlist Videos plugin to your plugins folder.
2. Activate the plugin from your wordpress dashboard plugin page.
3. Generate your own Google API Key.
4. Get the youtube public playlist ID
5. Save the above congigurations to the Wordpress Youtube Playlist Widget box and referesh the page where the widget is used to display the videos.

== Frequently Asked Questions ==

= After installing the plugin do I require to generate a Google API Key =

Yes

= Does this plugin show any private video within the youtube playlist =

No

== Screenshots ==
1. This screen shot description corresponds to screenshot-1.png. Note that the screenshot is taken from
the /plugins/youtube-playlist-widget/plugin-screenshots directory . This screenshot shows the plugin activation after installing the plugin.
2. This screen shot description corresponds to screenshot-2.png. This screenshot shows the widget screen where you need to enter Google API Key and Youtube playlist ID. However, you can use this plugin on multiple locations within the same page if you require.
3. This screen shot description corresponds to screenshot-3.png. This screenshot shows how the page looks after the widget has been incorporated into a page sidebar with different layout options.
4. This screen shot description corresponds to screenshot-4.png. This screenshot shows how the video loads into a JQuery dialog window allowing the user not to loose focus from the website.

== Changelog ==

= 2.0 =
*Release Date - 18 November 2016*

* Add shortcode capability to the plugin, that would allow wordpress users to load youtube playlist in page or post

= 1.2 =
*Release Date - 09 December 2015*

* Allowing the plugin to load more than fifty videos when requested. By default youtube google API allows to fetch 50 videos in a single request.

= 1.1 =
*Release Date - 08 December 2015*

* modify file to separate the loading of youtube videos via CURL in its own function

= 1.0 =
* This is the current stable version of the plugin

== Upgrade Notice ==
* This is the current stable version of the plugin