<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 30px;">
    <h1 class="pull-left">
      <i class="fa fa-tasks"></i> Database Leasing
    </h1>
  <div class="pull-right">
    <a href="<?php echo base_url('master/leasing/tambah')?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah LEASING</a>
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
                         <th>KODE LEASING</th>
                         <th>NAMA LEASING</th>
                         <th>ALAMAT</th>
                         <th>STATUS</th>
                         <th>AKSI</th>
                     </tr>
                 </thead>                 
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
                "url": "<?php echo base_url('master/leasing/get_data_leasing')?>",
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
