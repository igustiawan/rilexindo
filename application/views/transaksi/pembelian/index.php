<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 30px;">
    <h1 class="pull-left">
      <i class="fa fa-tasks"></i> Transaksi Pembelian
    </h1>
  <div class="pull-right">
    <div class="col-xs-12">
      <button class="btn btn-primary pull-right"  type="button" id="btn-reload"><i class="fa fa-refresh"></i> Reload</button>
      <a style="margin-right: 5px;"  href="<?php echo base_url('transaksi/pembelian/tambah')?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> INPUT TRANSAKSI PEMBELIAN</a>
    </div>
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
                         <th>KODE TRANSAKSI</th>
                         <th>TGL BELI</th>
                         <th>NAMA PENJUAL</th>
                         <th>TIPE</th>
                         <th>WARNA</th>
                         <th>NO MESIN</th>
                         <th>TAHUN PRODUKSI</th>
                         <th>NO POLISI</th>
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
                "url": "<?php echo base_url('transaksi/pembelian/get_data_pembelian')?>",
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

       $(document).ready(function (){    
        $('#btn-reload').on('click', function(){
            table.ajax.reload();
        });
    });

</script>
