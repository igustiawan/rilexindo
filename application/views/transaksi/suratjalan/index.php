<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 30px;">
    <h1 class="pull-left">
      <i class="fa fa-tasks"></i> Surat Jalan
    </h1>
    
  <div class="pull-right">
     <div class="col-xs-12">
        <button class="btn btn-primary pull-right"  type="button" id="btn-reload"><i class="fa fa-refresh"></i> Reload</button>
        <a  style="margin-right: 5px;" href="<?php echo base_url('transaksi/suratjalan/tambah')?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> INPUT SJ</a>
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
                         <th>NO SJ</th>
                         <th>TGL SJ</th>
                         <th>NO SO</th>
                         <th>NAMA CUSTOMER</th>
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
                "url": "<?php echo base_url('transaksi/suratjalan/get_data_suratjalan')?>",
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
<!-- MODAL PROSES SURAT JALAN -->
<?php foreach($all as $row): ?>
 <div class="modal" id="modal_proses_suratjalan<?php echo $row->No_So;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 class="modal-title" id="myModalLabel">Proses Surat Jalan</h3>
      </div>
      <form class="form-horizontal" method="post" action="<?php echo base_url('transaksi/suratjalan/proses')?>">
          <div class="modal-body">
              <p>Anda yakin mau batal sales order berikut : <b><?php echo $row->No_So;?></b></p>
          </div>
          <div class="modal-footer">
              <input type="hidden" name="txt_no_so" value="<?php echo $row->No_So;?>" >
              <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
              <button class="btn btn-danger">Proses</button>
          </div>
      </form>
      </div>
      </div>
</div>   
<?php endforeach; ?>    
<!-- END MODAL PROSES SURAT JALAN -->
