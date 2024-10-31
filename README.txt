=== SE HTML5 Album Audio Player ===
Contributors: sedevelops
Author URI: http://sethelalouf.com/
Plugin URI: http://sethelalouf.com/archives/273
Tags: mp3, html5, jquery, ogg, audio player, audio, music, flash, flash player, albums, cover art
Requires at least: 3.5
Tested up to: 3.6
Stable tag: 1.1.0

An HTML5 Album Audio Player. A plugin to archive, present, and play collections of mp3s (or other html5 audio formats) as albums within your post.

== Description ==

A plugin to archive, present, and play collections of mp3s (or other html5 audio formats) as albums within your post.

Features 
* Responsive - Sizes itself automatically to fill whatever container the player is in 
* Simple leveraging of built-in Wordpress functionality 
* Simple, unobtrusive design 
* TinyMCE editor feature lets you choose an album from your collection for insertion into a post. No need to remember or type shortcode.
* Optional download of tracks
* Auto Player option can find audio links within post content and automatically set up a player w/ playlist.

== Installation ==

**Download & Install**

1. Download SE HTML5 Album Audio Player
2. Unzip the downloaded archive
3. Upload the unzipped folder to the `/wp-content/plugins/` directory
4. Activate the plugin through the ‘Plugins’ menu in WordPress

**Usage**

= CREATE & INSERT ALBUMS =
1. Create an album from the "Albums" menu tab.
2. Give the Album a title.
3. Upload any number of audio files to this album by using the "Add Media" button. (**NOTE**:As of the last update of this plugin, I still recommend using .mp3 files for the widest reception). Any audio files uploaded to this album will become it's tracks. Drag the audio files into the correct album order. Rename tracks here in the media dialog if you like. The "Title" field of an individual audio upload will be used as the title of that track in the playlist. NOTE: WHen arranging an album's tracks from the media dialog, it's useful to select "Uploaded to this post" from the dropdown menu to filter out tracks and other content that is not part of the album.
4. Close the media Dialog. You **do not** need to 'Insert into post'.
5. Set a featured image for the album. This image will serve as the album cover.
6. Now you're ready to insert the album into a post or page. Edit or create a new post and use the Visual Editor button "SE Albums" to select an album from your collection to insert. This will insert a short tag like `[SE_Album_player album_id=23]`
7. If you want to allow your visitors to easily download the playlist tracks, select the `[DL]` version of your album from the TinyMCE "SE Albums" dropdown. This version will have a download button for each item in the playlist.

= USE AUTOPLAYER =

You might not want to create albums in advance and on occasion (or regularly) just use this plugin as an audio player for the tracks already embedded in your post. To use it this way is simple.

1. Navigate to a new post or the post you want to insert the player into.
2. Select the `Autoplayer` option from the SE Album TinyMCE dropdown. This will insert the shortcode and determine where your player will show up in your post.
3. Any mp3, ogg, or wav files that are embedded into a post with the `Autoplayer` will be collected and made available to play through the player.
4. If you want to allow your visitors to easily download the playlist tracks, select the `Auto Player [DL]` from the TinyMCE "SE Albums" dropdown. This version will have a download button for each item in the playlist.

**Note:** If you want to use a cover image for an auto player, add the following to the shortcode after it is inserted where XXXXX is the url of the cover image: `cover=XXXXX`
So in context it might look something like:
`[SE_album_player album_id=autoplayer dl=true cover=http://www.metalsucks.net/wp-content/uploads/2013/03/Monkey-Mia-MJK-Australia.jpg]`

**Note:** You can wrap the player shortcode in html and further style the player with your own CSS. The player assumes the full width of its container so if you want to give the player a specific width (fluid or fixed) or float it left or right, just wrap it in a `<div>` and style accordingly.


== Frequently Asked Questions ==



== Screenshots ==
1. **Album player**
2. **Album player w/ open playlist**
3. **Edit Albums admin screen**
4. **Edit an Album admin screen**
5. **Manage Album tracks through the post media dialog**t
6. **Insert Albums into posts using TinyMCE dropdown select**


== Changelog ==

= 1.0 =
* Initial release

= 1.0.1 =
* Cleaned up CSS a bit

= 1.0.2 =
* Removed custom attachment fields as this seemed to be affecting the WP Media Upload DIalog

= 1.0.3 =
* Ironing out kinks…
* More CSS tweaks
* Changed button css class from 'btn' to 'bttn' to avoid conflict with bootstrap styles.

= 1.0.4 =
* …more kinks…
* Major CSS cleanup
* Removed unfinished Flash fallback code

= 1.0.5 =
* …more kinks…
* CSS cleanup
* Javascript minification
* Added Flash fallback for Firefox mp3 playback

= 1.0.6 =
* Completed automatic playback of consecutive tracks for both player variants (HTML5 and Flash fallback for Firefox/MP3)
* Added proper cursor styling for buttons

= 1.0.7 =
* Added a new `autoplayer` mode where instead of inserting a predetermined album post type player into a post, you can simply insert an autoplayer which will find all audio tracks in a post and collect them into the player.

= 1.0.8 =
* refined regex for AutoPlayer
* added tiny static track for AutoPlayer embeds w/o tracks
* added downloadable tracks

= 1.0.9 =
* added code to enable post-thumbnails for album post type if current theme doesn't provide them
* widened the track # area in the playlist to allow for 3 digit playlist counts
* now use the `cover=http://image.com/image.jpg` attribute of the shortcode to add an album cover to the Auto Player

= 1.1.0 =
* Tested compatibility w/ WP 3.6
* Removed console.log messages from TinyMCE function to try to address reported FF issues.

== Other Notes ==

Menu Icon adapted from  Ben Gillbanks' Circular icon set. 
* http://www.iconfinder.com/iconsets/circular_icons#readme
  
32px post_type icon adapted from Marco Tessarotto's icon 
* icon: http://www.iconfinder.com/icondetails/28882/32/application_cd_image_x_icon 
* author: https://plus.google.com/116725837960098600291/about 

Flash MP3 fallback uses niftyplayer 
* http://www.varal.org/niftyplayer/
	
SimpleMarquee js
* https://github.com/AdvancedStyle/jquery.simplemarquee

SmartResize js
* author: John Hann
* http://unscriptable.com/2009/03/20/debouncing-javascript-methods/

Bootstrap
* http://getbootstrap.com/