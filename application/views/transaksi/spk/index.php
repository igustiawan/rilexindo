<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 30px;">
    <h1 class="pull-left">
      <i class="fa fa-tasks"></i> Surat Pesanan Kendaraan (SPK)
    </h1>
  <div class="pull-right">
    <a href="<?php echo base_url('transaksi/spk/tambah')?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> INPUT SPK</a>
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
                         <th>NO SPK</th>
                         <th>CUSTOMER</th>
                         <th>ALAMAT</th>
                         <th>NO MESIN</th>
                         <th>TIPE</th>
                         <th>WARNA</th>
                         <th>JENIS BAYAR</th>
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
                "url": "<?php echo base_url('transaksi/spk/get_data_spk')?>",
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

 <?php foreach($all as $row): ?>
 <div class="modal" id="modal_proses<?php echo $row->No_Spk;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 class="modal-title" id="myModalLabel">Proses SPK</h3>
      </div>
      <form class="form-horizontal" method="post" action="<?php echo base_url('transaksi/spk/proses')?>">
          <div class="modal-body">
              <p>Anda yakin mau Proses SPK berikut : <b><?php echo $row->No_Spk;?></b></p>
              <table class="table">
                    <tr>
                        <th>Nama Customer</th>
                        <td><input style="border:none" type="text" name="txt_nm_cust" value="<?php echo $row->Nm_Cust;?>"></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><input style="border:none" type="text" name="txt_alamat" value="<?php echo $row->Alamat;?>"></td>
                    </tr>
                    <tr>
                        <th>No Mesin</th>
                        <td><input style="border:none" type="text" name="txt_no_mesin" value="<?php echo $row->No_Mesin;?>"></td>
                    </tr>
                </table>
          </div>
          <div class="modal-footer">
              <input type="hidden" name="txt_no_spk" value="<?php echo $row->No_Spk;?>" >
              <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
              <button class="btn btn-danger">Process</button>
          </div>
      </form>
      </div>
      </div>
</div>   
<?php endforeach; ?> 

<?php foreach($all as $row): ?>
 <div class="modal" id="modal_batal<?php echo $row->No_Spk;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 class="modal-title" id="myModalLabel">BATAL SPK</h3>
      </div>
      <form class="form-horizontal" method="post" action="<?php echo base_url('transaksi/spk/batal')?>">
          <div class="modal-body">
              <p>Anda yakin mau BATAL SPK berikut : <b><?php echo $row->No_Spk;?></b></p>
          </div>
          <div class="modal-footer">
              <input type="hidden" name="txt_no_spk" value="<?php echo $row->No_Spk;?>" >
              <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
              <button class="btn btn-danger">Batal</button>
          </div>
      </form>
      </div>
      </div>
</div>   
<?php endforeach; ?> 