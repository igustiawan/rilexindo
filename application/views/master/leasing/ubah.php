<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 40px;">
    <h1 class="pull-left">
      Ubah Leasing
    </h1>
    <div class="pull-right">
    <a href="<?php echo base_url('master/leasing')?>" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </section>

  <section class="content">
        <!-- Default box -->
        <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <form action="<?php echo base_url('master/leasing/update')?>" method="post" class="form-horizontal">
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Kode Leasing</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" readonly value="<?php echo $d_leasing->Kd_Cust; ?>" class="form-control" name="txt_kd_cust" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Nama Leasing</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" value="<?php echo $d_leasing->Nm_Cust; ?>" class="form-control" name="txt_nm_cust" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Alamat Lengkap</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" placeholder="Alamat 1" value="<?php echo $d_leasing->Alamat1; ?>" class="form-control" name="txt_alamat1" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label"></label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" placeholder="Alamat 2" value="<?php echo $d_leasing->Alamat2; ?>" class="form-control" name="txt_alamat2">
                </div>
            </div>            
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Kota</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" value="<?php echo $d_leasing->Kota; ?>" class="form-control" name="txt_kota" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Kode Pos</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" value="<?php echo $d_leasing->Kd_Pos; ?>" class="form-control" name="txt_kdpos" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">No Telepon</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" value="<?php echo $d_leasing->Telepon; ?>" class="form-control" name="txt_telepon" required>
                </div>
            </div>              
            <div class="form-group">
                      <label for="dari" class="col-md-3 control-label">Status</label>
                      <div class="col-md-7 col-sm-12 required">
                        <label class="radio-inline"><input type="radio" name="txt_status" value="A" <?php echo($d_leasing->Status=="A"?'checked="checked"':''); ?>>Aktif</label>
                        <label class="radio-inline"><input type="radio" name="txt_status" value="D" <?php echo($d_leasing->Status=="D"?'checked="checked"':''); ?>>Tidak Aktif</label> 
                      </div>
                  </div>
            <div class="box-footer text-right">
                <a class="btn btn-default" href="<?php echo base_url('master/leasing/tambah')?>"><i class="fa fa-close"></i> Batal</a>
                <button type="submit" name="btnSimpan" class="btn btn-success"><i class="fa fa-check icon-white"></i> Simpan</button>
             </div>
            </form>
        </div>
        </div>
    <!-- /.box -->
    </section>
 </div>
<!-- /.content-wrapper-->
