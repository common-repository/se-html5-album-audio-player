<?php


define('ALBUM_POST_TYPE', 'se_album_collection');







/* ========================================== */
/* register se_album_collection post type */
/* ========================================== */


add_action('init','SE_AP_post_types_register');

function SE_AP_post_types_register() {

/* ---------------------album type------------------------- */

	$labels = array(
		'name' => _x('Albums', 'post type general name'),
		'singular_name' => _x('Album', 'post type singular name'),
		'add_new' => _x('Add New', 'album'),
		'add_new_item' => __('Add New Album'),
		'edit_item' => __('Edit Album'),
		'new_item' => __('New Album'),
		'view_item' => __('View Album'),
		'search_items' => __('Search Albums'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'query_var' => false,
		'rewrite' => array('slug' => 'albums', 'with_front' => false, 'feeds' => false),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array('title','editor', 'thumbnail'),
		'show_in_menu' => true,
	  );

	register_post_type( ALBUM_POST_TYPE , $args );
/* --------------------------------------------------------- */
}



/* ========================================== */
/* se_album_collection edit.php columns */
/* ========================================== */

add_action("manage_posts_custom_column",  "se_album_collection_custom_columns");
add_filter("manage_se_album_collection_posts_columns", "se_album_collection_edit_columns");
	
	function se_album_collection_edit_columns($columns){
	    $columns = array(
	        "cb" => "<input type=\"checkbox\" />",
	        "album_id" => "ID",
	        "album_cover" => "",
	        "title" => "Album Name",
	  );
	  return $columns;
	}
	
	function se_album_collection_custom_columns($column){
		
		if($_GET['post_type'] =='se_album_collection'){
		
		    global $post;
		   // $custom = get_post_custom();
		
		    switch ($column) {
		    
 
			            
			    case "album_cover":
	
			    	$cover_img = SE_AP_get_album_cover( $post->ID );
			    	echo '<a href="'.get_edit_post_link($post->ID).'" title="Edit this album"><img src="'. $cover_img .'" width="80" /></a>'; 
			    		
			    break;
			    
			    case 'album_id':
			    
			    	echo '<div class="album_id">'.$post->ID.'</div>';
			    
			    break;
		    
		
		    }
		}
	}
	



/* ========================================== */
/* print admin css */
/* ========================================== */


add_action( 'admin_head', 'admin_css' );

function admin_css(){ 
		
	$screen = get_current_screen();
	//echo '<pre>'; var_dump($screen); echo '</pre>';
	//		

?>
	
	<style>

	#adminmenu #menu-posts-se_album_collection .wp-menu-image{
		background-image:url(<?php echo plugins_url( 'img/menu_icon-album.png' , __FILE__ ); ?>);background-repeat:no-repeat;background-position:7px -17px
	}
	
	#adminmenu #menu-posts-se_album_collection:hover .wp-menu-image,
	#adminmenu #menu-posts-se_album_collection.wp-has-current-submenu .wp-menu-image,
	#adminmenu #menu-posts-se_album_collection.wp-menu-open .wp-menu-image{
	background-position:7px 7px
	}

<?php if ($screen->post_type ==  ALBUM_POST_TYPE ){ ?>
		
	#icon-edit.icon32-posts-<?php echo ALBUM_POST_TYPE; ?> {
		
		background:url(<?php echo plugins_url( 'img/album-32.png', __FILE__); ?>) no-repeat;
		
	}
	#wp-content-editor-container,
	#post-status-info,
	#content-html,
	#content-tmce{
	display: none !Important;
	}

<?php } ?>

<?php if ($screen->id == 'edit-' . ALBUM_POST_TYPE ){ ?>

     table.wp-list-table tr .check-column{
     	vertical-align: middle;
     }
     
     table.wp-list-table tr .column-album_cover{
     	width:90px;
     }
     
     table.wp-list-table tr .column-album_cover a img{
    	-webkit-box-shadow:  0px 5px 6px -5px rgba(0, 0, 0, .4);
	 	box-shadow:  0px 5px 6px -5px rgba(0, 0, 0, .4);
     }
     
     table.wp-list-table tr .column-album_id{
     	width:90px;
     	vertical-align: middle;
     	text-align: center;
     }
     
     table.wp-list-table tr .column-album_id .album_id{
     	padding:1em 0;
     	font-size:18px;
     	background:#f7f7f7;
     	
     	-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;

		-webkit-box-shadow:  0px 5px 6px -5px rgba(0, 0, 0, .2);
		box-shadow:  0px 5px 6px -5px rgba(0, 0, 0, .2);
     }
     
     table.wp-list-table tr td.column-title {
     	vertical-align: middle;
     }
     
<?php } ?>


     </style>
     
<?php
}


/* ========================================== */
/* include files on front end */
/* ========================================== */

function SE_AL_enqueue_style() {
	wp_enqueue_style( 'SE_AL_styles_font', plugins_url( 'css/font-awesome.min.css' , __FILE__ ) , false ); 
	wp_enqueue_style( 'SE_AL_styles', plugins_url( 'css/app.min.css' , __FILE__ ) , false ); 
}

function SE_AL_enqueue_script() {
	wp_enqueue_script( 'SE_AL_js_bootstrap', plugins_url( 'js/bootstrap-progressbar.min.js' , __FILE__ ), array( 'jquery' ) );
	wp_enqueue_script( 'SE_AL_js_marquee', plugins_url( 'js/jquery.simplemarquee.min.js' , __FILE__ ), array( 'jquery' ) );
	wp_enqueue_script( 'SE_AL_js_smartresize', plugins_url( 'js/jquery.smartresize.min.js' , __FILE__ ), array( 'jquery' ) );
	wp_enqueue_script( 'SE_AL_js', plugins_url( 'js/app.min.js' , __FILE__ ), array( 'jquery' ) );
}

add_action( 'wp_enqueue_scripts', 'SE_AL_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'SE_AL_enqueue_script' );


/* --------------------------------------------------------- */
/* --------------------------------------------------------- */


/* --------------------------------------------------------- */

add_action( 'wp_ajax_get_se_album_list', 'get_se_album_list' );


function get_se_album_list(){

	$args = array(
		'post_type' => ALBUM_POST_TYPE,
		'posts_per_page' => -1,
		'orderby' => 'title'
	);
	
	$albums = new WP_Query($args);
	
	$albums = $albums->posts;
	
	foreach($albums as $key=>$album){
		
		$a[$album->ID] = $album->post_title;
		
	}
	
	echo json_encode($a);


	die();

}

/* ========================================== */
/* add post thumbnials to albums */
/* ========================================== */

function SE_AP_add_thumbnails_for_albums() {

    $supportedTypes = get_theme_support( 'post-thumbnails' );

    if( $supportedTypes === false )
        add_theme_support( 'post-thumbnails', array( ALBUM_POST_TYPE ) );               
    elseif( is_array( $supportedTypes ) ) {
        $supportedTypes[0][] = ALBUM_POST_TYPE;
        add_theme_support( 'post-thumbnails', $supportedTypes[0] );
    }
}

add_action( 'after_setup_theme',    'SE_AP_add_thumbnails_for_albums' , 11 );

