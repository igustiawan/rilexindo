<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_leasing extends CI_Model {
    var $table = '(select Kd_Cust,Nm_Cust,Alamat1,Status from tb_customer where flag = "F") A'; //nama tabel dari database
    var $column_order = array(null, 'Kd_Cust','Nm_Cust','Alamat1','Status'); //field yang ada di table user
    var $column_search = array('Kd_Cust','Nm_Cust','Alamat1','Status'); //field yang diizin untuk pencarian 
    var $order = array('Kd_Cust' => 'asc'); // default order 
 
    private function _get_datatables_query_leasing()
    {
         
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_leasing()
    {
        $this->_get_datatables_query_leasing();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_leasing();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function ambilDataLeasing(){     
        $this->db->where('flag', 'F');   
        $query = $this->db->get('tb_customer');
        if($query->num_rows()>0)
        {
        return $query->result();
        }
        else
        {
        return false;
        }
    }

    public function getActiveLeasing()
	{
		$sql = "SELECT * FROM tb_customer WHERE Flag = ?";
		$query = $this->db->query($sql, array('F'));
		return $query->result_array();
    }

    function idLeasing(){
		$q = $this->db->query("select MAX(RIGHT(Kd_Cust,5)) as kd_max from tb_customer where flag = 'F'");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%05s", $tmp);
            }
        }else{
            $kd = "00001";
        }
        return "F".$kd;
    }

    function simpanDataLeasing(){

        $kd = $this->idLeasing();
 		$Nm_Cust = $this->input->post('txt_nm_cust');
        $Alamat1 = $this->input->post('txt_alamat1');
        $Alamat2 = $this->input->post('txt_alamat2');
        $Kota = $this->input->post('txt_kota');
        $Kd_Pos = $this->input->post('txt_kdpos');
        $Telepon = $this->input->post('txt_telepon');

        $data = array(
			'Kd_Cust'=> $kd,
            'Nm_Cust' => $Nm_Cust,
            'Alamat1' => $Alamat1,
            'Alamat2' => $Alamat2,
            'Kota' => $Kota,
            'Kd_Pos' => $Kd_Pos,
            'Telepon' => $Telepon,
            'Flag' => "F",
			'status' => "A",
			);

        $this->db->insert('tb_customer', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }
        else {
            return false;
        }
    }

    function ambilDataLeasingbyID($id){
        $this->db->where('Kd_Cust', $id);
        $query = $this->db->get('tb_customer');
        if($query->num_rows()>0)
        {
          return $query->row();
        }
        else
        {
          return false;
        }
     }

     function updateDataLeasing(){
        $Kd_Cust = $this->input->post('txt_kd_cust');
        $Nm_Cust = $this->input->post('txt_nm_cust');
        $Alamat1 = $this->input->post('txt_alamat1');
        $Alamat2 = $this->input->post('txt_alamat2');
        $Kota = $this->input->post('txt_kota');
        $Kd_Pos = $this->input->post('txt_kdpos');
        $Telepon = $this->input->post('txt_telepon');
        $Status = $this->input->post('txt_status');

        $data = array(
            'Kd_Cust' => $Kd_Cust,            
            'Nm_Cust' => $Nm_Cust,
            'Alamat1' => $Alamat1,
            'Alamat2' => $Alamat2,
            'Kota' => $Kota,
            'Kd_Pos' => $Kd_Pos,
            'Telepon' => $Telepon,
            'Status' => $Status
            );

        $this->db->where('Kd_Cust', $Kd_Cust);
        $this->db->update('tb_customer', $data);
        if($this->db->affected_rows() > 0){
        return true;
        }else {
        return false;
        }
    }
}