<?php
/**
 * @package SE HTML5 Album Audio Player
 * @version 1.1.0
 */
/*
Plugin Name: SE HTML5 Album Audio Player
Plugin URI: http://sethelalouf.com/archives/273
Description: A plugin to archive, present, and play collections of mp3s (or other html5 audio formats) as albums within your post.
Author: sedevelops
Version: 1.1.0
Author URI: http://sethelalouf.com/
*/


include('functions.php');
include('setup.php');

if(is_admin()){
	//include('attachment_fields.php');
	include('tinymce/tinymce.php');
}


