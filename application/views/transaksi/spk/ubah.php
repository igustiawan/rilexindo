<style>
    .pilih_stock:hover{
        cursor: pointer;
    }
    .pilih_cust:hover{
        cursor: pointer;
    }
</style>
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 40px;">
    <h1 class="pull-left">
      Ubah SPK
    </h1>
    <div class="pull-right">
    <a href="<?php echo base_url('transaksi/spk')?>" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </section>

  <section class="content">
        <!-- Default box -->
        <!-- <form action="<?php echo base_url('transaksi/spk/simpan')?>" method="post" class="form-horizontal"> -->
                <div class="form-horizontal">
                <div class="box">
                    <div class="box-header with-border">
                    </div>
                <div class="box-body"> 
                    <div class="row">         
                        <div class="form-group ">                           
                            <label for="dari" class="col-md-2 control-label">Nama Customer</label>
                            <div class="col-md-4 col-sm-12 ">                                                                 
                                <div class="input-group">
                                    <input readonly type="text" maxlength="30" value="<?php echo $spk_data['tb_spk']['Nm_Cust'] ?>" class="form-control" id = "txt_cust" name="txt_cust" >        
                                </div>
                            </div>
                            <!-- <label for="dari" class="col-md-1 control-label">Kd Cust</label> -->
                            <div class="col-md-3 col-sm-12 ">
                                <input type="hidden" readonly name="txt_kd_cust" value="<?php echo $spk_data['tb_spk']['Kd_Cust'] ?>" class="form-control pull-right" id="txt_kd_cust" >                    
                            </div>                            
                        </div>                                                       
                        <div class="form-group ">
                            <label for="dari" class="col-md-2 control-label">Jenis Kelamin</label>
                            <div class="col-md-4 col-sm-12 ">
                                <select class="form-control"  name="opt_jnskel" id="optJnsKel">
                                    <option value="L" <?php if($spk_data['tb_spk']['Jns_Kel'] == "L") { echo "selected='selected'"; } ?>>Laki-Laki</option>
                                    <option value="P" <?php if($spk_data['tb_spk']['Jns_Kel'] != "L") { echo "selected='selected'"; } ?>>Perempuan</option>
                                </select>
                            </div>                             
                            <label for="dari" class="col-md-1 control-label">Tgl SPK</label>
                            <div class="col-md-3 col-sm-12 ">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text"  name="txt_tgl_spk"  value="<?php echo date("Y-m-d", strtotime($spk_data['tb_spk']['Tgl_Spk'])) ?>" class="form-control pull-right" id="datepickeredit" data-date-format="dd/mm/yyyy" >
                                </div>           
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="dari" class="col-md-2 control-label">Alamat Lengkap</label>
                            <div class="col-md-7 col-sm-12 ">
                                <textarea   maxlength="100" class="form-control" id="txt_alamat" name="txt_alamat" ><?php echo $spk_data['tb_spk']['Alamat'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="dari" class="col-md-2 control-label">Salesman</label>
                            <div class="col-md-4 col-sm-12 ">
                                <select class="form-control select2"  name="kd_salesman" id="kd_salesman">
                                    <?php foreach ($tb_salesman as $k => $v): ?>
                                    <option value="<?php echo $v['Kd_Salesman'] ?>" <?php if($spk_data['tb_spk']['Kd_Salesman']  == $v['Kd_Salesman']) { echo "selected='selected'"; } ?> ><?php echo $v['Nm_Salesman'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dari" class="col-md-2 control-label">No Mesin</label>
                            <div class="col-md-4 col-sm-12 ">                                                                 
                                <div class="input-group">
                                    <div class="input-group-btn">
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalStock">Browse</button>
                                    </div>
                                    <input readonly type="text" maxlength="30" value="<?php echo $spk_data['tb_spk']['No_Mesin'] ?>" class="form-control" id = "txt_nomesin" name="txt_nomesin" >        
                                </div>
                            </div>                             
                        </div> 
                        <div class="form-group">
                            <label for="dari" class="col-md-2 control-label">Merek</label>
                            <div class="col-md-3 col-sm-12 ">
                                <input readonly type="text" maxlength="30" class="form-control" value="<?php echo $spk_data['tb_spk']['Merek'] ?>" id="txt_merek" name="txt_merek" >                       
                            </div>
                            <!-- <label for="dari" class="col-md-2 control-label">Kd Merek</label> -->
                            <div class="col-md-4 col-sm-12 ">
                                <input readonly type="hidden" maxlength="30" class="form-control" id="txt_kd_merek" value="<?php echo $spk_data['tb_spk']['Kd_Merek'] ?>" name="txt_kd_merek" >                       
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="dari" class="col-md-2 control-label">Tipe</label>
                            <div class="col-md-3 col-sm-12 ">
                                <input readonly type="text" maxlength="30" class="form-control" id="txt_tipe" value="<?php echo $spk_data['tb_spk']['Tipe'] ?>" name="txt_tipe" >                       
                            </div>
                            <!-- <label for="dari" class="col-md-2 control-label">Kd Tipe</label> -->
                            <div class="col-md-4 col-sm-12 ">
                                <input readonly type="hidden" maxlength="30" class="form-control" value="<?php echo $spk_data['tb_spk']['Kd_Tipe'] ?>" id="txt_kd_tipe" name="txt_kd_tipe" >                       
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="dari" class="col-md-2 control-label">Warna</label>
                            <div class="col-md-3 col-sm-12 ">
                                <input readonly type="text" maxlength="30" class="form-control" id="txt_warna" value="<?php echo $spk_data['tb_spk']['Warna'] ?>" name="txt_warna" >                       
                            </div>
                              <!-- <label for="dari" class="col-md-2 control-label">Kd Warna</label> -->
                            <div class="col-md-4 col-sm-12 ">
                                <input readonly type="hidden" maxlength="30" class="form-control" value="<?php echo $spk_data['tb_spk']['Kd_Warna'] ?>" id="txt_kd_warna" name="txt_kd_warna" >                       
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="dari" class="col-md-2 control-label">Jenis Pembayaran</label>
                            <div class="col-md-4 col-sm-12 ">
                                <label class="radio-inline"><input type="radio"  name="txt_jns_pembayaran" id="tunai" value="Tunai" <?php echo($spk_data['tb_spk']['Jns_Bayar']=="Tunai"?'checked="checked"':''); ?> >Tunai</label>
                                <label class="radio-inline"><input type="radio"  name="txt_jns_pembayaran" id="kredit" value="Kredit" <?php echo($spk_data['tb_spk']['Jns_Bayar']=="Kredit"?'checked="checked"':''); ?>>Kredit</label>                                         
                            </div>                       
                        </div>  
                        <div class="form-group">
                            <label for="dari" class="col-md-2 control-label">Harga Kendaraan</label>
                            <div class="col-md-4 col-sm-12 ">
                                 <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input type="text"  readonly maxlength="30" class="form-control" id="txt_harga_kendaraan" value="<?php echo $spk_data['tb_spk']['Jml_Harga'] ?>" name="txt_harga_kendaraan" > 
                                </div> 
                            </div>
                            <label for="dari" class="col-md-1 control-label">Leasing</label>
                            <div class="col-md-4 col-sm-12 ">
                                <select disabled class="form-control select2"  name="kd_leasing" id="kd_leasing">
                                    <?php foreach ($tb_customer as $k => $v): ?>
                                    <option value=""></option>
                                    <option value="<?php echo $v['Kd_Cust'] ?>" <?php if($spk_data['tb_spk']['Kd_Fincoy']  == $v['Kd_Cust']) { echo "selected='selected'"; } ?> ><?php echo $v['Nm_Cust'] ?></option>
                                    <?php endforeach ?>
                                </select>                      
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dari" class="col-md-2 control-label">Uang Muka</label>
                            <div class="col-md-4 col-sm-12 ">
                                <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input type="text" maxlength="30"  onkeyup="pengurangan();" value="<?php echo $spk_data['tb_spk']['Uang_Muka'] ?>" class="form-control" id="txt_uang_muka" name="txt_uang_muka" > 
                                </div>  
                            </div>
                            <label for="dari" class="col-md-1 control-label">Tenor</label>
                            <div class="col-md-1 col-sm-12 ">
                                <input type="text" onkeypress="return hanyaAngka(event)" readonly maxlength="2" value="<?php echo $spk_data['tb_spk']['Tenor'] ?>" class="form-control" id="txt_tenor" name="txt_tenor" >                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dari" class="col-md-2 control-label"></label>
                            <div class="col-md-4 col-sm-12 "> 
                                <label class="radio-inline"><input type="radio" value=0 <?php echo($spk_data['tb_spk']['Stat_OTR']=="0"?'checked="checked"':''); ?> name="txt_jns_road">Off the Road</label>
                                <label class="radio-inline"><input type="radio" value=1 <?php echo($spk_data['tb_spk']['Stat_OTR']=="1"?'checked="checked"':''); ?> name="txt_jns_road">On the Road</label>
                            </div>
                            <label for="dari" class="col-md-1 control-label">Bunga</label>
                            <div class="col-md-3 col-sm-12 ">
                                <input type="text" readonly maxlength="2"  onkeypress="return hanyaAngka(event)" value="<?php echo $spk_data['tb_spk']['P_Bunga'] ?>" class="form-control" id="txt_bunga" name="txt_bunga" >                       
                            </div>
                        </div>
                        <div class="form-group">                        
                            <label for="dari" class="col-md-7 control-label">Angsuran</label>
                            <div class="col-md-4 col-sm-12 ">                                                                            
                                <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input type="text" readonly maxlength="30" class="form-control" id="txt_angsuran" value="<?php echo $spk_data['tb_spk']['Angsuran'] ?>" name="txt_angsuran" > 
                                </div>                          
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="dari" class="col-md-7 control-label">Jenis Angsuran</label>
                            <div  class="col-md-4 col-sm-12 ">
                                <label class="radio-inline"><input disabled type="radio" id="ADDB" value="B"  <?php echo($spk_data['tb_spk']['Tipe_Angs']=="B"?'checked="checked"':''); ?> name="txt_jns_angsuran">ADDB</label>
                                <label class="radio-inline"><input disabled type="radio" id="ADDM" value="M"  <?php echo($spk_data['tb_spk']['Tipe_Angs']=="M"?'checked="checked"':''); ?>name="txt_jns_angsuran">ADDM</label> 
                            </div>                       
                        </div> 
                        <input type="hidden" name="txt_no_spk" value="<?php echo $spk_data['tb_spk']['No_Spk'] ?>" class="form-control pull-right" id="txt_no_spk" > 
                        <div class="box-footer text-right">
                            <button type="submit"  id='Simpann' name="btnSimpan" class="btn btn-success"><i class="fa fa-check icon-white"></i> Simpan</button>
                        </div>
                    </div>          
                </div>               
                </div>
    </section>

</div>
<!-- /.content-wrapper-->
<div class="modal" id="modalStock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog" style="width:820px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">List No. Mesin</h4>
            </div>
            <div class="modal-body">
                <table style="width:100%" id="tblstock" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No Mesin</th>
                            <th>No Rangka</th>
                            <th>Kode Tipe</th>
                            <th>Nama Tipe</th>
                            <th>Kode Merek</th>
                            <th>Nama Merek</th>
                            <th>Warna</th>
                            <th>Harga Jual</th>
                        </tr>
                    </thead>                                
                </table>  
            </div>
            <div class="modal-footer">
                 <button class="btn btn-primary pull-right"  type="button" id="btn-reload"><i class="fa fa-refresh"></i> Reload</button> 
            </div>
        </div>
    </div>
</div>
<script>
    var table_stock;
    $(document).ready(function() {
        //datatables
        table_stock = $('#tblstock').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            
            "ajax": {
                "url": "<?php echo base_url('transaksi/spk/get_data_stock')?>",
                "type": "POST"
            },          
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            $(nRow).addClass('pilih_stock');         
            return nRow;
            }
           
        }); 
        $('#btn-reload').on('click', function(){
            table_stock.ajax.reload();
        });

        $(document).on('click', '.pilih_stock', function (e) {
        
        $(this).toggleClass('selected');
        var data_ = table_stock.row($(this)).data();  
        
            if(data_[8] == null){
                alert("Harga kendaraan belum disetting...")
                return false;
            }

            document.getElementById("txt_nomesin").value =data_[0];
            document.getElementById("txt_kd_tipe").value =data_[2];
            document.getElementById("txt_tipe").value =data_[3];
            document.getElementById("txt_kd_merek").value =data_[4];
            document.getElementById("txt_merek").value =data_[5];            
            document.getElementById("txt_kd_warna").value =data_[6];
            document.getElementById("txt_warna").value =data_[7];
            document.getElementById("txt_harga_kendaraan").value =data_[8];
        $('#modalStock').modal('hide');
        });
    });

    $(document).ready(function () {
       
        $("#tunai").click(function() {
            $("#kd_leasing").attr("disabled", true);
            $("#txt_pinjaman").attr("disabled", true);
            $("#txt_tenor").attr("readonly", true);
            $("#txt_bunga").attr("readonly", true);
            $("#txt_angsuran").attr("readonly", true);
            $("#ADDB").attr("disabled", true);
            $("#ADDM").attr("disabled", true);
         
            $('#kd_leasing').val('').trigger('change.select2'); 
            $("#txt_tenor").val("0");
            $("#txt_bunga").val("0");
            $("#txt_angsuran").val("0");
	   });

	  $("#kredit").click(function() {
	    	$("#kd_leasing").attr("disabled", false);
            $("#txt_pinjaman").attr("disabled", false);
            $("#txt_tenor").attr("readonly", false);
            $("#txt_bunga").attr("readonly", false);
            $("#txt_angsuran").attr("readonly", false);
            $("#ADDB").attr("disabled", false);
            $("#ADDM").attr("disabled", false);
	   });
        
       var i = $("input[type=radio][name=txt_jns_pembayaran]:checked").val();
       if(i=="Kredit"){
            $('#kredit').trigger('click');
        } 

        if(i=="Tunai"){
            $('#tunai').trigger('click');
        }
    });

    $(document).on('click', 'button#Simpann', function(){
        updatespk();
    });

    function updatespk()
    {
        var FormData = "txt_no_spk="+encodeURI($('#txt_no_spk').val());
        FormData += "&txt_cust="+encodeURI($('#txt_cust').val());
        FormData += "&optJnsKel="+encodeURI($('#optJnsKel').val());
        FormData += "&datepicker="+$('#datepickeredit').val();
        FormData += "&txt_alamat="+$('#txt_alamat').val();
        FormData += "&kd_salesman="+$('#kd_salesman').val();
        FormData += "&txt_nomesin="+$('#txt_nomesin').val();
        FormData += "&txt_kd_merek="+$('#txt_kd_merek').val();
        FormData += "&txt_kd_tipe="+$('#txt_kd_tipe').val();
        FormData += "&txt_kd_warna="+$('#txt_kd_warna').val();
        FormData += "&txt_jns_pembayaran="+ $('input:radio[name=txt_jns_pembayaran]:checked').val();
        FormData += "&txt_harga_kendaraan="+$('#txt_harga_kendaraan').val();
        FormData += "&kd_leasing="+$('#kd_leasing').val();
        FormData += "&txt_uang_muka="+$('#txt_uang_muka').val();
        FormData += "&txt_jns_road="+ $('input:radio[name=txt_jns_road]:checked').val();
        FormData += "&txt_bunga="+$('#txt_bunga').val();
        FormData += "&txt_tenor="+$('#txt_tenor').val();
        FormData += "&txt_angsuran="+$('#txt_angsuran').val();
        FormData += "&txt_jns_angsuran="+ $('input:radio[name=txt_jns_angsuran]:checked').val();

        $.ajax({
            url: "<?php echo base_url('transaksi/spk/ubah'); ?>",
            type: "POST",
            cache: false,
            data: FormData,
            dataType:'json',
            success: function(data){
                if(data.status == 1)
                {
                    alert(data.pesan);
                    window.location.href="<?php echo site_url('transaksi/spk'); ?>";
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