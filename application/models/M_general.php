<?php
	class M_general extends CI_Model {

	    function generate_id(){
	        $query = $this->db->query("Select md5(UUID()) as ID");
	        return $query->row()->ID;
	    }

	    function insert_data($table, $data){
			// nanti bisa ditambahkan utk insert log/history
			
			$this->db->insert($table, $data);
	    }

	    function multiple_insert_data($table, $data){
			// nanti bisa ditambahkan utk insert log/history

			$this->db->insert_batch($table, $data);
	    }

	    public function generate_custom_id($table, $id, $kode, $digit = 0){
	        $numrow = 1;
         	$date = date('ym');
	        $new_id = '';

	        $this->db->select($id);
	        $this->db->order_by($id,'desc');
	        $query = $this->db->get($table,1);
	        if($query->num_rows() > 0){
	            $id = $query->row()->$id;
	            $year = substr($id,(strlen($kode)+1),2);
	            $month = substr($id,(strlen($kode)+3),2);
	            
	            if(date('m')!= $month){
					$numrow = 1;
	            }else{
					$numrow = (int) substr($id, (strlen($kode)+6) +1);
	            }
	        }

	        if($digit != 0){
	        	if($digit > strlen($numrow)){
	        		for($i = strlen($numrow) ; $i < $digit ; $i++){
	        			$new_id.='0';
	        		}
	        		$new_id .= $numrow;
	        	}else{
	        		$new_id = $numrow;	
	        	}
	        }else{
	        	$new_id = $numrow;
	        }

	        $customid = $kode.'-'.$date.'-'.$new_id;
	        return $customid;
		}
	}
?>