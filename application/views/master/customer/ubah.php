<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 40px;">
    <h1 class="pull-left">
      Ubah Customer
    </h1>
    <div class="pull-right">
    <a href="<?php echo base_url('master/customer')?>" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </section>

  <section class="content">
        <!-- Default box -->
        <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <form action="<?php echo base_url('master/customer/update')?>" method="post" class="form-horizontal">
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Kode Customer</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" readonly value="<?php echo $d_customer->Kd_Cust; ?>" class="form-control" name="txt_kd_cust" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Nama Customer</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" value="<?php echo $d_customer->Nm_Cust; ?>" class="form-control" name="txt_nm_cust" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Jenis Kelamin</label>
                <div class="col-md-7 col-sm-12 required">
                    <select class="form-control" style="min-width:350px;" required name="opt_jnskel" id="optJnsKel">
                        <option>Pilih Jenis Kelamin...</option>
                         <option value='L'<?php echo($d_customer->JnsKel=="L"?'selected="selected"':''); ?>>Laki-Laki</option>
                         <option value='P'<?php echo($d_customer->JnsKel=="P"?'selected="selected"':''); ?>>Perempuan</option>
                      </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Alamat Lengkap</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" placeholder="Alamat 1" value="<?php echo $d_customer->Alamat1; ?>" class="form-control" name="txt_alamat1" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label"></label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" placeholder="Alamat 2" value="<?php echo $d_customer->Alamat2; ?>" class="form-control" name="txt_alamat2">
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Kelurahan</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" value="<?php echo $d_customer->Kelurahan; ?>" class="form-control" name="txt_kelurahan" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Kecamatan</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" value="<?php echo $d_customer->Kecamatan; ?>" class="form-control" name="txt_kecamatan" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Kota</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" value="<?php echo $d_customer->Kota; ?>" class="form-control" name="txt_kota" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Kode Pos</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" value="<?php echo $d_customer->Kd_Pos; ?>" class="form-control" name="txt_kdpos" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">No Telepon</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" value="<?php echo $d_customer->Telepon; ?>" class="form-control" name="txt_telepon" required>
                </div>
            </div>   
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">Pekerjaan</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" value="<?php echo $d_customer->Pekerjaan; ?>" class="form-control" name="txt_pekerjaan" required>
                </div>
            </div>  
            <div class="form-group ">
                <label for="dari" class="col-md-3 control-label">No. KTP</label>
                <div class="col-md-7 col-sm-12 required">
                    <input type="text" value="<?php echo $d_customer->KTP; ?>" class="form-control" name="txt_ktp" required>
                </div>
            </div> 
            <div class="form-group">
                      <label for="dari" class="col-md-3 control-label">Status</label>
                      <div class="col-md-7 col-sm-12 required">
                        <label class="radio-inline">
                            <input type="radio" name="txt_status"  value="A" <?php echo($d_customer->Status=="A"?'checked="checked"':''); ?>>
                            Aktif
                        </label>
                        <label class="radio-inline">
                           <input type="radio" name="txt_status"  value="D" <?php echo($d_customer->Status=="D"?'checked="checked"':''); ?>>
                           Tidak Aktif
                        </label>  
                      </div>

                  </div>
            <div class="box-footer text-right">
                <a class="btn btn-default" href="<?php echo base_url('master/customer/tambah')?>"><i class="fa fa-close"></i> Batal</a>
                <button type="submit" name="btnSimpan" class="btn btn-success"><i class="fa fa-check icon-white"></i> Simpan</button>
             </div>
            </form>
        </div>
        </div>
    <!-- /.box -->
    </section>
 </div>
<!-- /.content-wrapper-->
