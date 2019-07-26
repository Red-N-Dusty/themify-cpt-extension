<?php
/* Custom Write Panels
/***************************************************************************/

///////////////////////////////////////
// Build Write Panels
///////////////////////////////////////


function addThemifyMeta(){
	$nmco_cpt_post_types = get_option('nmco_cpt_post_types');

	if(!empty($nmco_cpt_post_types)){
		
		
		function themify_CPT_setup_metaboxes($meta_boxes, $post_type) {
			//echo "post type - ".$post_type;
			$nmco_cpt_post_types = get_option('nmco_cpt_post_types');
			if( ! in_array($post_type, $nmco_cpt_post_types)){
				//echo "YUP!";
				return $meta_boxes;
			}

			/**
			 * Navigation menus used in page custom panel to specify a custom menu for the page.
			 * @since 1.0.0
			 * @var array
			 */
			$nav_menus = array(	array( 'name' => '', 'value' => '', 'selected' => true ) );
			foreach ( get_terms( 'nav_menu' ) as $menu ) {
				$nav_menus[] = array( 'name' => $menu->name, 'value' => $menu->slug );
			}

			/**
			 * Options for header design
			 * @since 1.0.0
			 * @var array
			 */
			$header_design_options = themify_theme_header_design_options();

			/**
			 * Options for footer design
			 * @since 1.0.0
			 * @var array
			 */
			$footer_design_options = themify_theme_footer_design_options();

			/**
			 * Options for font design
			 * @since 1.0.0
			 * @var array
			 */
			$font_design_options = themify_theme_font_design_options();

			/**
			 * Options for color design
			 * @since 1.0.0
			 * @var array
			 */
			$color_design_options = themify_theme_color_design_options();

			$entry_id = isset( $_GET['post'] ) ? $_GET['post'] : null;
			$background_slider = false;
			if ( $entry_id ) {
				$background_slider = ( get_post_meta( $entry_id, 'header_wrap', true ) == '' && get_post_meta( $entry_id, 'background_gallery', true ) != '' );
				$background_mode = get_post_meta( $entry_id,'background_mode', true );
			}
			if ( ! isset( $background_mode ) || ! $background_mode ) {
				$background_mode = 'fullcover';
			}
			$post_type_obj = get_post_type_object($post_type);
			$post_type_name = $post_type_obj->name;
			$post_type_label_name =$post_type_obj->labels->name;

			$cpt_metaboxes = array(
				array(
					'name'    => __( 'Post Options', 'themify' ),
					'id'      => $post_type_name.'-options',
					'options' => array(
						array(
							'name' 		=> 'custom_post_'.$post_type_name.'_single',
							'title' 		=> __('Sidebar Option', 'themify'),
							'description' => '',
							'type' 		=> 'layout',
							'show_title' => true,
							'meta'		=> array(
								array('value' => 'default', 'img' => 'images/layout-icons/default.png', 'selected' => true, 'title' => __('Default', 'themify')),
								array('value' => 'sidebar1', 'img' => 'images/layout-icons/sidebar1.png', 'title' => __('Sidebar Right', 'themify')),
								array('value' => 'sidebar1 sidebar-left', 'img' => 'images/layout-icons/sidebar1-left.png', 'title' => __('Sidebar Left', 'themify')),
								array('value' => 'sidebar2', 'img' => 'images/layout-icons/sidebar2.png', 'title' => __('Left and Right', 'themify')),
								array('value' => 'sidebar2 content-left', 'img' => 'images/layout-icons/sidebar2-content-left.png', 'title' => __('2 Right Sidebars', 'themify')),
								array('value' => 'sidebar2 content-right', 'img' => 'images/layout-icons/sidebar2-content-right.png', 'title' => __('2 Left Sidebars', 'themify')),
								array('value' => 'sidebar-none', 'img' => 'images/layout-icons/sidebar-none.png', 'title' => __('No Sidebar ', 'themify'))
							),
							'default' => 'default',
						),
					  //Post Layout
						array(
							'name' => 'post_layout',
							'title' => __($post_type_label_name.' Layout', 'themify'),
							'description' => '',
							'type' => 'layout',
							'show_title' => true,
							'enable_toggle' => true,
							'class' => 'hide-if none',
							'meta' => array(
								array('value' => '', 'img' => 'images/layout-icons/default.png', 'selected' => true, 'title' => __('Default', 'themify')),
								array('value' => 'classic', 'img' => 'images/layout-icons/post-classic.png', 'title' => __('Classic', 'themify')),
								array('value' => 'fullwidth', 'img' => 'images/layout-icons/post-fullwidth.png', 'title' => __('Fullwidth', 'themify')),
								array('value' => 'slider', 'img' => 'images/layout-icons/post-slider.png', 'title' => __('Slider', 'themify')),
								array('value' => 'gallery', 'img' => 'images/layout-icons/post-gallery.png', 'title' => __('Gallery', 'themify')),
								array('value' => 'split', 'img' => 'images/layout-icons/post-split.png', 'title' => __('Split', 'themify'))
							),
							'default' => 'default',
						),
						 // Gallery Layout shortcode
						array(
							'name' => 'post_layout_gallery',
							'title' => '',
							'description' => '',
							'type' => 'gallery_shortcode',
							'toggle' => 'gallery-toggle',
							'class' => 'hide-if none',
						),
						// Slider Layout shortcode
						array(
							'name' => 'post_layout_slider',
							'title' => '',
							'description' => '',
							'type' => 'gallery_shortcode',
							'toggle' => 'slider-toggle',
							'class' => 'hide-if none',
						),
						// Content Width
						array(
							'name'=> 'content_width',
							'title' => __('Content Width', 'themify'),
							'description' => '',
							'type' => 'layout',
							'show_title' => true,
							'meta' => array(
								array(
									'value' => 'default_width',
									'img' => 'themify/img/default.png',
									'selected' => true,
									'title' => __( 'Default', 'themify' )
								),
								array(
									'value' => 'full_width',
									'img' => 'themify/img/fullwidth.png',
									'title' => __( 'Fullwidth', 'themify' )
								)
							),
							'default' => 'default_width',
						),
						// Post Image
						array(
							'name' 		=> 'post_image',
							'title' 		=> __('Featured Image', 'themify'),
							'description' => '',
							'type' 		=> 'image',
							'meta'		=> array()
						),
						// Featured Image Size
						array(
							'name'	=>	'feature_size',
							'title'	=>	__('Image Size', 'themify'),
							'description' => sprintf(__('Image sizes can be set at <a href="%s">Media Settings</a> and <a href="%s" target="_blank">Regenerated</a>', 'themify'), 'options-media.php', 'admin.php?page=regenerate-thumbnails'),
							'type'		 =>	'featimgdropdown',
							'display_callback' => 'themify_is_image_script_disabled'
						),
						// Multi field: Image Dimension
						themify_image_dimensions_field(),		
						// Hide Post Title
						array(
							'name' 		=> 'hide_post_title',
							'title' 		=> __('Hide Title', 'themify'),
							'description' => '',
							'type' 		=> 'dropdown',
							'meta'		=> array(
								array('value' => 'default', 'name' => '', 'selected' => true),
								array('value' => 'yes', 'name' => __('Yes', 'themify')),
								array('value' => 'no',	'name' => __('No', 'themify'))
							),
							'default' => 'default',
						),
						// Unlink Post Title
						array(
							'name' 		=> 'unlink_post_title',
							'title' 		=> __('Unlink Title', 'themify'),
							'description' => __('Unlink post title (it will display the post title without link)', 'themify'),
							'type' 		=> 'dropdown',
							'meta'		=> array(
								array('value' => 'default', 'name' => '', 'selected' => true),
								array('value' => 'yes', 'name' => __('Yes', 'themify')),
								array('value' => 'no',	'name' => __('No', 'themify'))
							),
							'default' => 'default',
						),
						// Multi field: Hide Post Meta
						themify_multi_meta_field(),
						// Hide Post Date
						array(
							'name' 		=> 'hide_post_date',
							'title' 		=> __('Hide Date', 'themify'),
							'description' => '',
							'type' 		=> 'dropdown',
							'meta'		=> array(
								array('value' => 'default', 'name' => '', 'selected' => true),
								array('value' => 'yes', 'name' => __('Yes', 'themify')),
								array('value' => 'no',	'name' => __('No', 'themify'))
							),
							'default' => 'default',
						),
						// Hide Post Image
						array(
							'name' 		=> 'hide_post_image',
							'title' 		=> __('Hide Featured Image', 'themify'),
							'description' => '',
							'type' 		=> 'dropdown',
							'meta'		=> array(
								array('value' => 'default', 'name' => '', 'selected' => true),
								array('value' => 'yes', 'name' => __('Yes', 'themify')),
								array('value' => 'no',	'name' => __('No', 'themify'))
							),
							'default' => 'default',
						),
						// Unlink Post Image
						array(
							'name' 		=> 'unlink_post_image',
							'title' 		=> __('Unlink Featured Image', 'themify'),
							'description' => __('Display the Featured Image without link', 'themify'),
							'type' 		=> 'dropdown',
							'meta'		=> array(
								array('value' => 'default', 'name' => '', 'selected' => true),
								array('value' => 'yes', 'name' => __('Yes', 'themify')),
								array('value' => 'no',	'name' => __('No', 'themify'))
							),
							'default' => 'default',
						),
						// Video URL
						array(
							'name' 		=> 'video_url',
							'title' 		=> __('Video URL', 'themify'),
							'description' => __('Replace Featured Image with a video embed URL such as YouTube or Vimeo video url (<a href="https://themify.me/docs/video-embeds">details</a>).', 'themify'),
							'type' 		=> 'textbox',
							'meta'		=> array()
						),
						// External Link
						array(
							'name' 		=> 'external_link',
							'title' 		=> __('External Link', 'themify'),
							'description' => __('Link Featured Image and Post Title to external URL', 'themify'),
							'type' 		=> 'textbox',
							'meta'		=> array()
						),
						// Lightbox Link + Zoom icon
						themify_lightbox_link_field(),
						// Custom menu
						array(
							'name'        => 'custom_menu',
							'title'       => __( 'Custom Menu', 'themify' ),
							'description' => '',
							'type'        => 'dropdown',
							// extracted from $args
							'meta'        => $nav_menus,
						),

					 ),
					'pages'   => $post_type_name
				),
				array(
					'name'    => __( 'Page Appearance', 'themify' ),
					'id'      => $post_type_name.'-theme-design',
					'options' => themify_theme_page_theme_design_meta_box( array(
						'header_design_options' => $header_design_options,
						'footer_design_options' => $footer_design_options,
						'font_design_options'   => $font_design_options,
						'color_design_options'  => $color_design_options,
						'background_slider'		=> $background_slider,
						'background_mode'		=> $background_mode,
					) ),
					'pages'   => $post_type_name
				),
			);
			return isset( $cpt_metaboxes ) ? array_merge( $cpt_metaboxes, $meta_boxes ) : $meta_boxes;

		}
		add_filter( 'themify_metabox/fields/themify-meta-boxes', 'themify_CPT_setup_metaboxes', 10, 2 );

	}
}
add_action('wp_loaded', 'addThemifyMeta');

function themify_default_cpt_post_layout( $data = array()){
	
    $title = $data['attr']['title'];
    $title = str_replace(" Single Post Layout", "", $title);
    
    $nmco_cpt_post_types = get_option('nmco_cpt_post_types');
    foreach($nmco_cpt_post_types as $postType){
        $postTObj = get_post_type_object($postType);
        $cptName = $postTObj->name;
        if($title == $postTObj->labels->name){
            break;
        }
    }
    
    $data = themify_get_data();

	/**
	 * Theme Settings Option Key Prefix
	 * @var string
	 */
	$prefix = 'setting-default_'.$cptName.'_';

	/**
	 * Tertiary options <blank>|yes|no
	 * @var array
	 */
	$default_options = array(
		array('name' => '', 'value' => ''),
		array('name' => __('Yes', 'themify'), 'value' => 'yes'),
		array('name' => __('No', 'themify'), 'value' => 'no')
	);

	/**
	 * Sidebar placement options
	 * @var array
	 */
	$sidebar_location_options = array(
		array('value' => 'sidebar1', 'img' => 'images/layout-icons/sidebar1.png', 'selected' => true, 'title' => __('Sidebar Right', 'themify')),
		array('value' => 'sidebar1 sidebar-left', 'img' => 'images/layout-icons/sidebar1-left.png', 'title' => __('Sidebar Left', 'themify')),
		array('value' => 'sidebar2', 'img' => 'images/layout-icons/sidebar2.png', 'title' => __('Left and Right', 'themify')),
		array('value' => 'sidebar2 content-left', 	'img' => 'images/layout-icons/sidebar2-content-left.png', 'title' => __('2 Right Sidebars', 'themify')),
		array('value' => 'sidebar2 content-right', 	'img' => 'images/layout-icons/sidebar2-content-right.png', 'title' => __('2 Left Sidebars', 'themify')),
		array('value' => 'sidebar-none', 'img' => 'images/layout-icons/sidebar-none.png', 'title' => __('No Sidebar', 'themify'))
	);
	
	/**
     * Post Layout options
     * @var array
     */
    $post_layout = array(
        array('selected' => true, 'value' => 'classic', 'img' => 'images/layout-icons/post-classic.png', 'title' => __('Classic', 'themify')),
        array('value' => 'fullwidth', 'img' => 'images/layout-icons/post-fullwidth.png', 'title' => __('Fullwidth', 'themify')),
        array('value' => 'slider', 'img' => 'images/layout-icons/post-slider.png', 'title' => __('Slider', 'themify')),
        array('value' => 'gallery', 'img' => 'images/layout-icons/post-gallery.png', 'title' => __('Gallery', 'themify')),
        array('value' => 'split', 'img' => 'images/layout-icons/post-split.png', 'title' => __('Split', 'themify'))
    );
	
	/**
	 * Image alignment options
	 * @var array
	 */
	$alignment_options = array(
		array('name' => '', 'value' => ''),
		array('name' => __('Left', 'themify'), 'value' => 'left'),
		array('name' => __('Right', 'themify'), 'value' => 'right')
	);

	/**
	 * Entry media position, above or below the title
	 */
	$media_position = array(
		array('name'=>__('Above Post Title', 'themify'), 'value'=>'above'),
		array('name'=>__('Below Post Title', 'themify'), 'value'=>'below'),
	);

	/**
	 * Module markup
	 * @var string
	 */
	$output = '';

	/**
	 * Post sidebar placement
	 */
	$output .= '<p>
					<span class="label">' . __('Post Sidebar Option', 'themify') . '</span>';
	$val = themify_get( $prefix . 'post_layout' );
	foreach($sidebar_location_options as $option){
		if(($val == '' || !$val || !isset($val)) && $option['selected']){
			$val = $option['value'];
		}
		if($val == $option['value']){
			$class = 'selected';
		} else {
			$class = '';
		}
		$output .= '<a href="#" class="preview-icon '.$class.'" title="'.$option['title'].'"><img src="'.THEME_URI.'/'.$option['img'].'" alt="'.$option['value'].'"  /></a>';
	}
	$output .= '	<input type="hidden" name="'.$prefix.'post_layout" class="val" value="'.$val.'" />
				</p>';
				
	 /**
     * Post Layout placement
     */
    $output .= '<p>
					<span class="label">' . __('Post Layout', 'themify') . '</span>';
    $val = themify_get($prefix . 'post_layout_type');
    foreach ($post_layout as $option) {
        if (( $val == '' || !$val || !isset($val) ) && ( isset($option['selected']) && $option['selected'] )) {
            $val = $option['value'];
        }
        if ($val == $option['value']) {
            $class = 'selected';
        } else {
            $class = '';
        }
        $output .= '<a href="#" class="preview-icon ' . $class . '" title="' . $option['title'] . '"><img src="' . THEME_URI . '/' . $option['img'] . '" alt="' . $option['value'] . '"  /></a>';
    }
    $output .= '	<input type="hidden" name="' . $prefix . 'post_layout_type" class="val" value="' . $val . '" />
				</p>';

	/**
	 * Hide Post Title
	 */
	$output .= '<p>
					<span class="label">' . __('Hide Post Title', 'themify') . '</span>
					<select name="'.$prefix.'post_title">'.
						themify_options_module($default_options, $prefix.'post_title') . '
					</select>
				</p>';

	/**
	 * Unlink Post Title
	 */
	$output .= '<p>
					<span class="label">' . __('Unlink Post Title', 'themify') . '</span>
					<select name="'.$prefix.'unlink_post_title">'.
						themify_options_module($default_options, $prefix.'unlink_post_title') . '
					</select>
				</p>';

	/**
	 * Hide Post Meta
	 */
	$output .= themify_post_meta_options($prefix.'post_meta', $data);

	/**
	 * Hide Post Date
	 */        
	$output .= '<p>
					<span class="label">' . __('Hide Post Date', 'themify') . '</span>
					<select onchange="jQuery(this).val()===\'yes\'?jQuery(\'#'.$prefix.'display_post_date_wrap\').fadeOut():jQuery(\'#'.$prefix.'display_post_date_wrap\').fadeIn();" name="'.$prefix.'post_date">'.
						themify_options_module($default_options, $prefix.'post_date') . '
					</select>
										<br/><br/>
										<span id="'.$prefix.'display_post_date_wrap" class="pushlabel">
										   <label for="'.$prefix.'display_date_inline"><input type="checkbox" value="1" id="'.$prefix.'display_date_inline" name="'.$prefix.'display_date_inline" ' . checked( themify_get( $prefix.'display_date_inline' ), 1, false ) . '/>'. __('Display post date as inline text instead of circle style', 'themify') .'
										</span>
				</p>';

	/**
	 * Featured Image/Media Position
	 */
	$output .= '<p>
					<span class="label">' . __( 'Featured Image/Media Position', 'themify' ) . '</span>
					<select name="' . esc_attr( $prefix ) . 'single_media_position">' .
						themify_options_module( $media_position, $prefix . 'single_media_position' ) . '
					</select>
				</p>';
	

	/**
	 * Hide Featured Image
	 */
	$output .= '<p>
					<span class="label">' . __('Hide Featured Image', 'themify') . '</span>
					<select name="'.$prefix.'post_image">'.
						themify_options_module($default_options, $prefix.'post_image') . '
					</select>
				</p>';

	/**
	 * Unlink Featured Image
	 */
	$output .= '<p>
					<span class="label">' . __('Unlink Featured Image', 'themify') . '</span>
					<select name="'.$prefix.'unlink_post_image">'.
						themify_options_module($default_options, $prefix.'unlink_post_image') . '
					</select>
				</p>';
	/**
	 * Featured Image Sizes
	 */
	$output .= themify_feature_image_sizes_select('image_post_single_feature_size');

	/**
	 * Image dimensions
	 */
	$output .= '<p>
			<span class="label">' . __('Image Size', 'themify') . '</span>
					<input type="text" class="width2" name="setting-image_post_single_width" value="' . themify_get( 'setting-image_post_single_width' ) . '" /> ' . __('width', 'themify') . ' <small>(px)</small>
					<input type="text" class="width2 show_if_enabled_img_php" name="setting-image_post_single_height" value="' . themify_get( 'setting-image_post_single_height' ) . '" /> <span class="show_if_enabled_img_php">' . __('height', 'themify') . ' <small>(px)</small></span>
					<br /><span class="pushlabel show_if_enabled_img_php"><small>' . __('Enter height = 0 to disable vertical cropping with img.php enabled', 'themify') . '</small></span>
				</p>';

	/**
	 * Disable comments
	 */
	$pre = 'setting-comments_posts';
	$comments_posts_checked = themify_check( $pre ) ? 'checked="checked"': '';
	$output .= '<p><span class="label">' . __('Post Comments', 'themify') . '</span><label for="'.$pre.'"><input type="checkbox" id="'.$pre.'" name="'.$pre.'" '.$comments_posts_checked.' /> ' . __('Disable comments in all Posts', 'themify') . '</label></p>';

	/**
	 * Show author box
	 */
	$pre = 'setting-post_author_box';
	$author_box_checked = themify_check( $pre ) ? 'checked="checked"': '';

	$output .= '<p><span class="label">' . __('Show Author Box', 'themify') . '</span><label for="'.$pre.'"><input type="checkbox" id="'.$pre.'" name="'.$pre.'" '.$author_box_checked.' /> ' . __('Show author box in all Posts', 'themify') . '</label></p>';

	/**
	 * Remove Post Navigation
	 */
	$pre = 'setting-post_nav_';
	$output .= '<p>
					<span class="label">' . __('Post Navigation', 'themify') . '</span>
					<label for="'.$pre.'disable">
						<input type="checkbox" id="' . $pre . 'disable" name="' . $pre . 'disable" ' . checked( themify_get( $pre . 'disable' ), 'on', false ) . '/> ' . __( 'Remove Post Navigation', 'themify' ) . '
						</label>
					<span class="pushlabel vertical-grouped">
						<label for="'.$pre.'same_cat">
							<input type="checkbox" id="' . $pre . 'same_cat" name="' . $pre . 'same_cat" ' . checked( themify_get( $pre . 'same_cat' ), 'on', false ) . '/> ' . __( 'Show only posts in the same category', 'themify' ) . '
						</label>
					</span>
				</p>';

	return $output;
}

/**
 * Default Index Layout Module
 * @param array $data Theme settings data
 * @return string Markup for module.
 * @since 1.0.0
 */
function themify_default_cpt_layout( $data = array() ){
	
    $title = $data['attr']['title'];
    $title = str_replace(" Archive Layout", "", $title);
    
    $nmco_cpt_post_types = get_option('nmco_cpt_post_types');
    foreach($nmco_cpt_post_types as $postType){
        $postTObj = get_post_type_object($postType);
        $cptName = $postTObj->name;
        if($title == $postTObj->labels->name){
            break;
        }
    }
	$data = themify_get_data();

	/**
	 * Theme Settings Option Key Prefix
	 * @var string
	 */
	$prefix = 'setting-default_archive_'.$cptName.'_';
	
	if ( ! isset( $data[$prefix . 'more_text'] ) || '' == $data[$prefix . 'more_text'] ) {
		$more_text = __( 'More', 'themify' );
	} else {
		$more_text = $data[$prefix . 'more_text'];
	}

	/**
	 * Tertiary options <blank>|yes|no
	 * @var array
	 */
	$default_options = array(
		array('name' => '', 'value' => ''),
		array('name' => __('Yes', 'themify'), 'value' => 'yes'),
		array('name' => __('No', 'themify'), 'value' => 'no')
	);

	/**
	 * Default options 'yes', 'no'
	 * @var array
	 */
	$binary_options = array(
		array('name'=>__('Yes', 'themify'),'value'=>'yes'),
		array('name'=>__('No', 'themify'),'value'=>'no')
	);

	/**
	 * Post content display options
	 * @var array
	 */
	$default_display_options = array(
		array('name' => __('Full Content', 'themify'),'value' => 'content'),
		array('name' => __('Excerpt', 'themify'),'value' => 'excerpt'),
		array('name' => __('None', 'themify'),'value' => 'none')
	);

	/**
	 * Post layout options
	 * @var array
	 */
	$default_post_layout_options = array(
		array('value' => 'list-post', 'img' => 'images/layout-icons/list-post.png', 'title' => __( 'List Post', 'themify' ), "selected" => true),
		array('value' => 'grid4', 'img' => 'images/layout-icons/grid4.png', 'title' => __( 'Grid 4', 'themify' )),
		array('value' => 'grid3', 'img' => 'images/layout-icons/grid3.png', 'title' => __( 'Grid 3', 'themify' )),
		array('value' => 'grid2', 'img' => 'images/layout-icons/grid2.png', 'title' => __( 'Grid 2', 'themify' )),
		array('value' => 'list-large-image', 'img' => 'images/layout-icons/list-large-image.png', 'title' => __('List Large Image', 'themify')),
		array('value' => 'list-thumb-image', 'img' => 'images/layout-icons/list-thumb-image.png', 'title' => __('List Thumb Image', 'themify')),
		array('value' => 'grid2-thumb', 'img' => 'images/layout-icons/grid2-thumb.png', 'title' => __('Grid 2 Thumb', 'themify')),
		array('value' => 'auto_tiles', 'img' => 'images/layout-icons/auto-tiles.png', 'title' => __('Auto Tiles', 'themify'))
	);

	/**
	 * Sidebar placement options
	 * @var array
	 */
	$sidebar_location_options = array(
		array('value' => 'sidebar1', 'img' => 'images/layout-icons/sidebar1.png', 'selected' => true, 'title' => __('Sidebar Right', 'themify')),
		array('value' => 'sidebar1 sidebar-left', 'img' => 'images/layout-icons/sidebar1-left.png', 'title' => __('Sidebar Left', 'themify')),
		array('value' => 'sidebar2', 'img' => 'images/layout-icons/sidebar2.png', 'title' => __('Left and Right', 'themify')),
		array('value' => 'sidebar2 content-left', 	'img' => 'images/layout-icons/sidebar2-content-left.png', 'title' => __('2 Right Sidebars', 'themify')),
		array('value' => 'sidebar2 content-right', 	'img' => 'images/layout-icons/sidebar2-content-right.png', 'title' => __('2 Left Sidebars', 'themify')),
		array('value' => 'sidebar-none', 'img' => 'images/layout-icons/sidebar-none.png', 'title' => __('No Sidebar', 'themify'))
	);

	/**
	 * Image alignment options
	 * @var array
	 */
	$alignment_options = array(
		array('name' => '', 'value' => ''),
		array('name' => __('Left', 'themify'), 'value' => 'left'),
		array('name' => __('Right', 'themify'), 'value' => 'right')
	);

	/**
	 * Entry media position, above or below the title
	 */
	$media_position = array(
		array('name'=>__('Above Post Title', 'themify'), 'value'=>'above'),
		array('name'=>__('Below Post Title', 'themify'), 'value'=>'below'),
	);

	/**
	 * HTML for settings panel
	 * @var string
	 */
	$output = '<div class="themify-info-link">' . __( 'Here you can set the <a href="https://themify.me/docs/default-layouts">Default Layouts</a> for WordPress archive post layout (category, search, archive, tag pages, etc.), single post layout (single post page), and the static Page layout. The default single post and page layout can be override individually on the post/page &gt; edit &gt; Themify Custom Panel.', 'themify' ) . '</div>';
	
	/**
	 * Index Sidebar Option
	 */
	$output .= '<p>
					<span class="label">' . __('Archive Sidebar Option', 'themify') . '</span>';
	$val = isset( $data[$prefix.'layout'] ) ? $data[$prefix.'layout'] : '';
	foreach($sidebar_location_options as $option){
		if(($val == '' || !$val || !isset($val)) && $option['selected']){ 
			$val = $option['value'];
		}
		if($val == $option['value']){ 
			$class = 'selected';
		} else {
			$class = '';
		}
		$output .= '<a href="#" class="preview-icon ' . esc_attr( $class ) . '" title="' . esc_attr( $option['title'] ) . '"><img src="' . esc_url( THEME_URI.'/'.$option['img'] ) . '" alt="' . esc_attr( $option['value'] ) . '"  /></a>';	
	}
	
	$output .= '	<input type="hidden" name="' . esc_attr( $prefix ) . 'layout" class="val" value="' . esc_attr( $val ) . '" />
				</p>';

	/**
	 * Post Layout
	 */
	$output .= '<p class="clearfix">
					<span class="label">' . __('Post Layout', 'themify') . '</span><span class="preview-icon-wrapper">';
	$val = isset( $data[$prefix.'post_layout'] ) ? $data[$prefix.'post_layout'] : '';
	foreach($default_post_layout_options as $option){
		if(($val == '' || !$val || !isset($val)) && $option['selected']){ 
			$val = $option['value'];
		}
		if($val == $option['value']){ 
			$class = 'selected';
		} else {
			$class = '';
		}
		$output .= '<a href="#" class="preview-icon ' . esc_attr( $class ) . '" title="' . esc_attr( $option['title'] ) . '"><img src="' . esc_url( THEME_URI.'/'.$option['img'] ) . '" alt="' . esc_attr( $option['value'] ) . '"  /></a>';	
	}

	$output .= '	<input type="hidden" name="' . esc_attr( $prefix ) . 'post_layout" class="val" value="' . esc_attr( $val ) . '" />
				</span></p>';

	/**
	 * Post Content Layout
	 */
	$output .= '<p>
					<span class="label">' . __( 'Post Content Layout', 'themify' ) . '</span>
					<select name="setting-post_'.$cptName.'_archive_content_layout">'.
						themify_options_module( array(
							array( 'name' => __( 'Default', 'themify' ), 'value' => '' ),
							array( 'name' => __( 'Overlay', 'themify' ), 'value' => 'overlay' ),
							array( 'name' => __( 'Polaroid', 'themify' ), 'value' => 'polaroid' ),
							array( 'name' => __( 'Boxed', 'themify' ), 'value' => 'boxed' ),
							array( 'name' => __( 'Flip', 'themify' ), 'value' => 'flip' )
						), 'setting-post_'.$cptName.'_archive_content_layout' ) . '
					</select>
				</p>';
	
	/**
	 * Enable Post Filter
	 */
	$output .= '<p><span class="label">' . __( 'Post Filter', 'themify' ) . '</span>
					<select name="setting-post_'.$cptName.'_archive_filter">' 
					. themify_options_module( $binary_options, 'setting-post_'.$cptName.'_archive_filter', true, 'no' ) . '
					</select>
				</p>';

	/*$output .= '<p data-show-if-element="[name=setting-post_'.$cptName.'_archive_filter]" data-show-if-value="yes">
					<span class="pushlabel vertical-grouped"><label for="setting-filter-category"><input type="checkbox" value="1" id="setting-filter-category" name="setting-filter-category" '.checked( themify_get( 'setting-filter-category' ), 1, false ).'/> ' . __( 'Display only child categories on category archive', 'themify') . '</label></span>
				</p>';*/

	/**
	 * Enable Masonry
	 */
	$output .=	'<p>
					<span class="label">' . __('Post Masonry', 'themify') . '</span>
					<select name="setting-disable_'.$cptName.'_archive_masonry">' .
						themify_options_module($binary_options, 'setting-disable_'.$cptName.'_archive_masonry') . '
					</select>
				</p>';

	/**
	 * Post Gutter
	 */
	$output .= '<p>
					<span class="label">' . __( 'Post Gutter', 'themify' ) . '</span>
					<select name="setting-post_'.$cptName.'_archive_gutter">'.
						themify_options_module( array(
							array( 'name' => __( 'Default', 'themify' ), 'value' => 'gutter' ),
							array( 'name' => __( 'No gutter', 'themify' ), 'value' => 'no-gutter' )
						), 'setting-post_'.$cptName.'_archive_gutter' ) . '
					</select>
				</p>';

	/**
	 * Display Content
	 */
	$output .= '<p>
					<span class="label">' . __('Display Content', 'themify') . '</span> 
					<select name="' . esc_attr( $prefix ) . 'layout_display">'.
						themify_options_module($default_display_options, $prefix.'layout_display').'
					</select>
				</p>';

	/**
	 * Excerpt length
	 */
	$output .= '<p style="display:none">
					<span class="pushlabel vertical-grouped">
						<label>
							<input class="width2" type="text" value="' . ( isset( $data[ $prefix . 'excerpt_length' ] ) ? esc_attr( $data[ $prefix . 'excerpt_length' ] ) : '' ) . '" name="' . esc_attr( $prefix ) . 'excerpt_length"> '
							. __( 'Excerpt length (enter number of words)', 'themify' ) . '
						</label>
					</span>
				</p>';
	
	/**
	 * More Text
	 */
	$output .= '<p>
					<span class="label">' . __('More Text', 'themify') . '</span>
					<input type="text" name="' . esc_attr( $prefix ) . 'more_text" value="' . esc_attr( $more_text ) . '">
					
					<span class="pushlabel vertical-grouped"><label for="setting-excerpt_more"><input type="checkbox" value="1" id="setting-excerpt_more" name="setting-excerpt_more" '.checked( themify_get( 'setting-excerpt_more' ), 1, false ).'/> ' . __('Display more link button in excerpt mode as well.', 'themify') . '</label></span>
				</p>';

	/**
	 * Order & OrderBy Options
	 */
//	$output .= themify_post_sorting_options('setting-index_'.$cptName.'_order', $data);
				
	/**
	 * Hide Post Title
	 */
	$output .= '<p>
					<span class="label">' . __('Hide Post Title', 'themify') . '</span>
					<select name="' . esc_attr( $prefix ) . 'post_title">' .
						themify_options_module($default_options, $prefix.'post_title') . '
					</select>
				</p>';
	
	/**
	 * Unlink Post Title
	 */
	$output .= '<p>
					<span class="label">' . __('Unlink Post Title', 'themify') . '</span>
					<select name="' . esc_attr( $prefix ) . 'unlink_post_title">' .
						themify_options_module($default_options, $prefix.'unlink_post_title') . '
					</select>
				</p>';
	
	/**
	 * Hide Post Meta
	 */
	$output .= themify_post_meta_options($prefix.'post_meta', $data);
	
	/**
	 * Hide Post Date
	 */
	$output .= '<p>
					<span class="label">' . __('Hide Post Date', 'themify') . '</span>
					<select onchange="jQuery(this).val()===\'yes\'?jQuery(\'#'.$prefix.'display_date_inline_wrap\').fadeOut():jQuery(\'#'.$prefix.'display_date_inline_wrap\').fadeIn();" name="' . esc_attr( $prefix ) . 'post_date">' .
						themify_options_module($default_options, $prefix.'post_date') . '
					</select>
					<br/><br/>
					<span id="'.$prefix.'display_date_inline_wrap" class="pushlabel">
					   <label for="'.$prefix.'display_date_inline"><input type="checkbox" value="1" id="'.$prefix.'display_date_inline" name="'.$prefix.'display_date_inline" ' . checked( themify_get( $prefix.'display_date_inline' ), 1, false ) . '/>'. __('Display post date as inline text instead of circle style', 'themify') .'
					</span>
				</p>';
	
	/**
	 * Auto Featured Image
	 */
	$output .= '<p>
					<span class="label">' . __('Auto Featured Image', 'themify') . '</span>
					<label for="setting-auto_featured_image"><input type="checkbox" value="1" id="setting-auto_featured_image" name="setting-auto_featured_image" ' . checked( themify_get( 'setting-auto_featured_image' ), 1, false ) . '/> ' . __( 'If no featured image is specified, display first image in content.', 'themify' ) . '</label>
				</p>';
	
	/**
	 * Featured Image/Media Position
	 */
	$output .= '<p>
					<span class="label">' . __( 'Featured Image/Media Position', 'themify' ) . '</span>
					<select name="' . esc_attr( $prefix ) . 'media_position">' .
						themify_options_module( $media_position, $prefix.'media_position' ) . '
					</select>
				</p>';
	
	/**
	 * Hide Featured Image
	 */
	$output .= '<p>
					<span class="label">' . __('Hide Featured Image', 'themify') . '</span>
					<select name="' . esc_attr( $prefix ) . 'post_image">' .
						themify_options_module($default_options, $prefix.'post_image') . '
					</select>
				</p>';
	
	/**
	 * Unlink Featured Image
	 */
	$output .= '<p>
					<span class="label">' . __('Unlink Featured Image', 'themify') . '</span>
					<select name="' . esc_attr( $prefix ) . 'unlink_post_image">' .
						themify_options_module($default_options, $prefix.'unlink_post_image') . '
					</select>
				</p>';
	
	/**
	 * Featured Image Sizes
	 */
	$output .= themify_feature_image_sizes_select('image_post_feature_size');
	
	/**
	 * Image Dimensions
	 */	
	$output .= '<p>
					<span class="label">' . __('Image Size', 'themify') . '</span>  
					<input type="text" class="width2" name="setting-image_post_width" value="' . themify_get( 'setting-image_post_width' ) . '" /> ' . __('width', 'themify') . ' <small>(px)</small>
					<input type="text" class="width2 show_if_enabled_img_php" name="setting-image_post_height" value="' . themify_get( 'setting-image_post_height' ) . '" /> <span class="show_if_enabled_img_php">' . __('height', 'themify') . ' <small>(px)</small></span>
					<br /><span class="pushlabel show_if_enabled_img_php"><small>' . __('Enter height = 0 to disable vertical cropping with img.php enabled', 'themify') . '</small></span>
				</p>';
	
	return $output;
}
/*if ( ! function_exists( 'themify_cpt_post_sorting_options' ) ) {
	function themify_cpt_post_sorting_options( $key = 'setting-index_order', $data ) {

		$orderby = themify_get( $key . 'by' );
		$orderby_options = apply_filters( 'themify_index_orderby_options', array(
			__( 'Date (default)', 'themify' ) => 'date',
			__( 'Random', 'themify' ) => 'rand',
			__( 'Author', 'themify' ) => 'author',
			__( 'Post Title', 'themify' ) => 'title',
			__( 'Comments Number', 'themify' ) => 'comment_count',
			__( 'Modified Date', 'themify' ) => 'modified',
			__( 'Post Slug', 'themify' ) => 'name',
			__( 'Post ID', 'themify' ) => 'ID',
			__( 'Custom Field String', 'themify' ) => 'meta_value',
			__( 'Custom Field Numeric', 'themify' ) => 'meta_value_num' ) );

		$order = themify_get( $key );
		$order_options = array(
			__( 'Descending (default)', 'themify' ) => 'DESC',
			__( 'Ascending', 'themify' ) => 'ASC' );
        $cptName = str_replace('setting-index', '', esc_attr( $key ));
        $cptName = str_replace('_order', '', $cptName);
		$order_meta_key = 'setting-index'.$cptName.'_meta_key';
		$order_meta_key_value = themify_get( $order_meta_key );

		$out = '<p>
					<span class="label">' . __( 'Order By', 'themify' ) . ' </span>
					<select name="' . esc_attr( $key . 'by' ) . '">';
						foreach ( $orderby_options as $option => $value ) {
							$out .= '<option value="' . esc_attr( $value ) . '" '.selected( $value? $value: 'date', $orderby, false ).'>' . esc_html( $option ) . '</option>';
							}
		$out .= '	</select>
				</p>
				<p data-show-if-element="[name=' . $key . 'by]" data-show-if-value=\'["meta_value", "meta_value_num"]\'>
					<span class="label">' . __( 'Custom Field Key', 'themify' ) . ' </span>
					<input type="text" id="' . esc_attr( $order_meta_key ) . '" name="' . esc_attr( $order_meta_key ) . '" value="' . esc_attr( $order_meta_key_value ) . '" />
				</p>
				<p>
					<span class="label">' . __( 'Order', 'themify' ) . ' </span>
					<select name="' . esc_attr( $key ) . '">';
						foreach ( $order_options as $option => $value ) {
							$out .= '<option value="' . esc_attr( $value ) . '" '.selected( $value? $value: 'DESC', $order, false ).'>' . esc_html( $option ) . '</option>';
					}
		$out .= '	</select>
				</p>';

		return $out;
	}
}*/