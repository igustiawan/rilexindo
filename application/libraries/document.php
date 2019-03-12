<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document {
  	public function __construct(){
		$CI =& get_instance();
	}

	function generate_page($html = '', $data = '' ){
    	$CI =& get_instance();

        if(!isset($CI->session->userdata['id_user'])){
            redirect(base_url("login"));
        }else{
			$CI->load->view('template/header');
			$CI->load->view('template/leftside');
	        $CI->load->view($html, $data);
			$CI->load->view('template/footer_js');
			$CI->load->view('template/footer');
		}
	}
}
