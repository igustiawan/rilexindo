<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 40px;">
    <h1 class="pull-left">
      Ubah Merek
    </h1>
    <div class="pull-right">
    <a href="<?php echo base_url('master/merek')?>" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </section>

  <?php echo $this->session->flashdata('psn_sukses');?>
  <?php
    if($this->session->flashdata('psn_sukses')){
  ?>
    <div class="alert alert-success">
      <?php echo $this->session->flashdata('psn_sukses');?>
    </div>
  <?php
  }
  ?>

  <div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
              <form action="<?php echo base_url('master/merek/update')?>" method="post" class="form-horizontal">
                 <div class="form-group ">
                      <label for="dari" class="col-md-3 control-label">Kode Merek</label>
                      <div class="col-md-7 col-sm-12 required">
                        <input readonly type="text" value="<?php echo $d_merek->Kd_Merek; ?>" class="form-control" name="txt_kd_merek">
                      </div>
                  </div>
                  <div class="form-group ">
                      <label for="dari" class="col-md-3 control-label">Merek</label>
                      <div class="col-md-7 col-sm-12 required">
                        <input type="text" value="<?php echo $d_merek->Merek; ?>" class="form-control" name="txt_merek" required>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="dari" class="col-md-3 control-label">Status</label>
                      <div class="col-md-7 col-sm-12 required">
                        <label class="radio-inline">
                            <input type="radio" name="txt_status"  value="A" <?php echo($d_merek->Status=="A"?'checked="checked"':''); ?>>
                            Aktif
                        </label>
                        <label class="radio-inline">
                           <input type="radio" name="txt_status"  value="D" <?php echo($d_merek->Status=="D"?'checked="checked"':''); ?>>
                           Tidak Aktif
                        </label>  
                      </div>
                  </div>
                  <div class="box-footer text-right">
                    <a class="btn btn-default" href="<?php echo base_url('master/merek/ubah/' .  $d_merek->Kd_Merek)?>"><i class="fa fa-close"></i> Batal</a>
                    <button type="submit" name="btnSimpan" class="btn btn-success"><i class="fa fa-check icon-white"></i> Simpan</button>
                  </div>
                </form>
            </div>
        </div>
    </div> <!-- col -->
  </div><!-- row -->

</div>
<!-- /.content-wrapper-->
