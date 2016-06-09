<?php 
class Form_custom_validation extends CI_Form_validation {

	public function __construct($rules = array()) {
	    $this->CI =& get_instance();
		// Validation rules can be stored in a config file.
		$this->_config_rules = $rules;

		// Automatically load the form helper
		$this->CI->load->helper('form');

		// Set the character encoding in MB.
		if (function_exists('mb_internal_encoding'))
		{
			mb_internal_encoding($this->CI->config->item('charset'));
		}

		log_message('debug', "Form Validation Class Initialized");
	}

	public function is_exists($value) {
	    if( $value == 'asd1' ):
			$this->form_validation->set_message('is_exists', 'The %s is not found in our records.');
			return false;
		else:
			return true;
		endif;
		echo 'asdasd';
	}
}