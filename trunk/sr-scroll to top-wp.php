<?php
/*
Plugin Name: sr-scroll-to-top-wp
Plugin URI:http://sohelrazzaque/plugins/sr-scroll-to-top-wp

Description: This plugin automatically add right corner in the footer area of your site that only appears when you scroll the page down, and when clicked gently roll the site to the top. All this without any modification to your template.sr-scroll to top-wp plugin makes the scrolling of a page easier. When the user click on this button it smoothly scrolls to the top of Web page.sr-scroll to top-wp plugin offers custom settings from <a href="options-general.php?page=scroll-option-page">option panel</a>.

Author:<a href="http://sohelrazzaque.com">sohel razzaque</a>
Author URI:http://sohelrazzaque.com
Version:1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/

 
 /* Adding Latest jQuery from Wordpress */
function sohel_jquery_latest_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'sohel_jquery_latest_jquery');



/*Some Set-up*/
function bappi_scroll_file() {

define('bappi_scroll_to_up', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );


wp_enqueue_script('bappi-scrollUp-jquery', bappi_scroll_to_up.'js/jquery.scrollUp.js', array('jquery'));
wp_enqueue_script('bappi-easing-jquery', bappi_scroll_to_up.'js/jquery.easing.min.js', array('jquery'));


wp_enqueue_style('bappi-transition-css', bappi_scroll_to_up.'css/bappi.transitions.css');
wp_enqueue_style('bappi-fontaweasome-css', bappi_scroll_to_up.'css/font-awesome.min.css');

}
add_action( 'wp_enqueue_scripts', 'bappi_scroll_file' );

              
          /*setting api */

        /*manu option 1.1 */

    function scroll_up_manu(){
	
	     add_options_page( 'scroll_manu_title', 'scroll to top menu', 'manage_options', 'scroll-option-page', 'bappi_scroll_options_page_function', plugins_url( 'myplugin/images/icon.png' ),8 );
	
	             
	}
	     add_action('admin_menu','scroll_up_manu');
		 
	  
			   
			 

	 
	// 2. Add default value array. 
$bappi_scroll_up_options_default = array(
	'scroll_Distance' => 300,
	'scroll_Speed' => 200,
	'animation_Speed' => 200,
	'animation_up' => 'fade',
	'scroll_up_radio_mode' => false,
);

  /*radio bottom option */
	
	$scroll_up_radio_mode=array(
	  'scroll_up_radio_yes'=>array(
	    'value'=>'true',
	    'label'=>'Active your single items'
	  ),  

	  'scroll_up_radio_no'=>array(
	    'value'=>'false',
	    'label'=>'Deactive your single items'
	  ),     
	
	
	
	
	);



    if ( is_admin() ) : // 3. Load only if we are viewing an admin page	

  // 4. Add setting option by used function. 
function bappiscroll_up_register_settings() {
	// Register settings and call sanitation functions
	// 4. Add register setting. 
	register_setting( 'bappiscroll_up_p_options', 'bappi_scroll_up_options_default', 'bappiscroll_up_validate_options' );
}

add_action( 'admin_init', 'bappiscroll_up_register_settings' );


 


  
   


 //1.2
	 function bappi_scroll_options_page_function(){?>
	 
	 <?php // 5.1. Add settings API hook under form action.  ?>
	<?php global $bappi_scroll_up_options_default,$scroll_up_radio_mode ;

	
	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. 

	?>
	 
	 
   <div class="wrap">
			      <h2>scroll up setting</h2>
							  <?php if ( false !== $_REQUEST['updated'] ) : ?>
					<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
					<?php endif; // 5.2. If the form has just been submitted, this shows the notification ?>	
				  
				<form action="options.php" method="post">  
				  
				  
		
				<?php // 6.1 Add settings API hook under form action.  ?>
			<?php $settings = get_option( 'bappi_scroll_up_options_default', $bappi_scroll_up_options_default ); ?>
			
			
			<?php settings_fields( 'bappiscroll_up_p_options' );
			/* 6.2  This function outputs some hidden fields required by the form,
			including a nonce, a unique number used to ensure the form has been submitted from the admin page and not somewhere else, very important for security */ ?>
		
		
		
					
				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row"><label for="scroll_Distance">scroll Distance</label></th>
								<td>
									<input type="text" class="" value="<?php echo stripslashes($settings['scroll_Distance']); ?>" id="scroll_Distance" name="bappi_scroll_up_options_default[scroll_Distance]"/><p class="description">Distance from top/bottom before showing element (px)<br/>Best position is 200px to 300px</p>
								</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="scroll_Speed">scroll Speed</label></th>
								<td>
									<input type="text" class="" value="<?php echo stripslashes($settings['scroll_Speed']); ?>" id="scroll_Speed" name="bappi_scroll_up_options_default[scroll_Speed]"/><p class="description">You can add your scroll Speed<br/>Speed back to top (ms) like auto,200,300,400</p>
								</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="animation_Speed">Animation scroll Speed</label></th>
								<td>
									<input type="text" class="" value="<?php echo stripslashes($settings['animation_Speed']); ?>" id="animation_Speed" name="bappi_scroll_up_options_default[animation_Speed]"/><p class="description">You can add your animation Speed<br/> Animation in speed (ms) like 200,300,400,</p>
								</td>
						</tr>
						
						<tr valign="top">
							<th scope="row"><label for="animation_up">animation effected</label></th>
								<td>
									<input type="text" class="" value="<?php echo stripslashes($settings['animation_up']); ?>" id="animation_up" name="bappi_scroll_up_options_default[animation_up]"/><p class="description">You can add your animation effected like 'fade','slide',hide,'none'</p>
								</td>
						</tr>
						
						<tr valign="top">
					<th scope="row"><label for="scroll_up_radio_mode">single items mode</label></th>
						<td>
					    <?php foreach ( $scroll_up_radio_mode as $activate): ?>
						<input type="radio" id="<?php echo $activate['value']; ?>" name="bappi_scroll_up_options_default[scroll_up_radio_mode]"  value="<?php esc_attr_e($activate['value']); ?>"<?php checked($settings['scroll_up_radio_mode'],$activate['value']); ?>  />
						<label for="<?php echo $activate['value']; ?>"><?php echo $activate ['label']; ?></label>
						<p class="description">You can add single items true or false</p><br/>
						<?php endforeach; ?>
					</td>
				</tr>
					
				</tbody>

			</table>


		<p class="submit">
			<input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
		</p>

</form>
			   
</div>
	 
	 
	<?php 
	 }
	 

  // 7. Add validate options. 
function bappiscroll_up_validate_options( $input ) {
	global $bappi_scroll_up_options_default,$scroll_up_radio_mode;

	$settings = get_option( 'bappi_scroll_up_options_default', $bappi_scroll_up_options_default );
	
	
	$input['scroll_Distance']=wp_filter_post_kses($input['scroll_Distance']);
	$input['scroll_Speed']=wp_filter_post_kses($input['scroll_Speed']);
	$input['animation_Speed']=wp_filter_post_kses($input['animation_Speed']);
	$input['animation_up']=wp_filter_post_kses($input['animation_up']);
	
	
	 // We strip all tags from the text field, to avoid vulnerablilties like XSS
	$prev=$settings['layout_only'];
	if(!array_key_exists($input['layout_only'],$scroll_up_radio_mode))
	$input['layout_only']=$prev;
	

 return $input;
}

 
	endif;  //3. EndIf is_admin()	


// 8.data danamic
		
	function scroll_up_activator(){?>
	<?php global $bappi_scroll_up_options_default;
	
	$bappiscroll_up_settings=get_option('bappi_scroll_up_options_default','$bappi_scroll_up_options_default'); ?>
	
	
	     <script>

		/* scrollUp Minimum setup */
		// $(function () {
		// 	$.scrollUp();
		// });

		// scrollUp full options
		jQuery(function () {
			jQuery.scrollUp({
		        scrollName: 'scrollUp', // Element ID
		        scrollDistance:"<?php echo $bappiscroll_up_settings['scroll_Distance']; ?>", // Distance from top/bottom before showing element (px)
		        scrollFrom: 'top', // 'top' or 'bottom'
		        scrollSpeed:"<?php echo $bappiscroll_up_settings['scroll_Speed']; ?>", // Speed back to top (ms)
		        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
		        animation: "<?php echo $bappiscroll_up_settings['animation_up']; ?>", // Fade, slide, none
		        animationSpeed: "<?php echo $bappiscroll_up_settings['animation_Speed']; ?>", // Animation in speed (ms)
		        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
						//scrollTarget: false, // Set a custom target element for scrolling to the top
		        scrollText: '', // Text for element, can contain HTML
		        scrollTitle: true, // Set a custom <a> title if required.
		        scrollImg: "<?php echo $bappiscroll_up_settings['scroll_up_radio_mode']; ?>", // Set true to use image
		        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
		        zIndex: 2147483647 // Z-Index for the overlay
			});
			jQuery("#scrollUp").append("<i class='fa fa-chevron-up'></i>");
		});

		

	</script>
	
	<?php
	}
	
    add_action('wp_head','scroll_up_activator');
 
 
 
 
 





       
                          






?>