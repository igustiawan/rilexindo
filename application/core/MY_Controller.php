<?php
class MY_Controller extends CI_Controller
{
	function __construct()
	{
        parent::__construct();
        $this->_cek_login();
	}
    
    function _cek_login()
	{
		if (!isset($this->session->userdata['id_user'])) {
	    redirect(base_url("login"));
	  }
    }

	function input_error()
	{
		$json['status'] = 0;
		$json['pesan'] 	= "<div class='alert alert-warning error_validasi'>".validation_errors()."</div>";
		echo json_encode($json);
	}

	function query_error($pesan = "Terjadi kesalahan, coba lagi !")
	{
		$json['status'] = 2;
		$json['pesan'] 	= "<div class='alert alert-danger error_validasi'>".$pesan."</div>";
		echo json_encode($json);
    }	
    
    function clean_tag_input($str)
	{
		$t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
		$t = htmlentities($t, ENT_QUOTES, "UTF-8");
		$t = trim($t);
		return $t;
    }
    
}