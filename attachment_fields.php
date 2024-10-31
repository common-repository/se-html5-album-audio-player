<?php
/* --------------------------------------------------------- */
// ADD FIELDS

function add_image_attachment_fields_to_edit($form_fields, $post) {
	if( strpos($post->post_mime_type, 'audio') !== false ){
		$form_fields["credit"] = array(
			"label" => __("Credit"),
			"input" => "text", // this is default if "input" is omitted
			"value" => get_post_meta($post->ID, "_credit", true),
			"helps" => ''//'<pre>' . print_r($post, true) . '</pre>',
		);
		return $form_fields;
	}
}
add_filter("attachment_fields_to_edit", "add_image_attachment_fields_to_edit", null, 2);



/* --------------------------------------------------------- */
// SAVING

function add_image_attachment_fields_to_save($post, $attachment) {
	if( strpos($post->post_mime_type, 'audio') !== false ){
		if( isset($attachment['credit']) ){
			// update_post_meta(postID, meta_key, meta_value);
			update_post_meta($post['ID'], '_credit', $attachment['credit']);
		}
	}
	return $post;
}
add_filter("attachment_fields_to_save", "add_image_attachment_fields_to_save", null , 2);