<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 40px;">
    <h1 class="pull-left">
      Input Surat Jalan
    </h1>
    <div class="pull-right">
    <a href="<?php echo base_url('transaksi/suratjalan')?>" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </section>

  <section class="content">
        <!-- Default box -->
        <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
             <form action="<?php echo base_url('transaksi/suratjalan/simpan')?>" method="post" class="form-horizontal">  
                <div class="form-group ">
                    <label for="tipe" class="col-md-2 control-label">No So</label>
                    <div class="col-md-3">
                        <select class="form-control select2" required name="noso" id="noso">
                        <option></option>
                            <?php
                            if($d_list_so){
                            foreach($d_list_so as $d){
                                echo "<option value='$d->No_So'>$d->No_So</option>";
                            }
                            }
                        ?>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-12 ">
                        <button type="button" name="btnView" id="btnView" class="btn bg-maroon btn-flat"><i class="fa fa-check icon-white"></i> view</button>                   
                    </div> 
                </div>
                <div class="form-group ">                           
                    <label for="dari" class="col-md-2 control-label">Tanggal SJ</label>
                    <div class="col-md-2 col-sm-12 required">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text"  name="txt_tgl_sj" class="form-control pull-right" id="datepicker" data-date-format="dd/mm/yyyy" required>
                        </div>
                    </div>                          
                </div>
                <div class="form-group ">                           
                    <label for="dari" class="col-md-2 control-label">No So.</label>
                    <div class="col-md-4 col-sm-12 ">                            
                            <input readonly type="text" maxlength="30" class="form-control" id = "txt_no_so" name="txt_no_so" >        
                    </div>
                    <label for="dari" class="col-md-2 control-label">Tanggal SO</label>
                    <div class="col-md-2 col-sm-12 required">                         
                            <input readonly type="text" id="txt_tgl_so" name="txt_tgl_so" class="form-control pull-right" required>
                    </div>                                                    
                </div>
                <div class="form-group ">                           
                    <label for="dari" class="col-md-2 control-label">Nama Customer</label>
                    <div class="col-md-4 col-sm-12 ">                            
                            <input readonly type="text" maxlength="30" class="form-control" id = "txt_cust" name="txt_cust" >        
                    </div>
                    <div class="col-md-3 col-sm-12 ">
                        <input type="hidden" readonly name="txt_kd_cust" class="form-control pull-right" id="txt_kd_cust" >                    
                     </div>                            
                </div> 
                <div class="form-group ">
                    <label for="dari" class="col-md-2 control-label">Alamat Lengkap</label>
                    <div class="col-md-7 col-sm-12 ">
                    <textarea  readonly maxlength="100" class="form-control" id="txt_alamat" name="txt_alamat" ></textarea>
                    </div>
                </div>   
                <div class="row">                
                <div class="col-md-12">     
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Kendaraan</h3>
                        </div>
                        <div class="box-body"> 
                                <table id="detailso" class="table table-bordered" style="width:100%; margin-bottom: 10px;"> 
                                    <thead>
                                        <tr>
                                            <th>No Mesin</th>
                                            <th>No Rangka</th>
                                            <th>Nama Mobil</th>
                                            <th>Warna</th>                
                                        </tr>
                                    </thead>
                                    <tbody id="show_data">                 
                                    </tbody>
                                    <tfoot>
                                    </tfoot>                
                                </table>
                        </div>
                        </div>
                    </div>
                </div>   
                <div class="box-footer text-right">
                    <a class="btn btn-default" href="<?php echo base_url('transaksi/suratjalan/tambah')?>"><i class="fa fa-close"></i> Batal</a>
                    <button type="submit" name="btnSimpan" class="btn btn-success"><i class="fa fa-check icon-white"></i> Simpan</button>
                 </div>
             </form>
        </div>
        </div>
    <!-- /.box -->
    </section>
 </div>
 <script> 
    
    $(document).ready(function(){	
        $("#btnView").click(function(){ // Ketika user mengklik tombol View
            search(); // Panggil function search        
        });  
    });

function search(){ 
	$.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url:"<?php echo base_url('transaksi/suratjalan/search')?>", // Isi dengan url/path file php yang dituju
        data: {noso : $("#noso").val()}, // data yang akan dikirim ke file proses
        dataType: "json",
        beforeSend: function(e) {
            if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
		},  

		success: function(response){ // Ketika proses pengiriman berhasil          
            if(response.status == "success"){ // Jika isi dari array status adalah success
               
                $("#txt_cust").val(response.Nm_Cust); 
                $("#txt_no_so").val(response.No_So); 
                $("#txt_alamat").val(response.Alamat);
                $("#txt_tgl_so").val(response.Tgl_So);

                table ='<tr>';
                table +='<td><input style="border:none" name="txt_nomesin" readonly type="text" value='+response.No_Mesin+'></td>';
                table +='<td><input style="border:none" name="txt_norangka" readonly type="text" value='+response.No_Chassis+'></td>';
                table +='<td><input style="border:none" name="txt_tipe" readonly type="text" value='+response.Tipe+'></td>';
                table +='<td><input style="border:none" name="txt_warna"  readonly type="text" value='+response.Warna+'></td>';
                table +='</tr>';
                  
                $("#show_data").html(table);		    
                
			}else{ // Jika isi dari array status adalah failed
				alert("Data Tidak Ditemukan");
			}
		},
        error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
			alert(xhr.responseText);
         }
    });
}

</script>
