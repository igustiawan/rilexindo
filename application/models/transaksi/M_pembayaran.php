<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pembayaran extends CI_Model {

	var $table = '(
		select a.No_Transaksi,a.Tgl_Transaksi,b.Nm_Cust,a.Total_Pembayaran,a.Status 
		from
			tb_pembayaran a
		inner join
			tb_customer b
		on a.kd_cust = b.kd_cust
		Where a.Status != "X"
		) A'; 
	var $column_order = array(null, 'No_Transaksi','Tgl_Transaksi','Nm_Cust','Total_Pembayaran','Status'); 
	var $column_search = array('No_Transaksi','Tgl_Transaksi','Nm_Cust','Total_Pembayaran','Status'); //field yang diizin untuk pencarian 
	var $order = array('No_Transaksi' => 'asc'); 

	private function _get_datatables_query_pembayaran()
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

	function get_datatables_pembayaran()
	{
		$this->_get_datatables_query_pembayaran();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query_pembayaran();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

    function insert_pembayaran(
						$No_Transaksi, $Tgl_Transaksi, $Kd_Cust, $No_Bg, $Tgl_Bg, $No_Rek, $Bank_Bg,
						$Bank_Ku, $Tgl_Ku, $Nominal_Tunai, $Nominal_Bg, $Nominal_Ku, $Total_Pembayaran, 
						$Keterangan,$Created_By, $Created_Date,$Status
						)
	{
		$dt = array(
			'No_Transaksi' => $No_Transaksi,
			'Tgl_Transaksi' => $Tgl_Transaksi,
			'Kd_Cust' => $Kd_Cust,		
			'No_Bg' => $No_Bg,
			'Tgl_Bg' => $Tgl_Bg,
			'No_Rek' => $No_Rek,
			'Bank_Bg' => $Bank_Bg,
			'Bank_Ku' => $Bank_Ku,
			'Tgl_Ku' => $Tgl_Ku,
			'Nominal_Tunai' => preg_replace("/[^0-9]/", "", $Nominal_Tunai),
			'Nominal_Bg' => preg_replace("/[^0-9]/", "", $Nominal_Bg),
			'Nominal_Ku' => preg_replace("/[^0-9]/", "", $Nominal_Ku),
			'Total_Pembayaran' => preg_replace("/[^0-9]/", "", $Total_Pembayaran),		
			'Keterangan' => $Keterangan,		
			'Created_By' => $Created_By,
			'Created_Date' => $Created_Date,
			'Status' => $Status

			// 'Tipe_Transaksi' => $Tipe_Transaksi,
			
			// 'Cashback' => $Cashback,
			// 'Denda' => $Denda,
			// 'Tgl_Ambil_Titipan' => $Tgl_Ambil_Titipan,
			// 'Ket_Titipancair' => $Ket_Titipancair,		
			// 'Ket_Cashback' => $Ket_Cashback,
			// 'Diskon' => $Diskon,
			// 'Ket_Diskon' => $Ket_Diskon,
			// 'Cetak' => $Cetak,
			// 'No_Tts' => $No_Tts,
		);

		return $this->db->insert('tb_pembayaran', $dt);
	}

	function insert_pembayaran_detail($No_Transaksi, $No_So, $No_Ref, $Jumlah_Dibayar, $Tgl_Ref, $Tgl_Jtp)
	{
		$dt = array(
			'No_Transaksi' => $No_Transaksi,
			'No_So	' => $No_So,
			'No_Ref' => $No_Ref,
			'Jumlah_Dibayar' => preg_replace("/[^0-9]/", "", $Jumlah_Dibayar),
			'Tgl_Ref' => $Tgl_Ref,
			'Tgl_Jtp' => $Tgl_Jtp
		);
		return $this->db->insert('tb_pembayaran_detail', $dt);
	}

    function get_no_rekening(){ 
        $query = $this->db->query("select No_Rek,Nama_Bank from tb_rekening where Status = 'A'");
        if($query->num_rows()>0)
        {
        return $query->result();
        }
        else
        {
        return false;
        }
    }

	function get_baris($rekening)
	{
		return $this->db
			->select('No_Rek, Nama_Bank')
			->where('No_Rek', $rekening)
			->limit(1)
			->get('tb_rekening');
	}


    function cari_kode($keyword, $registered,$kdcust)
	{
		$not_in = '';

		$koma = explode(',', $registered);
		if(count($koma) > 1)
		{
			$not_in .= " AND a.No_So NOT IN (";
			foreach($koma as $k)
			{
				$not_in .= " '".$k."', ";
			}
			$not_in = rtrim(trim($not_in), ',');
			$not_in = $not_in.")";
		}
		if(count($koma) == 1)
		{
			$not_in .= " AND a.No_So != '".$registered."' ";
		}

        $sql = "
            select 
				a.No_So,
				No_Ref,
				DATE_FORMAT(a.Tgl_So, '%Y-%m-%d') as Tgl_So,
				DATE_FORMAT(Tgl_Jtp, '%Y-%m-%d') as Tgl_Jtp,
				Nilai_Piutang,
				Nilai_Piutang-Jumlah_Bayar as Sisa_Piutang,
				b.Nm_Cust
            from 
				tb_piutang a
			INNER JOIN 
				tb_so b
				on a.No_So = b.No_So	
            where 
                Status_Piutang = 'A'
				AND a.Kd_Cust = '".$kdcust."'
				AND  Nilai_Piutang > Jumlah_Bayar
                AND
                 ( 
					a.No_So LIKE '%".$this->db->escape_like_str($keyword)."%' 
				 ) 
				".$not_in." 
		";

		return $this->db->query($sql);
	}

	function hapus_pembayaran($No_Transaksi)
	{
		$dt = array(
			'Status' => 'Batal'
		);

		return $this->db
			->where('No_Transaksi', $No_Transaksi)
			->update('tb_pembayaran', $dt);
	}

}   