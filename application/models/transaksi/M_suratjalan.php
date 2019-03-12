<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_suratjalan extends CI_Model {

    var $table = '(
                    select a.No_Sj,a.Tgl_Sj,a.No_So,a.Nm_Cust,a.Status from tb_sj a
                    inner join tb_sj_detail b on a.no_sj = b.fk_sj
				   ) A'; 
    var $column_order = array(null,'No_Sj','Tgl_Sj','No_So','Nm_Cust','Status'); 
    var $column_search = array('No_Sj','Tgl_Sj','No_So','Nm_Cust','Status'); //field yang diizin untuk pencarian 
    var $order = array('No_So' => 'asc'); 
 
    private function _get_datatables_query_suratjalan()
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
 
    function get_datatables_suratjalan()
    {
        $this->_get_datatables_query_suratjalan();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_suratjalan();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
	}

    function get_list_so(){ 
        $query = $this->db->query("select No_So from tb_so where Status = 'Approved' and Status_Bast = 1 and No_So not in (select No_So from tb_sj where status !='Batal')");
        if($query->num_rows()>0)
        {
        return $query->result();
        }
        else
        {
        return false;
        }
    }

    public function viewByNoSo($NoSo){	
        $this->db->select('a.No_So,Tgl_So,a.Nm_Cust,a.Kd_Cust,a.Alamat,b.No_Mesin,
                          c.No_Chassis,d.Tipe,e.Warna,c.No_Chassis');
        $this->db->where('a.No_So', $NoSo);
        $this->db->join('tb_so_detail b','a.No_So = b.Fk_So');
		$this->db->join('tb_stock c','c.No_Mesin = b.No_Mesin');
        $this->db->join('tb_tipe d','c.Kd_Tipe = d.Kd_Tipe');
        $this->db->join('tb_warna e','e.Kd_Warna = c.Kd_Warna');
		$result = $this->db->get('tb_so a')->row(); 		
		return $result; 
    }

    function idSuratJalan(){
        $date= date("Y-m-d");
        $tahun=substr($date, 0, 4);
        $bulan=substr($date, 5, 2);
		$q = $this->db->query("select MAX(RIGHT(No_Sj,6)) as kd_max from tb_sj where year(tgl_sj) = $tahun ");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return "01SJ".$tahun.$bulan.$kd;
        //urutan 01 itu next kalau ada cabang bisa disetting menjadi 02 dst..
    }

    function simpanDataSuratJalan(){
        $this->db->trans_begin();

        $kd = $this->idSuratJalan();       
        $Tgl_Sj = $this->input->post('txt_tgl_sj');
        $No_So = $this->input->post('txt_no_so');
        $Tgl_So = $this->input->post('txt_tgl_so');
        $Nm_Cust = $this->input->post('txt_cust');
        $Alamat = $this->input->post('txt_alamat');
        $No_Mesin = $this->input->post('txt_nomesin');
        $No_Chassis = $this->input->post('txt_norangka');
        $Tipe = $this->input->post('txt_tipe');
        $Warna = $this->input->post('txt_warna');
        
        $data_header_sj = array(
            'No_Sj'=> $kd,
            'Tgl_Sj'=> $Tgl_Sj,
            'No_So'=> $No_So, 
            'Tgl_So'=> $Tgl_So,
            'Nm_Cust'=> $Nm_Cust,
            'Alamat'=> $Alamat,
            'Status'=> "Proses",
            );
 
        $data_detail_sj = array(
                'Fk_Sj'=> $kd,
                'No_Mesin'=> $No_Mesin,
                'No_Chassis'=> $No_Chassis, 
                'Tipe'=> $Tipe,
                'Warna'=> $Warna
                );


        $this->db->insert('tb_sj', $data_header_sj);
        $this->db->insert('tb_sj_detail', $data_detail_sj);


        if($this->db->affected_rows() > 0){
            $this->db->trans_commit();
            return true;
        }
        else {
            $this->db->trans_rollback();
            return false;
        }
    }

}