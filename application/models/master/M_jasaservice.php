<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_jasaservice extends CI_Model {

    var $table = 'tb_jasaservice'; //nama tabel dari database
    var $column_order = array(null, 'Kd_Service','Deskripsi','Harga','Status'); //field yang ada di table user
    var $column_search = array('Kd_Service','Deskripsi','Harga','Status'); //field yang diizin untuk pencarian 
    var $order = array('Kd_Service' => 'asc'); // default order 
 
    private function _get_datatables_query_jasaservice()
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
 
    function get_datatables_jasaservice()
    {
        $this->_get_datatables_query_jasaservice();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_jasaservice();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

	function ambilDataJasaService(){     
        $query = $this->db->get('tb_jasaservice');
        if($query->num_rows()>0)
        {
        return $query->result();
        }
        else
        {
        return false;
        }
    }

    function idJasaService(){
		$q = $this->db->query("select MAX(RIGHT(Kd_Service,5)) as kd_max from tb_jasaservice");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%05s", $tmp);
            }
        }else{
            $kd = "00001";
        }
        return "JS-".$kd;
    }

    function simpanDataJasaService(){

        $kd = $this->idJasaService();
 		$deskripsi = $this->input->post('txt_deskripsi');
        $harga = $this->input->post('txt_harga');

		$data = array(
			'Kd_Service'=> $kd,
            'Deskripsi' => $deskripsi,
            'Harga' => $harga,
			'status' => "A",
			);

        $this->db->insert('tb_jasaservice', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }
        else {
            return false;
        }
    }

    function ambilDataJasaServicebyID($id){
        $this->db->where('Kd_Service', $id);
        $query = $this->db->get('tb_jasaservice');
        if($query->num_rows()>0)
        {
          return $query->row();
        }
        else
        {
          return false;
        }
     }

     function updateDataJasaService(){
        $Kd_Service = $this->input->post('txt_kd_jasaservice');
        $deskripsi = $this->input->post('txt_deskripsi');
        $harga = $this->input->post('txt_harga');
        $Status = $this->input->post('txt_status');

        $data = array(
            'Kd_Service' => $Kd_Service,
            'Deskripsi' => $deskripsi,
            'Harga' => $harga,
            'Status' => $Status
            );

    $this->db->where('kd_service', $Kd_Service);
    $this->db->update('tb_jasaservice', $data);
    if($this->db->affected_rows() > 0){
    return true;
    }else {
    return false;
    }
}

}