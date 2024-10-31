<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://newip.pe
 * @since      1.0.0
 *
 * @package    Newcallcenter
 * @subpackage Newcallcenter/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Newcallcenter
 * @subpackage Newcallcenter/public
 * @author     New IP Solutions SAC <soporte@newip.pe>
 */
class Newcallcenter_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'wp_footer',array($this,'Newcallcenter_frontend_display') );
		add_action( 'wp_ajax_newcallcenter_ajax', array( $this,'newcallcenter_ph_calling_fn') );
		add_action( 'wp_ajax_nopriv_newcallcenter_ajax', array( $this,'newcallcenter_ph_calling_fn') );	

	}


		function newcallcenter_ph_calling_fn(){
			$phone_number = ! empty( $_POST[ 'phone_number' ] ) ? sanitize_text_field( $_POST[ 'phone_number' ] ) : '';
		if($phone_number){			
			$settings=get_option('newcallcenter_settings_option_name');			
			$url_server  = $settings['url_server'];			
			$username  = $settings['username'];
			$password  = $settings['password'];
			$idcampana  = $settings['idcampana'];			
			$api_url=$url_server.':4001/webtocall';
			
			$data = array(
			  'numero'    => $phone_number,
			  'idcampana' => $idcampana
			);

			$list_of_data=array(
			    'body'    => json_encode($data),
			    'timeout'     => 0,
		        'redirection' => 10,
		        'httpversion' => '1.0',
		        'blocking'    => true,
			    'headers' => array(
			        'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password ),	
			        'Content-Type'  => 'application/json'
			    ),
			) ;
		
			$response = wp_remote_post( $api_url, $list_of_data);	
			if ( is_array( $response ) && ! is_wp_error( $response ) ) {			
				$body    = json_decode($response['body'],true); // use the content					
				$body    = $response['body'];	
				$full_data=$body;
				global $wpdb;
				$multirowsArr=array();
				$multirowsArr[] = "('".$phone_number."','".$username."','".$password."','".$idcampana."','".$full_data."')";
				$table_name = $wpdb->prefix . 'newcallcenter_call_log ';		
				$multirows = implode(", ", $multirowsArr);   
				$inquery = "INSERT ignore INTO $table_name (phone_number,username,password,idcampana,api_response)  VALUES {$multirows}";  
				$wpdb->query($inquery);
				$id = $wpdb->insert_id;
				if($id){
					echo "success";
				}

			}	

		}
		die;
	}


		public function Newcallcenter_frontend_display(){
			

			$settings 			= get_option( 'newcallcenter_settings_option_name' );			
			if(isset($settings['active']) && ($settings['active']=='active') ){
				$position 			= $settings['postion'];				
				$open_type 			= 'modal';
				$toggle_layout 		= 'layout-one';	
				$settings['button_text']=$settings['start_message'];
				$requestion_phone_message=$settings['requestion_phone_message'];

				if(empty($settings['button_text'])):
					$settings['button_text']='Start';
				endif;

				if(empty($requestion_phone_message)):
					$requestion_phone_message='Requestion phone message';
				endif;
				
				$body_class = $open_type;

				wp_print_styles( array( 'sticky-floating-forms-lite-frontend','dashicons' ) );
			?>
			
			<div id="cww-sff-disp-wrap-outer" class="cww-ssf-outer-wrapp btn-position-<?php echo esc_attr ($position);?> <?php echo esc_attr($body_class)?>">
				<div class="cww-sff-inner">
					<div class="toggle-wrapp <?php echo esc_attr($toggle_layout)?>">
						<a class="cww-ssf-toggle" href="javascript:void(0)">
							<?php echo esc_html($settings['button_text']); ?>
						</a>	
					</div>

					<div class="emailSignup">							
					  	
						  	<div class="cww-sff-wrapp">						  		
								<i class="dashicons dashicons-no-alt"></i>							
								<h2><?php echo esc_html($requestion_phone_message);?></h2>
								<div class="newcallcenter_frm emailSignup--form">
									<form method="post" action="#"> 
										<div class="phone-form">
										<input type="number" name="phone" class="emailSignup--email-input" placeholder="Ingrese su número telefónico por favor" id='txtPhone' value=""  pattern="[0-9]{7}" required>
										  <button class="ripple emailSignup--email-submit">
										  	Contactar ahora
										  </button>
										<span id="spnPhoneStatus"></span>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			<div class="cww-sf-form-overlay"></div>
			<?php 
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Newcallcenter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Newcallcenter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/newcallcenter-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'_toast', plugin_dir_url( __FILE__ ) . 'css/jquery.toast.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Newcallcenter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Newcallcenter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name.'_toast', plugin_dir_url( __FILE__ ) . 'js/jquery.toast.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/newcallcenter-public.js', array( 'jquery' ), time(), true );
		$settings 			= get_option( 'newcallcenter_settings_option_name' );	
		$success_msg        = $settings['goodby_message'];
		wp_localize_script( $this->plugin_name, 'newcallcenter_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) , 'success_msg' => $success_msg ) );

	}



}
