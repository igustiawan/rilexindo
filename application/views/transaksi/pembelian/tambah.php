<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 40px;">
    <h1 class="pull-left">
      Input Pembelian
    </h1>
    <div class="pull-right">
    <a href="<?php echo base_url('transaksi/pembelian')?>" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </section>

  <section class="content">
        <!-- Default box -->
        <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <!-- <form action="<?php //echo base_url('transaksi/pembelian/simpan')?>" method="post" class="form-horizontal"> -->
            <div class="form-horizontal">
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Nama Penjual</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" maxlength="30" class="form-control" name="txt_nm_penjual" id="txt_nm_penjual" >
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Tgl Beli</label>
                <div class="col-md-7 col-sm-12 required">
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text"  name="txt_tgl_beli" class="form-control pull-right" id="datepickerNow" data-date-format="dd/mm/yyyy" >
                  </div>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Jenis Kelamin</label>
                <div class="col-md-4 col-sm-12 required">
                    <select class="form-control"  name="opt_jnskel" id="optJnsKel">
                        <option value="">Pilih Jenis Kelamin...</option>
                         <option value='L'>Laki-Laki</option>
                         <option value='P'>Perempuan</option>
                      </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Alamat Lengkap</label>
                <div class="col-md-7 col-sm-12 required">
                    <textarea   maxlength="100" class="form-control" name="txt_alamat" id="txt_alamat"></textarea>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Merek</label>
                <div class="col-md-4 col-sm-12 required">
                    <select name="kd_merek" id="kd_merek" class="form-control">
                        <option value="">Pilih Merek...</option>
                        <?php foreach($d_tipe->result() as $row):?>
                            <option value="<?php echo $row->Kd_Merek;?>"><?php echo $row->Merek;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Tipe</label>
                <div class="col-md-4 col-sm-12 required">
                        <select name="kd_tipe" id="kd_tipe"class="kd_tipe form-control">
                        <option value="">Pilih Tipe...</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Warna</label>
                <div class="col-md-4 col-sm-12 required">
                    <select class="form-control"  name="kd_warna" id="kd_warna">
                    <option value="">Pilih Warna...</option>
                        <?php
                        if($d_warna){
                        foreach($d_warna as $d){
                            echo "<option value='$d->Kd_Warna'>$d->Warna</option>";
                        }
                        }
                    ?>
                    </select>
                </div>
             </div>
            <div class="row">                
                <div class="col-md-12">     
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Kendaraan</h3>
                        </div>
                        <div class="box-body">
                                <div class="col-md-7">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">No Polisi</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input type="text"  maxlength="10" value="<?php ?>" class="form-control" name="txt_no_polisi" id="txt_no_polisi" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">No BPKB</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input  maxlength="30" type="text" class="form-control" name="txt_no_bpkb" id="txt_no_bpkb"  >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">No Rangka</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input maxlength="30" type="text" value="<?php ?>" class="form-control" name="txt_no_rangka" id="txt_no_rangka" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">Nama STNK</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input  maxlength="50" type="text" value="<?php ?>" class="form-control" name="txt_nm_stnk"  id="txt_nm_stnk">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">No Mesin</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input  maxlength="30" type="text" value="<?php ?>" class="form-control" name="txt_no_mesin" id="txt_no_mesin" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">No STNK</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input  maxlength="30" type="text" value="<?php ?>" class="form-control" name="txt_no_stnk" id="txt_no_stnk">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">Kapasitas</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input  maxlength="4" type="text" value="<?php ?>" class="form-control" name="txt_kapasitas" id="txt_kapasitas" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">Tgl STNK</label>
                                            <div class="col-md-7 col-sm-12 required">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text"  name="txt_tgl_stnk"   class="form-control pull-right" id="datepicker" data-date-format="dd/mm/yyyy" >
                                                </div>
                                            </div>
                                      </div>
                                </div>
                                <div class="col-md-7">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">Tahun Produksi</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input type="text"  maxlength="4" value="<?php ?>" class="form-control" name="txt_thn_produksi"  id="txt_thn_produksi" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">Ongkir</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input type="text" value="<?php ?>" class="form-control" name="txt_ongkir"  id="txt_ongkir">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer text-right">
                <a class="btn btn-default" href="<?php echo base_url('transaksi/pembelian/tambah')?>"><i class="fa fa-close"></i> Batal</a>
                <button type="submit" id='Simpann' name="btnSimpan" class="btn btn-success"><i class="fa fa-check icon-white"></i> Simpan</button>
             </div>
             </div>
        </div>
        </div>
    <!-- /.box -->
    </section>
 </div>
<!-- /.content-wrapper-->
<script type="text/javascript">
    $(document).ready(function(){
        $('#kd_merek').change(function(){
           
            var id=$(this).val();
            $.ajax({
                url : "<?php echo base_url('transaksi/pembelian/get_tipe')?>",
                method : "POST",
                data : {id: id},
                async : false,
                dataType : 'json',
                success: function(data){
                 
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].Kd_Tipe+'>'+data[i].Tipe+'</option>';
                    }
                    $('.kd_tipe').html(html);
                     
                }
            });
        });
    });

    $(document).on('click', '#Simpann', function(){

        $('.modal-dialog').removeClass('modal-lg');
        $('.modal-dialog').addClass('modal-sm');
        $('#ModalHeader').html('Konfirmasi');
        $('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
        $('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
        $('#ModalGue').modal('show');

        setTimeout(function(){ 
   		    $('button#SimpanTransaksi').focus();
        }, 500);
    });

    $(document).on('click', 'button#SimpanTransaksi', function(){
        SimpanTransaksi();
    });

    function SimpanTransaksi()
    {
        var FormData = "txt_nm_penjual="+encodeURI($('#txt_nm_penjual').val());
        FormData += "&optJnsKel="+encodeURI($('#optJnsKel').val());
        FormData += "&txt_alamat="+$('#txt_alamat').val();
        FormData += "&kd_tipe="+$('#kd_tipe').val();
        FormData += "&kd_merek="+$('#kd_merek').val();
        FormData += "&kd_warna="+$('#kd_warna').val();
        FormData += "&txt_no_polisi="+$('#txt_no_polisi').val();
        FormData += "&txt_no_bpkb="+$('#txt_no_bpkb').val();
        FormData += "&txt_no_rangka="+$('#txt_no_rangka').val();
        FormData += "&txt_nm_stnk="+$('#txt_nm_stnk').val();
        FormData += "&txt_no_mesin="+$('#txt_no_mesin').val();
        FormData += "&txt_no_stnk="+$('#txt_no_stnk').val();
        FormData += "&txt_kapasitas="+$('#txt_kapasitas').val();
        FormData += "&txt_thn_produksi="+$('#txt_thn_produksi').val();
        FormData += "&txt_tgl_beli="+$('#datepickerNow').val();
        FormData += "&txt_tgl_stnk="+$('#datepicker').val();
        
        $.ajax({
            url: "<?php echo base_url('transaksi/pembelian/simpan'); ?>",
            type: "POST",
            cache: false,
            data: FormData,
            dataType:'json',
            success: function(data){
                if(data.status == 1)
                {
                    alert(data.pesan);
                    window.location.href="<?php echo site_url('transaksi/pembelian'); ?>";
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
