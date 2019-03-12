<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_chain_kendaraan extends CI_Model{
 
    function get_merek(){
        $hasil=$this->db->query("SELECT * FROM tb_merek where status = 'A'");
        return $hasil;
    }
 
    function get_tipe($id){
        $hasil=$this->db->query("SELECT * FROM tb_tipe WHERE Kd_Merek='$id'");
        return $hasil->result();
    }
}