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
            <form action="<?php echo base_url('transaksi/pembelian/simpan')?>" method="post" class="form-horizontal">
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Nama Penjual</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" maxlength="30" class="form-control" name="txt_nm_penjual" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Tgl Beli</label>
                <div class="col-md-7 col-sm-12 required">
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text"  name="txt_tgl_beli" class="form-control pull-right" id="datepickerNow" data-date-format="dd/mm/yyyy" required>
                  </div>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Jenis Kelamin</label>
                <div class="col-md-4 col-sm-12 required">
                    <select class="form-control" required name="opt_jnskel" id="optJnsKel">
                        <option>Pilih Jenis Kelamin...</option>
                         <option value='L'>Laki-Laki</option>
                         <option value='P'>Perempuan</option>
                      </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Alamat Lengkap</label>
                <div class="col-md-7 col-sm-12 required">
                    <textarea   maxlength="100" class="form-control" name="txt_alamat" required></textarea>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Merek</label>
                <div class="col-md-4 col-sm-12 required">
                    <select name="kd_merek" id="kd_merek" class="form-control">
                        <option value="0">Pilih Merek...</option>
                        <?php foreach($d_tipe->result() as $row):?>
                            <option value="<?php echo $row->Kd_Merek;?>"><?php echo $row->Merek;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Tipe</label>
                <div class="col-md-4 col-sm-12 required">
                        <select name="kd_tipe" class="kd_tipe form-control">
                        <option value="0">Pilih Tipe...</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-2 control-label">Warna</label>
                <div class="col-md-4 col-sm-12 required">
                    <select class="form-control" required name="kd_warna" id="kd_warna">
                    <option value="0">Pilih Warna...</option>
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
                                            <input type="text"  maxlength="10" value="<?php ?>" class="form-control" name="txt_no_polisi" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">No BPKB</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input  maxlength="30" type="text" class="form-control" name="txt_no_bpkb" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">No Rangka</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input maxlength="30" type="text" value="<?php ?>" class="form-control" name="txt_no_rangka" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">Nama STNK</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input  maxlength="50" type="text" value="<?php ?>" class="form-control" name="txt_nm_stnk" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">No Mesin</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input  maxlength="30" type="text" value="<?php ?>" class="form-control" name="txt_no_mesin" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">No STNK</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input  maxlength="30" type="text" value="<?php ?>" class="form-control" name="txt_no_stnk" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">Kapasitas</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input  maxlength="4" type="text" value="<?php ?>" class="form-control" name="txt_kapasitas" required>
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
                                                    <input type="text"  name="txt_tgl_stnk" class="form-control pull-right" id="datepicker" data-date-format="dd/mm/yyyy" required>
                                                </div>
                                            </div>
                                      </div>
                                </div>
                                <div class="col-md-7">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">Tahun Produksi</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input type="text"  maxlength="4" value="<?php ?>" class="form-control" name="txt_thn_produksi" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">   
                                    <div class="form-group ">
                                        <label for="dari" class="col-md-3 control-label">Ongkir</label>
                                            <div class="col-md-7 col-sm-12 required">
                                            <input type="text" value="<?php ?>" class="form-control" name="txt_ongkir">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer text-right">
                <a class="btn btn-default" href="<?php echo base_url('transaksi/pembelian/tambah')?>"><i class="fa fa-close"></i> Batal</a>
                <button type="submit" name="btnSimpan" class="btn btn-success"><i class="fa fa-check icon-white"></i> Simpan</button>
             </div>
            </form>
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
</script>
