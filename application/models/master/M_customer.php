<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_customer extends CI_Model {

    var $table = '(select Kd_Cust,Nm_Cust,Alamat1,Kecamatan,Kelurahan,KTP,Status,JnsKel from tb_customer where flag = "C")A'; //nama tabel dari database
    var $column_order = array(null, 'Kd_Cust','Nm_Cust','Alamat1','Kecamatan','Kelurahan',
                             'KTP','Status','JnsKel'); //field yang ada di table user
    var $column_search = array('Kd_Cust','Nm_Cust','Alamat1','Kecamatan','Kelurahan',
                             'KTP','Status','JnsKel'); //field yang diizin untuk pencarian 
    var $order = array('Kd_Cust' => 'asc'); // default order 
 
    private function _get_datatables_query_customer()
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
 
    function get_datatables_customer()
    {
        $this->_get_datatables_query_customer();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_customer();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function ambilDataCustomer(){     
        $this->db->where('flag', 'C');   
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

    function idCust(){
		$q = $this->db->query("select MAX(RIGHT(Kd_Cust,6)) as kd_max from tb_customer where flag = 'C'");
        $kd = "";
        $date= date("Y");
        $tahun=substr($date,-2);
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return "CS".$tahun.$kd;
    }

    function simpanDataCustomer(){

        $kd = $this->idCust();
 		$Nm_Cust = $this->input->post('txt_nm_cust');
        $Alamat1 = $this->input->post('txt_alamat1');
        $Alamat2 = $this->input->post('txt_alamat2');
        $Kecamatan = $this->input->post('txt_kecamatan');
        $Kelurahan = $this->input->post('txt_kelurahan');
        $Kota = $this->input->post('txt_kota');
        $Kd_Pos = $this->input->post('txt_kdpos');
        $Telepon = $this->input->post('txt_telepon');
        $Pekerjaan = $this->input->post('txt_pekerjaan');
        $KTP = $this->input->post('txt_ktp');
        $JnsKel = $this->input->post('opt_jnskel');

        $data = array(
			'Kd_Cust'=> $kd,
            'Nm_Cust' => $Nm_Cust,
            'Alamat1' => $Alamat1,
            'Alamat2' => $Alamat2,
            'Kecamatan' => $Kecamatan,
            'Kelurahan' => $Kelurahan,
            'Kota' => $Kota,
            'Kd_Pos' => $Kd_Pos,
            'Telepon' => $Telepon,
            'Pekerjaan' => $Pekerjaan,
            'KTP' => $KTP,
            'JnsKel' => $JnsKel,
            'Flag' => "C",
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

    function ambilDataCustomerbyID($id){
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

     function updateDataCustomer(){
        $Kd_Cust = $this->input->post('txt_kd_cust');
        $Nm_Cust = $this->input->post('txt_nm_cust');
        $Alamat1 = $this->input->post('txt_alamat1');
        $Alamat2 = $this->input->post('txt_alamat2');
        $Kecamatan = $this->input->post('txt_kecamatan');
        $Kelurahan = $this->input->post('txt_kelurahan');
        $Kota = $this->input->post('txt_kota');
        $Kd_Pos = $this->input->post('txt_kdpos');
        $Telepon = $this->input->post('txt_telepon');
        $Pekerjaan = $this->input->post('txt_pekerjaan');
        $KTP = $this->input->post('txt_ktp');
        $JnsKel = $this->input->post('opt_jnskel');
        $Status = $this->input->post('txt_status');

        $data = array(
            'Kd_Cust' => $Kd_Cust,            
            'Nm_Cust' => $Nm_Cust,
            'Alamat1' => $Alamat1,
            'Alamat2' => $Alamat2,
            'Kecamatan' => $Kecamatan,
            'Kelurahan' => $Kelurahan,
            'Kota' => $Kota,
            'Kd_Pos' => $Kd_Pos,
            'Telepon' => $Telepon,
            'Pekerjaan' => $Pekerjaan,
            'KTP' => $KTP,
            'JnsKel' => $JnsKel,
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