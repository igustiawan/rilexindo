<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 40px;">
    <h1 class="pull-left">
        Input Sales Order
    </h1>
    <div class="pull-right">
        <a href="<?php echo base_url('transaksi/salesorder')?>" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </section>
  <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
        </div>
        <div class="box-body">
            <form action="<?php echo base_url('transaksi/salesorder/simpan')?>" method="post" class="form-horizontal" name="autoSumForm">  
            <div class="form-group ">
                <label for="tipe" class="col-md-2 control-label">No Spk</label>
                <div class="col-md-3">
                    <select class="form-control select2" required name="nospk" id="nospk">
                    <option></option>
                        <?php
                        if($d_list_spk){
                        foreach($d_list_spk as $d){
                            echo "<option value='$d->No_Spk'>$d->No_Spk | $d->Nm_Cust </option>";
                        }
                        }
                    ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-12 ">
                     <button type="button" name="btnView" id="btnView" class="btn bg-maroon btn-flat"><i class="fa fa-check icon-white"></i> view</button>                   
                </div> 
                <label for="dari" class="col-md-1 control-label">Tgl. SO</label>
                <div class="col-md-2 col-sm-12 required">
                    <div class="input-group date">
                        <div class="input-group-addon">
                             <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text"  name="txt_tgl_so" class="form-control pull-right" id="datepicker" data-date-format="dd/mm/yyyy" required>
                    </div>
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
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Salesman</label>
                <div class="col-md-4 col-sm-12 ">
                    <select disabled class="form-control select2"  name="kd_salesman" id="kd_salesman">
                        <option></option>
                        <?php
                        if($d_salesman){
                        foreach($d_salesman as $d){
                            echo "<option value='$d->Kd_Salesman'>$d->Nm_Salesman</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
              </div> 
            <div class="form-group">
                <label for="dari" class="col-md-2 control-label">Jenis Pembayaran</label>
                <div class="col-md-4 col-sm-12 ">
                    <label class="radio-inline">
                        <input type="radio" name="txt_jns_pembayaran"  id="Tunai" value="Tunai">Tunai
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="txt_jns_pembayaran"  id="Kredit" value="Kredit">Kredit
                    </label>                       
                </div>                        
            </div>   
            <div class="form-group">
            <label for="dari" class="col-md-2 control-label">Leasing</label>
                <div class="col-md-4 col-sm-12 ">
                    <select disabled class="form-control select2"  name="kd_leasing" id="kd_leasing">
                            <option></option>
                            <?php
                            if($d_leasing){
                            foreach($d_leasing as $d){
                                echo "<option value='$d->Kd_Cust'>$d->Nm_Cust</option>";
                                }
                            }
                            ?>
                    </select>                      
                </div>
                <label for="dari" class="col-md-2 control-label">No PO Leasing</label>
                <div class="col-md-3 col-sm-12 ">
                <input type="text" readonly name="txt_po_leasing" class="form-control pull-right" id="txt_po_leasing" >                    
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
                                            <th>Nama Mobil</th>
                                            <th>Warna</th> 
                                            <th>Harga Jual</th>    
                                            <th>Diskon</th>                 
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
            <div class="row">
            <div class="col-md-4">           
                <div class="box-header with-border">
                <h3 class="box-title">Pembayaran Awal</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="background-color: #d2d6de">
                    <div class="form-group">
                        <label for="dari" class="col-md-3 control-label">Tunai</label>
                        <div class="col-md-9 col-sm-12 ">
                                <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                                <input readonly type="text" onkeypress="return mask(this,event);"  maxlength="30" class="form-control" id="txt_tunai" name="txt_tunai" > 
                            </div> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dari" class="col-md-3 control-label">DP</label>
                        <div class="col-md-9 col-sm-12 ">
                                <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                                <input readonly type="text" value = 0 onkeyup="change_harga()" onchange="PemisahTitik(this)" onkeypress="return mask(this,event);"   class="form-control" id="txt_dp_murni" name="txt_dp_murni"  >                          
                            </div> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dari" class="col-md-3 control-label">Adm</label>
                        <div class="col-md-9 col-sm-12 ">
                                <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            <input readonly type="text" value = 0 onkeyup="change_harga()" onchange="PemisahTitik(this)"  onkeypress="return mask(this,event);"  maxlength="9" class="form-control" id="txt_adm" name="txt_adm" > 
                            </div> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dari" class="col-md-3 control-label">Angs 1</label>
                        <div class="col-md-9 col-sm-12 ">
                                <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            <input readonly type="text"  maxlength="30"   class="form-control" id="txt_angsuran_1"  name="txt_angsuran_1" > 
                            </div> 
                        </div>
                    </div>                   
                    <div class="form-group">
                        <label for="dari" class="col-md-3 control-label">Total</label>
                        <div class="col-md-9 col-sm-12 ">
                                <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            <input readonly type="text"  maxlength="30" class="form-control" id="txt_total" name="txt_total" > 
                            <!-- <input type="hidden" class="form-control" id="txt_total_pembayaran_temp" name="txt_total_pembayaran_temp"  > -->
                            </div> 
                        </div>
                    </div>
                 </div>
            </div>
            <!-- ./col -->
            <div class="col-md-8">
                <div class="box-header with-border">
                <h3 class="box-title">Data Kredit</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body clearfix" style="background-color: #d2d6de">
                    <div class="form-group">
                        <label for="dari" class="col-md-2 control-label">Harga Mobil</label>
                        <div class="col-md-4 col-sm-12 ">
                                <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                                 <input readonly type="text" onkeypress="return mask(this,event);" maxlength="30" class="form-control" id="txt_hrg_mobil" name="txt_hrg_mobil" > 
                            </div> 
                        </div>
                        <label for="dari" class="col-md-2 control-label">Jumlah Kredit</label>
                        <div class="col-md-4 col-sm-12 ">
                                <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                                <input readonly type="text"  maxlength="30" class="form-control" id="txt_jml_kredit" name="txt_jml_kredit" > 
                            </div> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dari" class="col-md-2 control-label">Total DP</label>
                        <div class="col-md-4 col-sm-12 ">
                                <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                                <input readonly type="text"  maxlength="30"  class="form-control" id="txt_total_dp" name="txt_total_dp" > 
                                <!-- <input type="hidden" class="form-control" id="txt_total_dp_temp" name="txt_total_dp_temp"  >  -->
                            </div> 
                        </div>
                        <label for="dari" class="col-md-2 control-label">Lama Angs</label>
                        <div class="col-md-2 col-sm-12 ">
                            <input readonly type="text" onkeypress="return mask(this,event);"  maxlength="2" class="form-control" id="txt_lama_angs" name="txt_lama_angs" >                            
                        </div>
                        <label class="radio-inline">
                            <input  type="radio" name="txt_biaya_adm" id="ADDB"  value="B" >ADDB
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="dari" class="col-md-2 control-label">Bunga</label>
                        <div class="col-md-4 col-sm-12 ">
                            <div class="input-group">
                                <input readonly type="text" onchange="PemisahTitik(this)" onkeypress="return mask(this,event);"   maxlength="9" class="form-control" id="txt_bunga" name="txt_bunga" >     
                                <span class="input-group-addon">/bulan</span>
                            </div>                                                  
                        </div>
                        <label for="dari" class="col-md-2 control-label">Jumlah Angs</label>
                        <div class="col-md-2 col-sm-12 ">
                            <input readonly type="text" onkeyup="change_harga()" onchange="PemisahTitik(this)"   onkeypress="return mask(this,event);"   maxlength="9" class="form-control" id="txt_jml_angs" name="txt_jml_angs" >                            
                        </div>   
                        <label class="radio-inline">
                            <input  type="radio" name="txt_biaya_adm" id="ADDM" value="M" >ADDM
                        </label>                 
                     </div>
                     <div class="form-group">
                        <label for="dari" class="col-md-2 control-label">Keterangan</label>
                        <div class="col-md-9 col-sm-12 ">
                             <textarea  readonly maxlength="100" class="form-control" id="txt_keterangan" name="txt_keterangan" ></textarea>
                        </div>
                     </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            </div>
            <div class="box-footer text-right">
                <a class="btn btn-default" href="<?php echo base_url('transaksi/salesorder/tambah')?>"><i class="fa fa-close"></i> Batal</a>
                <button type="submit" name="btnSimpan" class="btn btn-success"><i class="fa fa-check icon-white"></i> Simpan</button>
             </div>
            </form>
        </div>
        </div>
    <!-- /.box -->
    </section>
 </div>
<script> 

function search(){    
	$.ajax({
        type: "POST", 
        url:"<?php echo base_url('transaksi/salesorder/search')?>", // Isi dengan url/path file php yang dituju
        data: {nospk : $("#nospk").val()}, // data yang akan dikirim ke file proses
        dataType: "json",
        beforeSend: function(e) {
            if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
		},  
		success: function(response){ // Ketika proses pengiriman berhasil          
            if(response.status == "success"){ // Jika isi dari array status adalah success
                $("#kd_salesman").attr("disabled", false);   
                $("#btnView").attr("disabled", true);   
                $("#txt_cust").val(response.Nm_Cust); 
				$("#txt_kd_cust").val(response.Kd_Cust); 
                $("#txt_alamat").val(response.Alamat);
                $("#txt_bunga").val(0);       
                $('input:radio[name=txt_jns_pembayaran][value='+response.Jns_Bayar+']')[0].checked = true; 

                if(response.Jns_Bayar =="Tunai"){
                    //tipe jenis bayar tunai
                    UnlockTunai();                                                        
                    $("#txt_alamat").val(response.Alamat);  
                    $("#txt_tunai").val(response.Jml_Harga); 
                    $("#txt_total").val(response.Jml_Harga);      
                }else{   
                    UnlockKredit();
                    //tipe angsuran dibayar dimuka (ADDM)
                    if(response.Tipe_Angs =="M"){
                        $("#txt_angsuran_1").val(response.Angsuran);  
                        $("#txt_jml_angs").val(response.Angsuran);
                        $("#txt_total_dp").val(response.Angsuran);
                        $("#txt_total_dp_temp").val(response.Angsuran);
                        $("#txt_total").val(response.Angsuran);      
                        $("#txt_total_pembayaran_temp").val(response.Angsuran);                           
                    } 
                    //tipe angsuran dibayar dibelakang (ADDB)
                    else if(response.Tipe_Angs =="B"){ 
                        // $("#txt_jml_angs").attr("readonly", true);
                        $("#txt_angsuran_1").val(0);
                        $("#txt_jml_angs").val(0);  
                        $("#txt_total_dp").val(0);
                        $("#txt_total_dp_temp").val(0);
                        $("#txt_total").val(0);      
                        $("#txt_total_pembayaran_temp").val(0);  
                    }  
                    $("#txt_hrg_mobil").val(response.Jml_Harga);
                    $("#txt_lama_angs").val(response.Tenor);
                    $('input:radio[name=txt_biaya_adm][value='+response.Tipe_Angs+']')[0].checked = true;                  
                    $("#kd_leasing").attr("disabled", false);
                    $("#txt_po_leasing").attr("readonly", false);                      
                } 
                //menampilkan ke table
                table ='<tr>';
                table +='<td><input style="border:none" name="txt_nomesin" readonly type="text" value='+response.No_Mesin+'></td>';
                table +='<td><input style="border:none" readonly type="text" value='+response.Tipe+'></td>';
                table +='<td><input style="border:none" readonly type="text" value='+response.Warna+'></td>';
                table +='<td><input style="border:none" readonly type="text" value='+response.Jml_Harga+'></td>';
                table +='<td><input id="txt_diskon" name="txt_diskon" value=0 type="text" onkeyup="change_harga()" onchange="PemisahTitik(this)" onkeypress="return mask(this,event);" maxlength="9" class="form-control" ></td>';
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

//ketika jenis pembayaran tunai    
function UnlockTunai(){    
    $("#txt_adm").attr("readonly", false);  
    $("#txt_dp_murni").attr("readonly", true);
    $("#txt_lama_angs").attr("readonly", true);
    $("#txt_bunga").attr("readonly", true);
    $("#txt_jml_angs").attr("readonly", true);    
    $("#ADDB").attr("disabled", true);
    $("#ADDM").attr("disabled", true);
    $("#txt_keterangan").attr("readonly", true);   
    $("#txt_adm").attr("readonly", true);  
}

//ketika jenis pembayaran kredit
function UnlockKredit(){   
    $("#txt_adm").attr("readonly", true);
    $("#txt_dp_murni").attr("readonly", false);
    $("#txt_lama_angs").attr("readonly", false);
    $("#txt_bunga").attr("readonly", false);
    $("#txt_jml_angs").attr("readonly", false);    
    $("#ADDB").attr("disabled", false);
    $("#ADDM").attr("disabled", false);
    $("#txt_keterangan").attr("readonly", false);   
    $("#txt_adm").attr("readonly", false);  
}

//event change perhitungan total dp kredit dan total pembayaran
function change_harga(){
    var dp_murni = $("#txt_dp_murni").val()==''?0:$("#txt_dp_murni").val();  
    var adm = $("#txt_adm").val()==''?0:$("#txt_adm").val(); 
    var jumlah_angsuran = $("#txt_jml_angs").val()==''?0:$("#txt_jml_angs").val();    
    var diskon = $("#txt_diskon").val()==''?0:$("#txt_diskon").val();
    var harga_sebelum_diskon = $("#txt_hrg_mobil").val()==''?0:$("#txt_hrg_mobil").val();
    var jenis_angsuran = $("input[name='txt_biaya_adm']:checked"). val();
   
    if (jenis_angsuran=="B"){
        var total_dp_kredit = parseInt(convertToAngka(dp_murni) + convertToAngka(adm) + convertToAngka(diskon) );
        var total_pembayaran_awal = parseInt(convertToAngka(dp_murni) + convertToAngka(adm) );
        var plafon_kredit = parseInt(convertToAngka(harga_sebelum_diskon)- convertToAngka(diskon) - convertToAngka(dp_murni) - convertToAngka(adm));
    }else if (jenis_angsuran=="M"){        
        var total_dp_kredit = parseInt(convertToAngka(jumlah_angsuran)+ convertToAngka(dp_murni) + convertToAngka(adm) + convertToAngka(diskon) );
        var total_pembayaran_awal = parseInt(convertToAngka(jumlah_angsuran)+ convertToAngka(dp_murni) + convertToAngka(adm) );
        var plafon_kredit = parseInt(convertToAngka(harga_sebelum_diskon)- convertToAngka(diskon) - convertToAngka(jumlah_angsuran) - convertToAngka(dp_murni) - convertToAngka(adm)); 
        var ubah_angsuran = convertToAngka(jumlah_angsuran);
        $("#txt_angsuran_1").val(convertToRupiah(ubah_angsuran));   
    }
            
    $("#txt_total_dp").val(convertToRupiah(total_dp_kredit));  
    $("#txt_total").val(convertToRupiah(total_pembayaran_awal));
    $("#txt_jml_kredit").val(convertToRupiah(plafon_kredit));    
  }

  $(document).ready(function(){

    // Ketika user mengklik tombol View
    $("#btnView").click(function(){ 
        search(); // Panggil function search        
    });  
    
    //event change biaya adm
    $('input:radio[name="txt_biaya_adm"]').change(function() {        
        if ($(this).val() == 'B'){
            $("#txt_jml_angs").val(0);
            $("#txt_angsuran_1").val(0);
        }
        if ($(this).val() == 'M'){
        }
        change_harga();
         });
    });

</script>
