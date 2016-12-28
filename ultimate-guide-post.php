<?php
/*
Plugin Name: Uber List
Description: Create expanded list posts that rank highly in google and get social shares
Plugin URI: http://www.mindheros.com
Author: Nick Julia
Author URI: http://www.mindheros.com/about
Version: 1.01
License: GPL2
Text Domain: tkugp
Domain Path: /lang
*/

if( !defined('TKUGP_POST'))
	define('TKUGP_POST', 'guide');

add_action('wp_enqueue_scripts', 'tkugp_front_scripts');
function tkugp_front_scripts(){
	
	$settings = tkugp_guidepost_settings();

	if( $settings['fa'] == 1 ){
		wp_enqueue_style( 'font-awesome', plugins_url( 'css/css/font-awesome.min.css', __FILE__));
	}

	if( $settings['css'] == 1 ){
		wp_enqueue_style( 'tkugp-style', plugins_url( 'css/guide-post.css', __FILE__));
	}
		
	wp_enqueue_script( 'tkugp-script', plugins_url( 'js/guide-post.js', __FILE__), array('jquery'), '4.0' );
	wp_enqueue_script('jquery');
}

add_action('admin_enqueue_scripts', 'tkugp_scripts');
function tkugp_scripts(){

	if ((isset($_GET['post_type']) && $_GET['post_type'] == TKUGP_POST ) || ( isset($_GET['post']) && get_post_type($_GET['post']) == TKUGP_POST ) ) {

		wp_enqueue_style( 'tkugp-guide-post', plugins_url( 'css/admin-guide-post.css', __FILE__));
		wp_enqueue_media();
		wp_enqueue_script( 'tkugp-suggest', plugins_url( 'js/jquery.suggest.js', __FILE__), array('jquery') );
		wp_enqueue_script( 'tkugp-guide-post', plugins_url( 'js/admin-guide-post.js', __FILE__), array('jquery') );
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery');
		
	}

}

add_action('admin_menu' , 'brdesign_enable_pages');
function brdesign_enable_pages() {
    add_submenu_page('edit.php?post_type=guide', 'Settings', 'Settings', 'edit_posts', basename(__FILE__), 'tkugp_guide_post_settings');
}

function tkugp_guidepost_settings(){

		$default = array(
					'css' => 1,
					'fa' => 1,
				);

	$settings = get_option( 'tkugp_guide_post_settings', $default );

	return $settings;
}
function tkugp_guide_post_settings(){

	if( isset($_POST['save_tkugp_guide_post_settings'])){

		$settings = $_POST['tkugp_guide_post_settings'];
		update_option( 'tkugp_guide_post_settings', $settings );
	}

$settings = tkugp_guidepost_settings();

?>
	<div class="wrap">
		<h3>Uber List Settings</h3>
		<form action="" method="post">
			<table class="form-table">
				<tbody>
					<tr>
						<td scope="row"><label>Plugin CSS</label></td>
						<td><input type="checkbox" name="tkugp_guide_post_settings[css]" value="1" <?php checked( 1, $settings['css'], true ); ?> />Include Plugin CSS</td>
					</tr>	
					<tr>
						<td scope="row"><label>Font Awesome CSS</label></td>
						<td><input type="checkbox" name="tkugp_guide_post_settings[fa]" value="1" <?php checked( 1, $settings['fa'], true ); ?> />Include <a href="https://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome</a> CSS</td>
					</tr>		
				</tbody>
			</table>
			<p><input type="submit" class="button button-primary" name="save_tkugp_guide_post_settings" value="Save Settings" /></p>
		</form>

	</div>
<?php
}


/* register custom taxonomy for guide post type */
if ( ! function_exists( 'tkugp_taxonomy' ) ) {

// Register Custom Taxonomy
function tkugp_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Categories', 'Taxonomy General Name', 'tkugp' ),
		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'tkugp' ),
		'menu_name'                  => __( 'Category', 'tkugp' ),
		'all_items'                  => __( 'All Categories', 'tkugp' ),
		'parent_item'                => __( 'Parent Category', 'tkugp' ),
		'parent_item_colon'          => __( 'Parent Category:', 'tkugp' ),
		'new_item_name'              => __( 'New Category Name', 'tkugp' ),
		'add_new_item'               => __( 'Add New Category', 'tkugp' ),
		'edit_item'                  => __( 'Edit Category', 'tkugp' ),
		'update_item'                => __( 'Update Category', 'tkugp' ),
		'view_item'                  => __( 'View Category', 'tkugp' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'tkugp' ),
		'add_or_remove_items'        => __( 'Add or remove categories', 'tkugp' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'tkugp' ),
		'popular_items'              => __( 'Popular Categories', 'tkugp' ),
		'search_items'               => __( 'Search Categories', 'tkugp' ),
		'not_found'                  => __( 'Not Found', 'tkugp' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( TKUGP_POST . '_cat', array( TKUGP_POST ), $args );

}
add_action( 'init', 'tkugp_taxonomy', 0 );

}

/* register custom tag */

if ( ! function_exists( 'tkugp_tag' ) ) {

// Register Custom Taxonomy
function tkugp_tag() {

	$labels = array(
		'name'                       => _x( 'Tags', 'Taxonomy General Name', 'tkugp' ),
		'singular_name'              => _x( 'Tag', 'Taxonomy Singular Name', 'tkugp' ),
		'menu_name'                  => __( 'Tag', 'tkugp' ),
		'all_items'                  => __( 'All Tags', 'tkugp' ),
		'parent_item'                => __( 'Parent Tag', 'tkugp' ),
		'parent_item_colon'          => __( 'Parent Tag:', 'tkugp' ),
		'new_item_name'              => __( 'New TagName', 'tkugp' ),
		'add_new_item'               => __( 'Add New Tag', 'tkugp' ),
		'edit_item'                  => __( 'Edit Tag', 'tkugp' ),
		'update_item'                => __( 'Update Tag', 'tkugp' ),
		'view_item'                  => __( 'View Tag', 'tkugp' ),
		'separate_items_with_commas' => __( 'Separate tags with commas', 'tkugp' ),
		'add_or_remove_items'        => __( 'Add or remove tags', 'tkugp' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'tkugp' ),
		'popular_items'              => __( 'Popular Tags', 'tkugp' ),
		'search_items'               => __( 'Search Tags', 'tkugp' ),
		'not_found'                  => __( 'Not Found', 'tkugp' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( TKUGP_POST . '_tag', array( TKUGP_POST ), $args );

}
add_action( 'init', 'tkugp_tag', 0 );

}


/* register custom post type */

if ( ! function_exists('tkugp_post_type') ) {

// Register Custom Post Type
function tkugp_post_type() {

	$labels = array(
		'name'                => _x( 'Uber List Posts', 'Post Type General Name', 'tkugp' ),
		'singular_name'       => _x( 'Uber List Post', 'Post Type Singular Name', 'tkugp' ),
		'menu_name'           => __( 'Uber List Post', 'tkugp' ),
		'name_admin_bar'      => __( 'Uber List Post', 'tkugp' ),
		'parent_item_colon'   => __( 'Parent Uber List Post:', 'tkugp' ),
		'all_items'           => __( 'All Uber List Posts', 'tkugp' ),
		'add_new_item'        => __( 'Add New Uber List Post', 'tkugp' ),
		'add_new'             => __( 'Add New', 'tkugp' ),
		'new_item'            => __( 'New Uber List Post', 'tkugp' ),
		'edit_item'           => __( 'Edit Uber List Post', 'tkugp' ),
		'update_item'         => __( 'Update Uber List Post', 'tkugp' ),
		'view_item'           => __( 'View Uber List Post', 'tkugp' ),
		'search_items'        => __( 'Search Uber List Post', 'tkugp' ),
		'not_found'           => __( 'Not found', 'tkugp' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'tkugp' ),
	);
	$args = array(
		'label'               => __( 'Uber List Post', 'tkugp' ),
		'description'         => __( 'Uber List Post', 'tkugp' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', 'editor'),
		'taxonomies'          => array( TKUGP_POST . '_cat', TKUGP_POST . '_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( TKUGP_POST, $args );

}
add_action( 'init', 'tkugp_post_type', 0 );

}

/* metabox */
add_action( 'add_meta_boxes', 'tkugp_list_item_add_meta_box' );
add_action( 'save_post', 'tkugp_list_item_save' );


function tkugp_list_item_add_meta_box() {
		
		global $tkugp_categories_tags;
			   $tkugp_categories_tags = array();

		add_meta_box(
			'tkugp_bottomcontent_metabox',
			__( 'Bottom Content', 'tkuugp' ),
			'tkugp_bottomcontent_html',
			TKUGP_POST,
			'normal',
			'high'
		);	

		add_meta_box(
			'tkugp_categoryitem_metabox',
			__( 'Categories', 'tkuugp' ),
			'tkugp_categoryitem_html',
			TKUGP_POST,
			'normal',
			'high'
		);	

		add_meta_box(
			'tkugp_addnew_button_metabox',
			__( 'Button', 'tkuugp' ),
			'tkugp_addnew_button_html',
			TKUGP_POST,
			'normal',
			'default'
		);
	


	
}


function tkugp_bottomcontent_html($post){

	$content = get_post_meta( $post->ID, 'tkugp_bottomcontent', true);
	wp_editor( $content, 'tkugp_bottomcontent');
}

function tkugp_categoryitem_html( $post) {

	$items = get_post_meta( $post->ID, 'tkugp_category_item', true);
	
	$html = '';
	if( !empty($items) ){

		foreach ($items as $key => $item) { 

			$html .= tkugp_category_item_html($key, $item); 
		
		}

	}

	$favrt_item = get_post_meta( $post->ID, 'tkugp_category_item_favrt', true);
	$favrt_item_default= array('on'=>1, 'title'=>"Show only Brian's favorite tools:");
	if( empty($favrt_item) ){
		$favrt_item = $favrt_item_default;
	}

	if( !isset($favrt_item['on'])  ){
		//$favrt_item['on'] = $favrt_item_default['on'];	
		$favrt_item['on'] = 0;
	}

	if( !isset($favrt_item['title']) ){
		$favrt_item['title'] = $favrt_item_default['title'];	
	}

	$html .= tkugp_category_item_authorfavrt_html($favrt_item);

	?>
		<p><input type="button" class="tkugp_add_category_item button button-secondary" id="tkugp_add_category_item" value="+Add New Category" /></p>
		<div id="tkugp_category_item_wrap" class="ui-sortable"><?php echo $html; ?></div>
		<div id="tkugp_categories_tags_list"  style="display:none !important;"><?php 
			global $tkugp_categories_tags;
			if(!empty($tkugp_categories_tags)){

			foreach ($tkugp_categories_tags as $tags_choicek => $tags_choice){	
				$assign_tags .='<div class="tkugp_assign_tag_choice" data-itemid="" data-tkugpcattitle="'.$tags_choice['title'].'" data-tkugpcatid="'.$tags_choicek.'">';
				foreach ($tags_choice['tags'] as $key => $value) {
					$assign_tags .= '<span class="tkugp_assign_tag" id="tkugp_assign_tag_'.$key.'">'.$value.'</span>';
				}
				$assign_tags .='</div>';
			}


		}
			echo $assign_tags;
		 ?></div>
		<div><p class="description">Added category can be assigned to each list inside list item option.</p></div>

		<input type="hidden" id="tkgup_category_item_count" name="tkgup_category_item_count" value="<?php echo count($items); ?>" />

<?php
}

function tkugp_addnew_button_html( $post) {

	$items = get_post_meta( $post->ID, 'tkugp_list_item', true);


?>
	<div id="tkugp_items_list_html">
		<?php 

			

			if( !empty($items)){

				foreach ($items as $key => $item) { 

					echo  tkugp_items_content_html($key, $item); 
				
				}

			} 
			?>			
	</div>
	<ul  style="display:none !important;" id="tkugp_tags_all"><?php echo tkugp_tags_all(); ?></ul>
	<ul  style="display:none !important;" id="tkugp_category_all"><?php echo tkugp_category_all(); ?></ul>
	
	<input type="hidden" id="tkgup_list_item_count" name="tkgup_list_item_count" value="<?php echo count($items); ?>" />
	
	<input type="button" class="button button-secondary" id="tkugp-addnew-button" value="Add Item">
	<input name="tkugp_save" type="submit" class="button button-primary button-large" id="tkugp_publish" value="Save Settings">

<?php
}

function tkugp_list_item_save( $post_id ) {

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if( get_post_type($post_id) != TKUGP_POST ){
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	

	

		$list_settings = $_POST['tkugp_post_settings'];
		$lists = $_POST['tkugp_list_item'];
		


		if( !empty($lists)){
			foreach ( $lists as $key => $item ) {
				
				$list_items[] = array(

							'title' 		=> $item['title'],
							'content' 		=> $item['content'],
							'tags' 			=> $item['tag'],
							'favrt' 		=> $item['favrt'],
							'image' 		=> $item['image'],
							'link' 			=> $item['link'],

							);

			}
		}

		$categories = $_POST['tkugp_category_item'];
		$category_items = array();

		if( !empty($categories)){
			foreach ( $categories as $key => $item ) {
			
				$category_items[] = array(
							'title' => $item['title'],
							'tags' 	=> $item['tag']
							);

			}
		}

		$favrt = $_POST['tkugp_category_item_favrt'];
		$tkugp_bottomcontent = $_POST['tkugp_bottomcontent'];
		

		update_post_meta($post_id, 'tkugp_category_item_favrt', $favrt);
		
		update_post_meta($post_id, 'tkugp_post_settings', $list_settings);
		update_post_meta($post_id, 'tkugp_list_item', $list_items);
		update_post_meta($post_id, 'tkugp_category_item', $category_items);
		
		update_post_meta($post_id, 'tkugp_bottomcontent', $tkugp_bottomcontent);


}



function tkugp_category_all( $selected=''){

	//no default values. using these as examples
	$taxonomies = array(TKUGP_POST . '_cat');

	$args = array(
	    'orderby'           => 'name', 
	    'order'             => 'ASC',
	    'hide_empty'        => false, 
	    'exclude'           => array(), 
	    'exclude_tree'      => array(), 
	    'include'           => array(),
	    'number'            => '', 
	    'fields'            => 'all', 
	    'slug'              => '',
	    'parent'            => '',
	    'hierarchical'      => true, 
	    'child_of'          => 0,
	    'childless'         => false,
	    'get'               => '', 
	    'name__like'        => '',
	    'description__like' => '',
	    'pad_counts'        => false, 
	    'offset'            => '', 
	    'search'            => '', 
	    'cache_domain'      => 'core'
	); 

	$terms = get_terms($taxonomies, $args);


	$category = '';
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
          foreach ( $terms as $term ) {
      		$category .= '<li id="tkgup_postcategory_'.$term->term_id.'">'.$term->name.'</li>';
    	 }
     
 	}


 	return $category;



 	return $options;

}

function tkugp_tags_all(){

	//no default values. using these as examples
	$taxonomies = array(TKUGP_POST . '_tag');

	$args = array(
	    'orderby'           => 'name', 
	    'order'             => 'ASC',
	    'hide_empty'        => false, 
	    'exclude'           => array(), 
	    'exclude_tree'      => array(), 
	    'include'           => array(),
	    'number'            => '', 
	    'fields'            => 'all', 
	    'slug'              => '',
	    'parent'            => '',
	    'hierarchical'      => true, 
	    'child_of'          => 0,
	    'childless'         => false,
	    'get'               => '', 
	    'name__like'        => '',
	    'description__like' => '',
	    'pad_counts'        => false, 
	    'offset'            => '', 
	    'search'            => '', 
	    'cache_domain'      => 'core'
	); 

	$terms = get_terms($taxonomies, $args);

	$tags = '';
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
          foreach ( $terms as $term ) {
      		$tags .= '<li id="tkgup_posttag_'.$term->term_id.'">'.$term->name.'</li>';
    	 }
     
 	}


 	return $tags;

}

function tkugp_category_tags($ID, $item){

	global $tkugp_categories_tags;
	$tag_html = '';	
	$tagid = '';
	$tagname = '';

	if( !empty($item['tags']) ){

		$tkugp_categories_tags[$ID]['title'] = $item['title'];
		foreach ($item['tags'] as $key => $term_id) {
			
		$term = get_term( $term_id, TKUGP_POST . '_tag' );
		$tagid = $term->term_id;
		$tagname = $term->name;

		//if( !in_array($tagname, $tkugp_categories_tags[$ID]['tags']) ){
			$tkugp_categories_tags[$ID]['tags'][$tagid] = $tagname;
		//}

		/*if( !in_array($tagname, $tkugp_categories_tags) ){
			$tkugp_categories_tags[$tagid] = $tagname;
		}*/


		$tag_html .= '<span id="tkgup_categoryitem_tagitem_'.$ID.'_'.$tagid.'">';
		$tag_html .= '<a href="javascript:void(0);" class="ntdelbutton tkgup_categoryitem_tagitem_del" id="tkgup_categoryitem_tagitem_del_'.$ID.'_'.$tagid.'">X</a>&nbsp;'.$tagname;
		$tag_html .= '<input type="hidden" name="tkugp_category_item['.$ID.'][tag][]" value="'.$tagid.'" /></span>';
		
		}
	}
	return $tag_html;  
}

function tkugp_category_item_html($ID, $item){

		$tags_list = tkugp_category_tags($ID, $item);
		$new_category_item = '';
		$new_category_item .='<div class="tkugp_new_category_item" id="tkugp_new_category_item_'.$ID.'">';
		$new_category_item .='<div class="tkugp_handlediv" title="Click to toggle"><br></div>';
		$new_category_item .='<h3 class="tkugp_hndle ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><span>Category item</span></h3>';
		$new_category_item .='<div class="inside">';
		$new_category_item .='<div class="form-field">';
		$new_category_item .='<label>Title</label>';
		$new_category_item .='<input type="text" value="'.$item['title'].'" id="tkugp_category_item_title_'.$ID.'" name="tkugp_category_item['.$ID.'][title]" />';
		$new_category_item .='</div>';
		$new_category_item .='<div>';
		$new_category_item .='<label>Add Tag</label>';
		$new_category_item .='<input type="text" value="" class="tkugp_category_item_add_tag" id="tkugp_category_item_add_tag_'.$ID.'" name="tkugp_category_item_add_tag['.$ID.'][tag]" />';
		$new_category_item .='<p class="description">Press "Enter" Key to Add Tags</p>';
		$new_category_item .='</div>';
		$new_category_item .='<div class="form-field">';
		$new_category_item .='<span class="tkugp_added_tags_title">Added Tags List</span>';
		$new_category_item .='<div id="tkugp_category_item_tags_list_'.$ID.'" class="tkugp_category_item_tags_list">'.$tags_list.'</div>';
		$new_category_item .='</div>';
		$new_category_item .= '<div class="tkugp_alignright"><input type="button" id="tkugp_category_item_del_'.$ID.'" class="tkugp_category_item_del button button-secondary" value="Delete Category"/></div>';
		$new_category_item .='</div>';
		$new_category_item .='</div>';

		return $new_category_item;
}

function tkugp_category_item_authorfavrt_html($item){

		$new_category_item = '';
		$new_category_item .='<div class="tkugp_new_category_item" id="tkugp_new_category_item_favrt">';
		$new_category_item .='<div class="tkugp_handlediv" title="Click to toggle"><br></div>';
		$new_category_item .='<h3 class="tkugp_hndle ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><span>Author Favorite</span></h3>';
		$new_category_item .='<div class="inside">';

		$new_category_item .='<div class="form-field">';
		$new_category_item .='<label>Title</label>';
		$new_category_item .='<input type="text" value="'.$item['title'].'" id="tkugp_category_item_title_favrt" name="tkugp_category_item_favrt[title]" />';
		$new_category_item .='</div>';
		
		$new_category_item .='<p><input type="checkbox" '.checked( 1, $item['on'], false).' value="1" class="tkugp_enable_favrt" name="tkugp_category_item_favrt[on]" /> Enable Author Favorite</p>';
		$new_category_item .='</div>';
		$new_category_item .='</div>';

		return $new_category_item;
}

function tkugp_items_content_html($ID, $item){
		
		
		global $tkugp_categories_tags;
		$item_html = '';
		$assign_tags = '';
		$assign_favrt = '';

		if( $item['favrt'] == 'yes'){

			$checked_yes = 'checked="checked"';
			$checked_no = '';
		
		} else {

			$checked_yes = '';
			$checked_no = 'checked="checked"';
		
		}

		$assign_favrt .= '<span><input type="radio" '.$checked_yes.' name="tkugp_list_item['.$ID.'][favrt]" value="yes" /> Yes</span>';
		$assign_favrt .= '<span><input type="radio" '.$checked_no.' name="tkugp_list_item['.$ID.'][favrt]" value="no" /> No</span>';


		if(!empty($tkugp_categories_tags)){
			foreach ($tkugp_categories_tags as $tags_choicek => $tags_choice) {
			
			$assign_tags .= '<div id="category_item_tag_choice_'.$ID.'_'.$tags_choicek.'">';
			$assign_tags .= '<h5 class="category_item_tags_title">'.$tags_choice['title'].'</h5>';
			foreach ($tags_choice['tags'] as $key => $value) {
			
				$checked = '';
				if( in_array($key, $item['tags']) )
					$checked = 'checked="checked"';

				$assign_tags .= '<span class="tkugp_assign_tag" id="tkugp_assign_tag_'.$ID.'_'.$key.'"><input type="checkbox" '.$checked.' value="'.$key.'" name="tkugp_list_item['.$ID.'][tag][]" />&nbsp;'.$value.'</span>';
			}
			$assign_tags .='</div>';

			}
		}

		$item_html .= '<div id="tkugp_list_item_'.$ID.'" class="postbox tkugp_list_item">';
		$item_html .= '<div class="tkugp_handlediv" title="Click to toggle"><br></div><h3 class="tkugp_hndle hndle"><span>List Item</span></h3>';
		$item_html .= '<div class="inside postbox">';
		/*$item_html .= '<p>Add List item content</p>';*/
		$item_html .= '<p>';
		$item_html .= '<label for="tkugp_list_item_title_'.$ID.'">Title</label>';
		$item_html .= '<input type="text" name="tkugp_list_item['.$ID.'][title]" class="tkugp_list_item_title" id="tkugp_list_item_title_'.$ID.'" value="'.$item['title'].'">';
		$item_html .= '</p>';	
		
		$item_html .= '<p>';
		$item_html .= '<label for="tkugp_list_item_content_'.$ID.'">Content</label>';
		$item_html .= '<textarea name="tkugp_list_item['.$ID.'][content]" class="tkugp_list_item_content" id="tkugp_list_item_content_'.$ID.'">'.$item['content'].'</textarea>';
		$item_html .= '</p>';

		$item_html .= '<p>';
		$item_html .= '<label for="tkugp_list_item_image_'.$ID.'">Image</label>';
		$item_html .= '<img id="tkugp_list_item_preview_'.$ID.'" class="tkugp_list_item_preview" src="'.$item['image'].'" alt="Image Preview" /><span id="tkugp_list_item_imgdel_'.$ID.'" title="Delete this Image" class="tkugp_list_item_imgdel">Delete Image</span>';
		$item_html .= '<input type="text" name="tkugp_list_item['.$ID.'][image]" class="tkugp_list_item_image" id="tkugp_list_item_image_'.$ID.'" value="'.$item['image'].'">';
		$item_html .= '<input type="button" name="tkugp_list_item_uploadimage_'.$ID.'" class="button button-secondary tkugp_list_item_uploadimage" id="tkugp_list_item_uploadimage_'.$ID.'" value="Upload Image">';
		$item_html .= '</p>';
		$item_html .= '<p>';
		
		$item_html .= '<p class="tkugp_list_item_link_wrap">';
		$item_html .= '<p><label>Link Label:</label><input type="text"  class="tkugp_list_item_link" id="tkugp_list_item_link_'.$ID.'" name="tkugp_list_item['.$ID.'][link][title]" value="'.$item['link']['title'].'" /></p>';
		$item_html .= '<p><label>Link:</label><input type="text"  class="tkugp_list_item_link" id="tkugp_list_item_link_'.$ID.'" name="tkugp_list_item['.$ID.'][link][url]" value="'.$item['link']['url'].'" /></p>';
		$item_html .= '</p>';

		$item_html .= '<div><label>Assign Tags:</label><br><div class="tkugp_assign_tags_list">'.$assign_tags.'</div></div>';
		
		$item_html .= '<div><label>Author Favorite:</label><br><div class="tkugp_assign_author_favrt">'.$assign_favrt.'</div></div>';

		$item_html .= '<p class="tkugp_remove_item_wrap"><input type="button" class="button button-secondary tkugp_remove_item" id="tkugp_remove_item_'.$ID.'" value="Remove Item" /></p>';
		$item_html .= '</div>';
		$item_html .= '</div>';

		return $item_html;

}



function tkugp_tags_selected_item($ID, $item){


	if ( ! empty( $item['tags'] ) ){

		$tag_html = '';
		
         foreach ( $item['tags'] as $subID => $terms ) {


			$taglist = '';


          	foreach ($terms['ids'] as $key => $term_id) {
          		

	          	$term = get_term( $term_id, TKUGP_POST . '_tag' );
	          	$catid = $term->term_id;
	          	$catname = $term->name;

	      		$taglist .= '<span id="tkgup_list_item_tagitem_'.$ID.'_'.$subID.'_'.$catid.'">';
	      		$taglist .= '<a href="javascript:void(0);" class="ntdelbutton tkgup_list_item_deltag" id="tkgup_list_item_deltag_'.$ID.'_'.$subID.'_'.$catid.'">X</a>';
	      		$taglist .= '&nbsp;'.$catname.'<input type="hidden" name="tkugp_list_item['.$ID.'][tag]['.$subID.'][ids][]" value="'.$catid.'" /></span>';

          	}

          	 $tag_html .= '<div class="tkugp_option_type_tag" id="tkugp_option_type_tag_'.$ID.'_'.$subID.'">';
			 $tag_html .= '<label>Tag Label: </label><input type="text" name="tkugp_list_item['.$ID.'][tag]['.$subID.'][title]" id="tkugp_list_item_tagtitle_'.$ID.'_'.$subID.'" value="'.$terms['title'].'" />';
			 $tag_html .= '<label>Tags: </label>';
			 $tag_html .= '<span id="tkgup_list_item_taglist_'.$ID.'_'.$subID.'" class="tkgup_list_item_taglist">'.$taglist.'</span>';
			 $tag_html .= '<input type="text" class="tkugp_list_item_tag" id="tkugp_list_item_tag_'.$ID.'_'.$subID.'" value="">';
			 $tag_html .= '<a href="javascript:void(0);" class="tkugp_list_item_newtag" id="tkugp_list_item_newtag_'.$ID.'_'.$subID.'">+Add</a>';
			 $tag_html .= '<p class="tkugp_del_optiontype_wrap"><a href="javascript:void(0);" class="tkugp_del_optiontype tkugp_del_optiontype_tag" id="tkugp_del_optiontype_'.$ID.'_'.$subID.'">Delete Option</a></p>';
			 $tag_html .= '</div>';
          	
    	 }
     
 	}

 	
 	return $tag_html;
}

function tkugp_category_selected_item($ID, $category){

	

	if ( ! empty( $category['category'] ) ){

		$category_html = '';
		
         foreach ( $category['category'] as $subID => $terms ) {


			$categorylist = '';


          	foreach ($terms['ids'] as $key => $term_id) {
          		

	          	$term = get_term( $term_id, TKUGP_POST . '_cat' );
	          	$catid = $term->term_id;
	          	$catname = $term->name;

	      		$categorylist .= '<span id="tkgup_list_item_categoryitem_'.$ID.'_'.$subID.'_'.$catid.'">';
	      		$categorylist .= '<a href="javascript:void(0);" class="ntdelbutton tkgup_list_item_delcategory" id="tkgup_list_item_delcategory_'.$ID.'_'.$subID.'_'.$catid.'">X</a>';
	      		$categorylist .= '&nbsp;'.$catname.'<input type="hidden" name="tkugp_list_item['.$ID.'][category]['.$subID.'][ids][]" value="'.$catid.'" /></span>';

          	}

          	 $category_html .= '<div class="tkugp_option_type_category" id="tkugp_option_type_category_'.$ID.'_'.$subID.'">';
			 $category_html .= '<label>Category Label: </label><input type="text" name="tkugp_list_item['.$ID.'][category]['.$subID.'][title]" id="tkugp_list_item_categorytitle_'.$ID.'_'.$subID.'" value="'.$terms['title'].'" />';
			 $category_html .= '<label>Categories: </label>';
			 $category_html .= '<span id="tkgup_list_item_categorylist_'.$ID.'_'.$subID.'" class="tkgup_list_item_categorylist">'.$categorylist.'</span>';
			 $category_html .= '<input type="text" class="tkugp_list_item_category" id="tkugp_list_item_category_'.$ID.'_'.$subID.'" value="">';
			 $category_html .= '<a href="javascript:void(0);" class="tkugp_list_item_newcategory" id="tkugp_list_item_newcategory_'.$ID.'_'.$subID.'">+Add</a>';
			 $category_html .= '<p class="tkugp_del_optiontype_wrap"><a href="javascript:void(0);" class="tkugp_del_optiontype tkugp_del_optiontype_category" id="tkugp_del_optiontype_'.$ID.'_'.$subID.'">Delete Option</a></p>';
			 $category_html .= '</div>';
          	
    	 }
     
 	}

 	
 	return $category_html;

}

add_action('wp_ajax_tkugp_admin_addcategory' , 'ajax_tkugp_category');
function ajax_tkugp_category(){

	$catname = $_POST['catname'];
	$post_id = $_POST['postid'];


	$status  = array('msg' =>'', 'status' =>'');

	if( $post_id && '' != $post_id ){

			$term = term_exists($catname, TKUGP_POST . '_cat' );

		if ($term !== 0 && $term !== null) {
				
			$status = array('msg' => 'Error: Category already exist.', 'status' => 2, 'catid' => $term['term_id'] );

		} else {

			$terms = wp_insert_term($catname, TKUGP_POST . '_cat');

			if ( is_wp_error( $terms ) ) {
				
				$status = array('msg' => 'Error: Adding new category.', 'status' => 0 );	

			} else {


				if( !tkugp_set_termcat($post_id, $terms['term_id']) ){

					$status = array('msg' => 'Error: Could not assign category to post.', 'status' => 0);	
				
				} else {

					$status = array('msg' => 'Success: New category added and assigned to post.', 'status' => 1, 'catid' => $terms['term_id']);	
				
				}

			}

		}

	} else {

		$status = array('msg' => 'Error: Not a valid post id.', 'status' => 0 );
	}


	die(json_encode($status));
}


add_action('wp_ajax_tkugp_admin_addtag' , 'tkugp_admin_addtag');

function tkugp_admin_addtag(){

	$tagname = $_POST['tagname'];
	$post_id = $_POST['postid'];


	$status  = array('msg' =>'', 'status' =>'');

	if( $post_id && '' != $post_id ){

			$term = term_exists($tagname, TKUGP_POST . '_tag' );

		if ($term !== 0 && $term !== null) {
				
			$status = array('msg' => 'Error: Tag already exist.', 'status' => 2, 'tagid' => $term['term_id'] );

		} else {

			$terms = wp_insert_term($tagname, TKUGP_POST . '_tag');

			if ( is_wp_error( $terms ) ) {
				
				$status = array('msg' => 'Error: Adding new tag.', 'status' => 0 );	

			} else {


				if( !tkugp_set_termtag($post_id, $terms['term_id']) ){

					$status = array('msg' => 'Error: Could not assign tag to post.', 'status' => 0);	
				
				} else {

					$status = array('msg' => 'Success: New tag added and assigned to post.', 'status' => 1, 'tagid' => $terms['term_id']);	
				
				}

			}

		}

	} else {

		$status = array('msg' => 'Error: Not a valid post id.', 'status' => 0 );
	}


	die(json_encode($status));
}

function tkugp_set_termcat($post_id, $cat_id){

	// ID of category we want this post to have.
	$cat_id = $cat_id;

	$term_taxonomy_ids = wp_set_object_terms( $post_id, $cat_id, TKUGP_POST . '_cat' );

	if ( is_wp_error( $term_taxonomy_ids ) ) {
		return false;
	} else {

		return true;
	}

}

function tkugp_set_termtag($post_id, $tag_id){

	// ID of tag we want this post to have.
	$tag_id = $tag_id;

	$term_taxonomy_ids = wp_set_object_terms( $post_id, $tag_id, TKUGP_POST . '_tag' );

	if ( is_wp_error( $term_taxonomy_ids ) ) {
		return false;
	} else {

		return true;
	}

}

/* 
******
	Front END 
******
*/


add_action('the_content', 'tkugp_the_content', 99, 1);

function tkugp_get_favrt($post_id){

	$favrt_item = get_post_meta($post_id, 'tkugp_category_item_favrt', true);
		
		$favrt_item_default= array('on'=>1, 'title'=>"Show only Nick's favorite tools:");
		if( empty($favrt_item) ){
			$favrt_item = $favrt_item_default;
		}

		if( !isset($favrt_item['on'])  ){
			//$favrt_item['on'] = $favrt_item_default['on'];	
			$favrt_item['on'] = 0;
		}

		if( !isset($favrt_item['title']) ){
			$favrt_item['title'] = $favrt_item_default['title'];	
		}
	return $favrt_item;
}

function tkugp_the_content($content){

	$post_id = get_the_ID();
	$html = '';

		$items = get_post_meta($post_id, 'tkugp_category_item', true);
		$favrt_item = tkugp_get_favrt($post_id);


		$html_option = '';

		if(!empty($items)){

			$i = 0;
			$class = '';
			foreach ($items as $key => $item) {
					

					$class = 'tkugp-main-tag-' . $i;

					$html_option  .= '<p class="tkugp-tag-heading">'.$item['title'].'</p>';
					$html_option  .='<hr class="tkugp-hr" />';
					$html_option  .= '<ol class="tkugp-tag-list tkugp-ol">';
					$html_option  .= tkugp_the_content_tags($item['tags'], $class);
					$html_option  .= '</ol>';

					$i++;
					
			}
		}

		if( $favrt_item['on'] == 1 ){

			$html_option  .= '<p class="tkugp-favrt-heading">'.$favrt_item['title'].'</p>';
			$html_option  .='<hr class="tkugp-hr" />';
			$html_option  .= '<ol class="tkugp-tag-list tkugp-ol">';
			$html_option  .= tkugp_the_content_favrt();
			$html_option  .= '</ol>';
		
		}

		$items = get_post_meta( $post_id, 'tkugp_list_item', true);
		$items_html = '';

		
			$html .='<div class="tkugp-items-wrap">';
		
		if(!empty($items)){
	
			foreach ($items as $key => $item) {
				
				$items_html .= tkugp_the_content_item($item);

			}

			$html .= $html_option;
			$html .='<div class="tkugp-items" id="tkugp-items">';
			$html .= $items_html;		
			$html .='</div>';
		}
			$html .= '<div class="tkugp-bottomcontent">'.get_post_meta( $post_id, 'tkugp_bottomcontent', true).'</div>';
			$html .='</div>';

		



	return $content . $html;
	
}

function tkugp_the_content_favrt(){


	$content .= '<li class="tkugp-favrt" data-tkugpfavrt="yes" data-tkugptag="yes">Yes</li>';
	$content .= '<li class="tkugp-favrt" data-tkugpfavrt="no" data-tkugptag="no">No</li>';

	return $content;
}

function tkugp_the_content_tags($terms, $class){

	$content  = '';			
	if( !empty($terms)){
		foreach ($terms as $key => $term_id) {
			
		$term 	  = get_term( $term_id, TKUGP_POST . '_tag' );
        $tagid 	  = $term->term_id;
        $tagname  = $term->name;
		$content .= '<li class="tkugp-tag '.$class.'" data-tkugptag="'.$tagid.'">'.$tagname.'</li>';
        
		}
	}


	return $content;
}


function tkugp_the_content_item($item){

	global $post;
	$content = '';

		$post_id = get_the_ID();
		$favrt_item = tkugp_get_favrt($post_id);
		
		$favrt = $item['favrt'];
        if( $favrt == 'yes' ){
        	$favrttext = ucwords(get_the_author()."'s").' Favorite';
        }
        

        $content .= '<div class="tkugp-listitem-single">';
       	//$content .= '<h2 class="tkugp-item-heading">'.$catname.'</h2>';	
    	$content .= '<h2 class="tkugp-item-title">'.$item['title'].'</h2>';
    	$content .='<div class="tkugp-item-terms">';

		if(!empty($item['tags'])){

    		foreach ($item['tags'] as $key => $tag) {
    			
		    			$term 	 = get_term( $tag, TKUGP_POST . '_tag' );
		        		$tagid 	 = $term->term_id;
		        		$tagname = $term->name;

		        		$default_icon = '<i class="fa fa-tag"></i>';
		        		if( function_exists(tax_icons_term_icon_shortcode)){
		    				$icon = tax_icons_output_term_icon($term->term_id);
		    			}

		    			if( empty($icon) ){
		    				$icon = $default_icon;
		    			} 

		    			$content .= '<span class="tkugp-item-term tkugp-term-tag tkugp-tag-'.$tagid.'" data-itemterm="'.$tagid.'">'.$icon.' '.$tagname.'</span>';
		    		
    		}
		}

	if( $favrt == 'yes' ){		
		$icon = '<i class="fa fa-thumbs-up"></i>';
		$content .= '<span class="tkugp-item-term tkugp-term-favrt tkugp-favrt-yes tkugp-tag-yes" data-itemterm="yes">'.$icon.' '.$favrttext.'</span>';
	} else {
		$content .= '<span class="tkugp-item-term tkugp-term-favrt tkugp-favrt-no tkugp-tag-no" data-itemterm="no" style="display:none;width:0;padding:0;margin:0;">&nbsp;</span>';
	}
    	$content .='</div>';
    		
    	$content .='<div class="tkugp-item-inner">';
    		$content .='<div class="tkugp-item-content">'.wpautop($item['content']).'</div>';
    		$content .='<img class="tkugp-item-image" src="'.$item['image'].'" />';
    		$content .='<hr class="tkugp-hr" />';
    		if( !empty($item['link']['url'])){
    		$content .='<p class="tkugp-item-link">';
    			$content .='<span class="tkugp-item-link-label">'.$item['link']['title'].'</span>';
    			$content .='<br><a href="'.tkugpaddhttp($item['link']['url']).'" target="_blank">'.$item['link']['url'].'</a></br>';
    		$content .='</p>';
    		}
    	$content .='</div>';
    	
    	$content .='</div><!-- tkugp-listitem-single  -->';


	return $content;
}

function tkugpaddhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}


/**
*
* Admin Notice
* 
*/


add_action('admin_notices', 'tkugp_plugin_admin_notices');
function tkugp_plugin_admin_notices() {
  
  if( isset($_REQUEST['tkugp_hide_notice']) && $_REQUEST['tkugp_hide_notice'] == 'yes' ){

 	update_option( 'tkugp_plugin_hide_notice', 'yes');
 }

 $hide_notice = get_option('tkugp_plugin_hide_notice', '');
  
  $taxonomy_icons = false;
  if ( is_plugin_active( 'taxonomy-icons/taxonomy-icons.php' ) ) {
  	$taxonomy_icons = true;
  }

  if(  $hide_notice == 'no' && !isset($_REQUEST['tkugp_hide_notice']) && !$taxonomy_icons){
  	?>
  		<div id="message" class="updated notice">
		<p style="overflow:hidden;">Uber List Post: To use icon for tags please install <a href="https://wordpress.org/plugins/taxonomy-icons/" target="_blank">Taxonomy Icons</a> Plugin.
		&nbsp; &nbsp;<a style="float:right;" href="<?php echo admin_url('plugins.php'); ?>?tkugp_hide_notice=yes" class="button button-secondary">Hide This</a>
		
		</p>
		</div>

  	<?php
  }




}

