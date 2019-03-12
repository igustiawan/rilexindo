<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 40px;">
    <h1 class="pull-left">
      Tambah Master Tipe
    </h1>
    <div class="pull-right">
    <a href="<?php echo base_url('master/tipe')?>" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </section>

  <div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
              <form action="<?php echo base_url('master/tipe/simpan')?>" method="post" class="form-horizontal">
                <div class="form-group ">
                    <label for="dari" class="col-md-3 control-label">Tipe</label>
                    <div class="col-md-7 col-sm-12 required">
                      <input type="text" value="<?php ?>" class="form-control" name="txt_tipe" required>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="tipe" class="col-md-3 control-label">Merek</label>
                    <div class="col-md-7">
                      <select class="form-control select2" style="min-width:350px;" required name="opt_merek" id="optMerek">
                        <option></option>
                         <?php
                         if($d_merek){
                           foreach($d_merek as $d){
                             echo "<option value='$d->Kd_Merek'>$d->Merek</option>";
                            }
                          }
                        ?>
                      </select>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <a class="btn btn-default" href="<?php echo base_url('master/tipe/tambah')?>"><i class="fa fa-close"></i> Batal</a>
                    <button type="submit" name="btnSimpan" class="btn btn-success"><i class="fa fa-check icon-white"></i> Simpan</button>
                  </div>
                </form>
            </div>
        </div>
    </div> <!-- col -->
  </div><!-- row -->

</div>
<!-- /.content-wrapper-->
