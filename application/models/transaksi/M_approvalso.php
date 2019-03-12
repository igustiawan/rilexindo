<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_approvalso extends CI_Model {
    var $table = '(
				   select a.No_So,a.Tgl_So,a.Nm_Cust,a.Jns_Bayar,a.Status
				   from tb_so a
				   left join tb_so_detail b on a.no_so = b.fk_so
				   left join tb_stock c on b.no_mesin = c.no_mesin
				   left join tb_tipe d on d.kd_tipe = c.kd_tipe
                   left join tb_warna e on e.kd_warna = c.kd_warna
                   where a.status = "Waiting Approval"
                   order by tgl_so desc
				   ) A'; 
    var $column_order = array(null, 'No_So','Tgl_So','Nm_Cust','Jns_Bayar','Status'); 
    var $column_search = array('No_So','Tgl_So','Nm_Cust','Jns_Bayar','Status'); //field yang diizin untuk pencarian 
    var $order = array('No_So' => 'asc'); 
 
     function _insert_detail_piutang($No_So){
		$hsl=$this->db->query(" SELECT  
                                CASE WHEN C.JNS_BAYAR = 'Tunai' THEN C.KD_CUST  
                                WHEN C.JNS_BAYAR = 'Kredit' and C.Flag = 'C' THEN C.KD_CUST 
                                WHEN C.JNS_BAYAR = 'Kredit' and C.Flag = 'F' THEN C.KD_FINCOY 
                                ELSE NULL END AS Kd_Cust, 
                                C.No_So, C.Tgl_So, 
                                CASE
                                    WHEN C.JNS_BAYAR = 'Tunai' THEN 'HARGA KENDARAAN' 
                                    WHEN C.JNS_BAYAR = 'Kredit' and C.Flag = 'C' THEN 'DP' 
                                    WHEN C.JNS_BAYAR = 'Kredit' and C.Flag = 'F' THEN C.No_PO_Leasing 
                                            Else  'NONE'
                                END AS No_Ref, 
                                CASE
                                    WHEN C.JNS_BAYAR = 'Tunai' THEN C.Tgl_SO 
                                    WHEN C.JNS_BAYAR = 'Kredit' and C.Flag = 'C' THEN C.Tgl_SO
                                    WHEN C.JNS_BAYAR = 'Kredit' and C.Flag = 'F' THEN 
                                    DATE_ADD(C.TGL_SO, INTERVAL C.nTOP DAY)	ELSE NULL 
                                END AS Tgl_Jtp,  	 
                                CASE WHEN C.JNS_BAYAR = 'Tunai' THEN C.BY_TUNAI 
                                    WHEN C.JNS_BAYAR = 'Kredit' and C.Flag = 'C' THEN  C.DP  + C.ADM+  C.ADDM  
                                    WHEN C.JNS_BAYAR = 'Kredit' and C.Flag = 'F' THEN C.Ttl_Hrg_OTR - ( C.DP  + C.ADM +  C.ADDM )	  
                                ELSE 0 END AS Nilai_Piutang, 0 as Jumlah_Bayar, null as Tgl_Bayar_Terakhir,
                                'A' as Status_Piutang
                                FROM (
                                        select A.*,  B.Status AS StatCust, B.Flag, B.nTOP
                                        FROM tb_so A inner join tb_customer B on A.KD_CUST=B.KD_CUST 
                                        WHERE A.No_SO = '$No_So' AND ( A.JNS_BAYAR = 'Tunai' OR  A.JNS_BAYAR = 'Kredit' ) 
                                                UNION ALL
                                        select A.*, B.Status, B.Flag, B.nTOP 	 
                                        FROM tb_so A inner join tb_customer B on A.KD_FINCOY =B.KD_CUST 
                                        WHERE A.No_SO = '$No_So'  AND ( A.JNS_BAYAR = 'Tunai' OR  A.JNS_BAYAR = 'Kredit' ) 
                                ) AS C
                                WHERE C.No_SO = '$No_So' AND (  C.JNS_BAYAR = 'Tunai' OR  C.JNS_BAYAR = 'Kredit' ) 
                                ORDER BY No_SO, Tgl_SO");
		return $hsl;
    }

    private function _get_datatables_query_approvalso()
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
 
    function get_datatables_approvalso()
    {
        $this->_get_datatables_query_approvalso();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_approvalso();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    function prosesapprovalso(){
       
        
        $No_Mesin=$this->input->post('txt_no_mesin'); 
        $No_So=$this->input->post('txt_no_so'); 
        $Jns_Bayar=$this->input->post('txt_pembayaran');
        $Kd_Cust=$this->input->post('txt_kd_cust');
        $Tgl_So=$this->input->post('txt_tgl_so');
        $Nilai_Piutang_Tunai=$this->input->post('txt_dp');
        $Diskon=$this->input->post('txt_diskon_disetujui');

        /* update status ditabel so menjadi approved */
        $this->db->query("update tb_so set status='Approved' where No_So = '$No_So'");
         
        /* update diskon ditabel detail so (bisa kemungkinan diganti diskonnya pada saat approve) */
        $this->db->query("update tb_so_detail set Diskon= $Diskon where Fk_So = '$No_So' and No_Mesin='$No_Mesin'");
                
        /* update diskon ditabel stock */
        $this->db->query("update tb_stock set Diskon= $Diskon where No_Mesin = '$No_Mesin'");

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