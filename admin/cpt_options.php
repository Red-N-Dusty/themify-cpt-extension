<?php 
defined( 'ABSPATH' ) or die( 'No direct access allowed.' ); 
?>
<div class="wrap">
	<h2>
		<?php _e( 'Custom Post Type Integration with Themify Themes' ); ?>
	</h2>
	<p>This settings page is meant to help incorporate the Themify's extended Post Options and Page Appearance tabs found on Post edit pages to custom post types.</p>
	<?php

	$args = array(
	   'public'   => true,
	   '_builtin' => false
	);
	$output = 'objects'; // names or objects

	$post_types = get_post_types( $args, $output );
	
	$nmco_cpt_options_obj = get_option('nmco_cpt_post_types');
	
	/*echo "<pre>";
	print_r(get_option('nmco_cpt_post_types'));
	echo "</pre>";*/
	
	foreach($nmco_cpt_options_obj as $cpt_post_type){
		$post_type_obj = get_post_type_object($cpt_post_type);
		/*echo "<pre>";
		print_r($post_type_obj);
		echo "</pre>";*/
	
		/*$prefix = $post_type_obj->name;

		$functionName = $prefix . "_custom_type_init";
		echo $functionName."<br/>";

		${$functionName} = function() use ($prefix) {

			echo $functionName." - It's working<br/>";

		};
		
		${$functionName}();*/
	}
	
	?>

	<form method="post" action="options.php">
		<?php settings_fields( 'nmco_cpt' ); ?>
		<?php do_settings_sections( 'nmco_cpt' ); ?>

		<table class="form-table">
			<tr>
				<th style="width:20%;">Which Post Types Can Use the Themify Extended Custom Panel Tabs?</th>
				<td>
				<?php
				foreach ( $post_types  as $post_type ) { 
					$post_type_name = $post_type->name;
					if(strpos($post_type_name, 'tbuilder') === false && $post_type_name !="product"){?>
					
					<p><?php echo $post_type->labels->name; ?> <input id="post-type-<?php echo $post_type->name;?>" name="nmco_cpt_post_types[]" type="checkbox" value="<?php echo $post_type->name;?>" <?php if ( in_array($post_type->name, $nmco_cpt_options_obj ) ): ?>checked="checked"<?php endif; ?> /></p>
					
					<?php
						/*echo '<pre>';
						print_r($post_type); 
						echo'</pre>';*/
					}
				}
				?>
				</td>
			</tr>

		</table>

		<?php submit_button(); ?>
	</form>
</div>