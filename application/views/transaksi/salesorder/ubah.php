<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 40px;">
    <h1 class="pull-left">
        Ubah Sales Order
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
            <!-- <form action="<?php //echo base_url('transaksi/salesorder/simpan')?>" method="post" class="form-horizontal" name="autoSumForm">   -->
            <div class="form-horizontal">
            <div class="form-group ">
                <label for="tipe" class="col-md-2 control-label">No Spk</label>
                <div class="col-md-3">
                    <input readonly type="text" maxlength="30" value="<?php echo $so_data['tb_so']['No_Spk'] ?>" class="form-control" id = "txt_nospk" name="txt_nospk" >                    
                </div> 
                <label for="dari" class="col-md-1 control-label">Tgl. SO</label>
                <div class="col-md-2 col-sm-12 required">
                    <div class="input-group date">
                        <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" readonly name="txt_tgl_so" class="form-control pull-right" value="<?php echo $so_data['tb_so']['Tgl_So'] ?>"  data-date-format="dd/mm/yyyy" required>
                    </div>
                </div>
            </div> 
            <div class="form-group ">                           
                <label for="dari" class="col-md-2 control-label">Nama Customer</label>
                <div class="col-md-4 col-sm-12 ">                            
                        <input readonly type="text" maxlength="30"  value="<?php echo $so_data['tb_so']['Nm_Cust'] ?>"  class="form-control" id = "txt_cust" name="txt_cust" >        
                </div>                           
             </div>  
             <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Alamat Lengkap</label>
                <div class="col-md-7 col-sm-12 ">
                    <textarea  readonly maxlength="100" class="form-control" id="txt_alamat" name="txt_alamat" ><?php echo $so_data['tb_so']['Alamat'] ?></textarea>
                </div>
            </div>  
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Salesman</label>
                <div class="col-md-4 col-sm-12 ">
                        <input readonly type="text" maxlength="30" value="<?php echo $so_data['tb_so']['Nm_Salesman'] ?>" class="form-control"  >
                </div>
              </div> 
            <div class="form-group">
                <label for="dari" class="col-md-2 control-label">Jenis Pembayaran</label>
                <div class="col-md-4 col-sm-12 ">
                    <label  class="radio-inline"><input type="radio"  disabled name="txt_jns_pembayaran" id="tunai" value="Tunai" <?php echo($so_data['tb_so']['Jns_Bayar']=="Tunai"?'checked="checked"':''); ?> >Tunai</label>
                    <label  class="radio-inline"><input type="radio"  disabled name="txt_jns_pembayaran" id="kredit" value="Kredit" <?php echo($so_data['tb_so']['Jns_Bayar']=="Kredit"?'checked="checked"':''); ?>>Kredit</label>   
                </div>                        
            </div>   
            <div class="form-group">
            <label for="dari" class="col-md-2 control-label">Leasing</label>
                <div class="col-md-4 col-sm-12 ">
                    <input readonly type="text" maxlength="30" value="<?php echo $so_data['tb_so']['Nm_Fincoy'] ?>" class="form-control" >                    
                </div>
                <label for="dari" class="col-md-2 control-label">No PO Leasing</label>
                <div class="col-md-3 col-sm-12 ">
                    <input type="text" readonly name="txt_po_leasing" value="<?php echo $so_data['tb_so']['No_Po_Leasing'] ?>" class="form-control pull-right" id="txt_po_leasing" >                    
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
                                <tbody>  
                                    <tr>
                                        <td><input style="border:none" value="<?php echo $so_data['tb_so']['No_Mesin'] ?>" name="txt_nomesin"  id="txt_nomesin" readonly type="text"></td>
                                        <td><input style="border:none" value="<?php echo $so_data['tb_so']['Tipe'] ?>" readonly type="text"></td>
                                        <td><input style="border:none" value="<?php echo $so_data['tb_so']['Warna'] ?>" readonly type="text"></td>
                                        <td><input style="border:none" value="<?php echo $so_data['tb_so']['Hrg_Jual'] ?>" readonly type="text"></td>
                                        <td><input id="txt_diskon" name="txt_diskon" value="<?php echo $so_data['tb_so']['Diskon'] ?>" type="text" onkeyup="change_harga()" onchange="PemisahTitik(this)" onkeypress="return mask(this,event);" maxlength="9" class="form-control" ></td>
                                    </tr>              
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
                                <input readonly type="text" onkeypress="return mask(this,event);" value="<?php echo $so_data['tb_so']['By_Tunai'] ?>" maxlength="30" class="form-control" id="txt_tunai" name="txt_tunai" > 
                            </div> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dari" class="col-md-3 control-label">DP</label>
                        <div class="col-md-9 col-sm-12 ">
                                <div class="input-group">
                            <span class="input-group-addon">Rp</span> 
                                <input readonly type="text" value="<?php echo number_format($so_data['tb_so']['DP'],0,',','.') ?>" onkeyup="change_harga()" onchange="PemisahTitik(this)" onkeypress="return mask(this,event);"   class="form-control" id="txt_dp_murni" name="txt_dp_murni"  >                          
                            </div> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dari" class="col-md-3 control-label">Adm</label>
                        <div class="col-md-9 col-sm-12 ">
                                <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            <input readonly type="text" value="<?php echo number_format($so_data['tb_so']['ADM'],0,',','.') ?>" onkeyup="change_harga()" onchange="PemisahTitik(this)"  onkeypress="return mask(this,event);"  maxlength="9" class="form-control" id="txt_adm" name="txt_adm" > 
                            </div> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dari" class="col-md-3 control-label">Angs 1</label>
                        <div class="col-md-9 col-sm-12 ">
                                <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                                <input readonly type="text"  maxlength="30" value="<?php echo number_format($so_data['tb_so']['ADDM'],0,',','.') ?>"  class="form-control" id="txt_angsuran_1"  name="txt_angsuran_1" > 
                            </div> 
                        </div>
                    </div>                   
                    <div class="form-group">
                        <label for="dari" class="col-md-3 control-label">Total</label>
                        <div class="col-md-9 col-sm-12 ">
                                <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            <input readonly type="text"  maxlength="30" class="form-control" id="txt_total" name="txt_total" > 
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
                                 <input readonly value="<?php echo number_format($so_data['tb_so']['Ttl_Hrg_Otr'],0,',','.') ?>" type="text" onkeypress="return mask(this,event);" maxlength="30" class="form-control" id="txt_hrg_mobil" name="txt_hrg_mobil" > 
                            </div> 
                        </div>
                        <label for="dari" class="col-md-2 control-label">Jumlah Kredit</label>
                        <div class="col-md-4 col-sm-12 ">
                                <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                                <input readonly  type="text"  maxlength="30" class="form-control" id="txt_jml_kredit" name="txt_jml_kredit" > 
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
                            <input readonly type="text" value="<?php echo $so_data['tb_so']['Tenor'] ?>" onkeypress="return mask(this,event);"  maxlength="2" class="form-control" id="txt_lama_angs" name="txt_lama_angs" >                            
                        </div>
                        <label class="radio-inline">
                            <input type="radio" value="B" id="ADDB" <?php echo($so_data['tb_so']['Tipe_Angs']=="B"?'checked="checked"':''); ?> name="txt_biaya_adm">ADDB
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="dari" class="col-md-2 control-label">Bunga</label>
                        <div class="col-md-4 col-sm-12 ">
                            <div class="input-group">
                                <input readonly type="text" onchange="PemisahTitik(this)" value="<?php echo number_format($so_data['tb_so']['Bunga'],0,',','.') ?>" onkeypress="return mask(this,event);"   maxlength="9" class="form-control" id="txt_bunga" name="txt_bunga" >     
                                <span class="input-group-addon">/bulan</span>
                            </div>                                                  
                        </div>
                        <label for="dari" class="col-md-2 control-label">Jumlah Angs</label>
                        <div class="col-md-2 col-sm-12 ">
                            <input readonly type="text" onkeyup="change_harga()" onchange="PemisahTitik(this)"  value="<?php echo $so_data['tb_so']['Angsuran'] ?>"  onkeypress="return mask(this,event);"   maxlength="9" class="form-control" id="txt_jml_angs" name="txt_jml_angs" >                            
                        </div>   
                        <label class="radio-inline">
                            <input type="radio" value="M" id="ADDB" <?php echo($so_data['tb_so']['Tipe_Angs']=="M"?'checked="checked"':''); ?> name="txt_biaya_adm">ADDM
                        </label>                 
                     </div>
                     <div class="form-group">
                        <label for="dari" class="col-md-2 control-label">Keterangan</label>
                        <div class="col-md-9 col-sm-12 ">
                             <textarea  readonly maxlength="100" value="<?php echo $so_data['tb_so']['Keterangan'] ?>" class="form-control" id="txt_keterangan" name="txt_keterangan" ></textarea>
                        </div>
                     </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            </div>
            <div class="box-footer text-right">
                <input type="hidden" name="txt_no_so" value="<?php echo $so_data['tb_so']['No_So'] ?>" class="form-control pull-right" id="txt_no_so" > 
                <button type="submit" id='Simpann' name="btnSimpan" class="btn btn-success"><i class="fa fa-check icon-white"></i> Simpan</button>
             </div>
             </div>
            <!-- </form> -->
        </div>
        </div>
    <!-- /.box -->
    </section>
 </div>
 <script>
    
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
     
    function convertToAngka(rupiah)
    {
        return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
    }
    
    function convertToRupiah(angka)
    {
        var rupiah = '';		
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return rupiah.split('',rupiah.length-1).reverse().join('');
    }

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
 
    var i = $("input[type=radio][name=txt_jns_pembayaran]:checked").val();
    if(i=="Kredit"){
        UnlockKredit();
        change_harga();
    } 
  
    if(i=="Tunai"){
       UnlockTunai();
       change_harga();      
    } 

    $(document).on('click', 'button#Simpann', function(){
        updateso();
    });

    function updateso()
    {
        var FormData = "txt_nospk="+encodeURI($('#txt_nospk').val());
        FormData += "&txt_no_so="+$('#txt_no_so').val();    
        FormData += "&txt_bunga="+$('#txt_bunga').val();
        FormData += "&txt_bunga="+$('#txt_bunga').val();
        FormData += "&txt_tunai="+$('#txt_tunai').val();    
        FormData += "&txt_hrg_mobil="+$('#txt_hrg_mobil').val(); 
        FormData += "&txt_dp_murni="+$('#txt_dp_murni').val();   
        FormData += "&txt_adm="+$('#txt_adm').val();  
        FormData += "&txt_angsuran_1="+$('#txt_angsuran_1').val();  
        FormData += "&txt_lama_angs="+$('#txt_lama_angs').val();
        FormData += "&txt_jml_angs="+$('#txt_jml_angs').val();      
        FormData += "&txt_biaya_adm="+ $('input:radio[name=txt_biaya_adm]:checked').val();         
        FormData += "&txt_keterangan="+$('#txt_keterangan').val();  
        FormData += "&txt_nomesin="+$('#txt_nomesin').val(); 
        FormData += "&txt_diskon="+$('#txt_diskon').val();                
  
        $.ajax({
            url: "<?php echo base_url('transaksi/salesorder/ubah'); ?>",
            type: "POST",
            cache: false,
            data: FormData,
            dataType:'json',
            success: function(data){
                if(data.status == 1)
                {
                    alert(data.pesan);
                    window.location.href="<?php echo site_url('transaksi/salesorder'); ?>";
                }
                else 
                {
                    $('.modal-dialog').removeClass('modal-lg');
                    $('.modal-dialog').addClass('modal-sm');
                    $('#ModalHeader').html('Oops !');
                    $('#ModalContent').html(data.pesan);
                    $('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
                    $('#ModalGue').modal('show');
                }	
            }
        });
     }
</script>