<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://newip.pe
 * @since      1.0.0
 *
 * @package    Newcallcenter
 * @subpackage Newcallcenter/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Newcallcenter
 * @subpackage Newcallcenter/admin
 * @author     New IP Solutions SAC <soporte@newip.pe>
 */


class Newcallcenter_Admin {
	private $newcallcenter_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'newcallcenter_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'newcallcenter_settings_page_init' ) );
	}

	public function newcallcenter_settings_add_plugin_page() {
		add_menu_page(
			'Newcallcenter Settings', // page_title
			'Newcallcenter Settings', // menu_title
			'manage_options', // capability
			'newcallcenter-settings', // menu_slug
			array( $this, 'newcallcenter_settings_create_admin_page' ), // function
			'dashicons-phone', // icon_url
			2 // position
		);
	}

	public function newcallcenter_settings_create_admin_page() {
		$this->newcallcenter_settings_options = get_option( 'newcallcenter_settings_option_name' ); ?>

		<div class="wrap">
			<h2>Newcallcenter Settings</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'newcallcenter_settings_option_group' );
					do_settings_sections( 'newcallcenter-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function newcallcenter_settings_page_init() {
		register_setting(
			'newcallcenter_settings_option_group', // option_group
			'newcallcenter_settings_option_name', // option_name
			array( $this, 'newcallcenter_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'newcallcenter_settings_setting_section', // id
			'Settings', // title
			array( $this, 'newcallcenter_settings_section_info' ), // callback
			'newcallcenter-settings-admin' // page
		);

		add_settings_field(
			'url_server', // id
			'URL de servidor', // title
			array( $this, 'url_server_callback' ), // callback
			'newcallcenter-settings-admin', // page
			'newcallcenter_settings_setting_section' // section
		);

		add_settings_field(
			'username', // id
			'Usuario', // title
			array( $this, 'username_callback' ), // callback
			'newcallcenter-settings-admin', // page
			'newcallcenter_settings_setting_section' // section
		);

		add_settings_field(
			'password', // id
			'Contraseña', // title
			array( $this, 'password_callback' ), // callback
			'newcallcenter-settings-admin', // page
			'newcallcenter_settings_setting_section' // section
		);

		add_settings_field(
			'idcampana', // id
			'Identificador de campaña', // title
			array( $this, 'idcampana_callback' ), // callback
			'newcallcenter-settings-admin', // page
			'newcallcenter_settings_setting_section' // section
		);

		add_settings_field(
			'goodby_message', // id
			'Mensaje de despedida', // title
			array( $this, 'goodby_message_callback' ), // callback
			'newcallcenter-settings-admin', // page
			'newcallcenter_settings_setting_section' // section
		);

		add_settings_field(
			'start_message', // id
			'Mensaje de inicio', // title
			array( $this, 'start_message_callback' ), // callback
			'newcallcenter-settings-admin', // page
			'newcallcenter_settings_setting_section' // section
		);

		add_settings_field(
			'phone_message', // id
			'Mensaje de popup', // title
			array( $this, 'requestion_phone_message_callback' ), // callback
			'newcallcenter-settings-admin', // page
			'newcallcenter_settings_setting_section' // section
		);

		add_settings_field(
			'active', // id
			'Activo', // title
			array( $this, 'active_callback' ), // callback
			'newcallcenter-settings-admin', // page
			'newcallcenter_settings_setting_section' // section
		);

		add_settings_field(
			'position', // id
			'Posición', // title
			array( $this, 'postion_callback' ), // callback
			'newcallcenter-settings-admin', // page
			'newcallcenter_settings_setting_section' // section
		);
	}

	public function newcallcenter_settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['url_server'] ) ) {
			$sanitary_values['url_server'] = sanitize_text_field( $input['url_server'] );
		}

		if ( isset( $input['username'] ) ) {
			$sanitary_values['username'] = sanitize_text_field( $input['username'] );
		}

		if ( isset( $input['password'] ) ) {
			$sanitary_values['password'] = sanitize_text_field( $input['password'] );
		}

		if ( isset( $input['idcampana'] ) ) {
			$sanitary_values['idcampana'] = sanitize_text_field( $input['idcampana'] );
		}
	
		if ( isset( $input['requestion_phone_message'] ) ) {
			$sanitary_values['requestion_phone_message'] = sanitize_text_field( $input['requestion_phone_message'] );
		}

		if ( isset( $input['goodby_message'] ) ) {
			$sanitary_values['goodby_message'] = esc_textarea( $input['goodby_message'] );
		}

		if ( isset( $input['start_message'] ) ) {
			$sanitary_values['start_message'] = esc_textarea( $input['start_message'] );
		}

		if ( isset( $input['phone_message'] ) ) {
			$sanitary_values['phone_message'] = esc_textarea( $input['phone_message'] );
		}

		if ( isset( $input['active'] ) ) {
			$sanitary_values['active'] = $input['active'];
		}
		if ( isset( $input['postion'] ) ) {
			$sanitary_values['postion'] = $input['postion'];
		}

		return $sanitary_values;
	}

	public function newcallcenter_settings_section_info() {
		
	}

	public function postion_callback() {
		?> <select name="newcallcenter_settings_option_name[postion]" id="postion">
			<?php $selected = (isset( $this->newcallcenter_settings_options['postion'] ) && $this->newcallcenter_settings_options['postion'] === 'left') ? 'selected' : '' ; ?>
			<option value="left" <?php echo $selected; ?>>Left</option>
			<?php $selected = (isset( $this->newcallcenter_settings_options['postion'] ) && $this->newcallcenter_settings_options['postion'] === 'right') ? 'selected' : '' ; ?>
			<option value="right" <?php echo $selected; ?>>Right</option>
		</select> <?php
	}

	public function url_server_callback() {
		printf(
			'<input class="regular-text" type="text" name="newcallcenter_settings_option_name[url_server]" id="url_server" value="%s">',
			isset( $this->newcallcenter_settings_options['url_server'] ) ? esc_attr( $this->newcallcenter_settings_options['url_server']) : ''
		);
	}

	public function username_callback() {
		printf(
			'<input class="regular-text" type="text" name="newcallcenter_settings_option_name[username]" id="username" value="%s">',
			isset( $this->newcallcenter_settings_options['username'] ) ? esc_attr( $this->newcallcenter_settings_options['username']) : ''
		);
	}

	public function password_callback() {
		printf(
			'<input class="regular-text" type="text" name="newcallcenter_settings_option_name[password]" id="password" value="%s">',
			isset( $this->newcallcenter_settings_options['password'] ) ? esc_attr( $this->newcallcenter_settings_options['password']) : ''
		);
	}

	public function idcampana_callback() {
		printf(
			'<input class="regular-text" type="text" name="newcallcenter_settings_option_name[idcampana]" id="idcampana" value="%s">',
			isset( $this->newcallcenter_settings_options['idcampana'] ) ? esc_attr( $this->newcallcenter_settings_options['idcampana']) : ''
		);
	}
	
	public function requestion_phone_message_callback() {
		printf(
			'<input class="regular-text" type="text" name="newcallcenter_settings_option_name[requestion_phone_message]" id="requestion_phone_message" value="%s">',
			isset( $this->newcallcenter_settings_options['requestion_phone_message'] ) ? esc_attr( $this->newcallcenter_settings_options['requestion_phone_message']) : ''
		);
	}

	public function start_message_callback() {
		printf(
			'<input class="regular-text" type="text" name="newcallcenter_settings_option_name[start_message]" id="requestion_phone_message" value="%s">',
			isset( $this->newcallcenter_settings_options['start_message'] ) ? esc_attr( $this->newcallcenter_settings_options['start_message']) : ''
		);
	}

	public function goodby_message_callback() {
		printf(
			'<textarea class="large-text" rows="5" name="newcallcenter_settings_option_name[goodby_message]" id="goodby_message">%s</textarea>',
			isset( $this->newcallcenter_settings_options['goodby_message'] ) ? esc_attr( $this->newcallcenter_settings_options['goodby_message']) : ''
		);
	}	

	public function active_callback() {
		printf(
			'<input type="checkbox" name="newcallcenter_settings_option_name[active]" id="active" value="active" %s>',
			( isset( $this->newcallcenter_settings_options['active'] ) && $this->newcallcenter_settings_options['active'] === 'active' ) ? 'checked' : ''
		);
	}

}