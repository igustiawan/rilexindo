<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 40px;">
    <h1 class="pull-left">
      Tambah Master Warna
    </h1>
    <div class="pull-right">
    <a href="<?php echo base_url('master/warna')?>" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </section>

  <div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
              <form action="<?php echo base_url('master/warna/simpan')?>" method="post" class="form-horizontal">
               <!--<div class="form-group ">
                    <label for="dari" class="col-md-3 control-label">Kode Merek</label>
                    <div class="col-md-7 col-sm-12 required">
                      <input type="text" value="<?php ?>" class="form-control" name="txt_id">
                    </div>
                </div>-->
                <!-- merek    value="<?php echo $d_id; ?>"-->
                <div class="form-group ">
                    <label for="dari" class="col-md-3 control-label">Warna</label>
                    <div class="col-md-7 col-sm-12 required">
                      <input type="text" value="<?php ?>" class="form-control" name="txt_warna" required>
                    </div>
                </div>
                  <div class="box-footer text-right">
                    <a class="btn btn-default" href="<?php echo base_url('master/warna/tambah')?>"><i class="fa fa-close"></i> Batal</a>
                    <button type="submit" name="btnSimpan" class="btn btn-success"><i class="fa fa-check icon-white"></i> Simpan</button>
                  </div>
                </form>
            </div>
        </div>
    </div> <!-- col -->
  </div><!-- row -->

</div>
<!-- /.content-wrapper-->
