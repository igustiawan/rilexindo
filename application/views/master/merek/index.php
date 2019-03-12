<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 30px;">
    <h1 class="pull-left">
      <i class="fa fa-tasks"></i> Master Merek
    </h1>
  <div class="pull-right">
    <a href="<?php echo base_url('master/merek/tambah')?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Data</a>
  </div>

  </section>

<!-- Main content -->
  <section class="content">

  <!-- Main row -->
    <div class="row">
      <div class="col-md-12">

        <div class="box box-primary">
        <!--
          <div class="box-header with-border">
            <h3 class="box-title"></h3>
          </div><! /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <table id="dataTable" class="table table-bordered table-striped">
                 <thead>
                     <tr>
                         <th>KODE MEREK</th>
                         <th>NAMA MEREK</th>
                         <th>STATUS</th>
                         <th>AKSI</th>
                     </tr>
                 </thead>
                 <tbody>
                   <!--menampilkan data detail tanpa ajax
                     <?php if ($d_merek) {
                      foreach($d_merek as $d) {?>
                     <tr>
                         <td><?php echo $d->Kd_Merek; ?></td>
                         <td><?php echo $d->Merek; ?></td>
                         <td>
                         <?php if($d->Status == "A"){ ?>
                             <span class="label label-danger">Aktif</span>
                         <?php } elseif ($d->Status == "D"){ ?>
                             <span class="label label-warning">Tidak Aktif</span>
                         <?php }?>
                         </td>
                         <td>
                             <a class="btn btn-warning btn-xs" href="<?php echo base_url() . 'merek/ubah/' . $d->Kd_Merek ?>" rel="tooltip" title="Ubah"><i class="fa fa-pencil " ></i></a>
                         </td>
                     </tr>
                     <?php }
                   }?>-->
                 </tbody>
             </table>
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!--box body-->
          </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

  <!-- /.row (main row) -->
  </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper-->

<script>
 var table;
    $(document).ready(function() {
        //datatables
        table = $('#dataTable').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
             
            "ajax": {
                "url": "<?php echo base_url('master/merek/get_data_merek')?>",
                "type": "POST"
            },          
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
 
        });
 
    });
</script>
