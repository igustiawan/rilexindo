<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 30px;">
    <h1 class="pull-left">
      <i class="fa fa-tasks"></i> Sales Order
    </h1>
    
  <div class="pull-right">
     <div class="col-xs-12">
        <button class="btn btn-primary pull-right"  type="button" id="btn-reload"><i class="fa fa-refresh"></i> Reload</button>
  
        <a  style="margin-right: 5px;" href="<?php echo base_url('transaksi/salesorder/tambah')?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> INPUT SALES ORDER</a>
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
                         <th>NO SO</th>
                         <th>TGL SO</th>
                         <th>NAMA CUSTOMER</th>                      
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
                "url": "<?php echo base_url('transaksi/salesorder/get_data_salesorder')?>",
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

<!-- MODAL PROSES SALES ORDER -->
<?php foreach($all as $row): ?>
 <div class="modal" id="modal_proses<?php echo $row->No_So;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog" >
      <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 class="modal-title" id="myModalLabel">Proses Sales Order <?php echo $row->No_So;?></h3>
      </div>
      <form class="form-horizontal" method="post" action="<?php echo base_url('transaksi/salesorder/proses')?>">
          <div class="modal-body">
              <table class="table">
                    <tr>
                        <th>Customer</th>
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
                    <tr>
                        <th>Pembayaran</th>
                        <td><input style="border:none" type="text" name="txt_pembayaran" value="<?php echo $row->Jns_Bayar;?>"></td>
                    </tr>                                   
                     <?php
                    if($row->Jns_Bayar=="Tunai"){
                     ?>
                        <tr>
                          <th>DP</th>
                          <td><input style="border:none" type="text" name="txt_dp" value="<?php echo number_format($row->By_Tunai, '0', ',', '.');?>"></td>
                        </tr>
                    <?php
                    }else
                    {
                    ?>
                        <tr>
                          <th>Harga Mobil</th>
                          <td><input style="border:none" type="text" name="txt_dp" value="<?php echo number_format($row->Ttl_Hrg_Otr, '0', ',', '.');?>"></td>
                        </tr>
                        <tr>
                          <th>Lama Angsuran</th>
                          <td><input style="border:none" type="text" name="txt_dp" value="<?php echo number_format($row->Tenor, '0', ',', '.');?>"></td>
                        </tr>
                        <tr>
                          <th>Jumlah Angsuran</th>
                          <td><input style="border:none" type="text" name="txt_dp" value="<?php echo number_format($row->Angsuran, '0', ',', '.');?>"></td>
                        </tr>                  
               <?php 
                    }
                ?>
                    <tr>
                      <th>Diskon</th>
                      <td><input style="border:none" type="text" name="txt_dp" value="<?php echo number_format($row->Diskon, '0', ',', '.');?>"></td>
                    </tr>                  
                </table>
                    <tr>
                      <i>Note: Data yang sudah diproses tidak dapat dibatalkan..</i>
                    </tr>
          </div>
          <div class="modal-footer">
              <input type="hidden" name="txt_no_so" value="<?php echo $row->No_So;?>" >
              <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
              <button class="btn btn-danger">Process</button>
          </div>
      </form>
      </div>
      </div>
</div>   
<?php endforeach; ?> 
<!-- END MODAL PROSES SALES ORDER -->

<!-- MODAL BATAL SALES ORDER -->
 <?php foreach($all as $row): ?>
 <div class="modal" id="modal_batal<?php echo $row->No_So;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 class="modal-title" id="myModalLabel">Batal Sales Order</h3>
      </div>
      <form class="form-horizontal" method="post" action="<?php echo base_url('transaksi/salesorder/batal')?>">
          <div class="modal-body">
              <p>Anda yakin mau batal sales order berikut : <b><?php echo $row->No_So;?></b></p>
          </div>
          <div class="modal-footer">
              <input type="hidden" name="txt_no_so" value="<?php echo $row->No_So;?>" >
              <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
              <button class="btn btn-danger">Batal</button>
          </div>
      </form>
      </div>
      </div>
</div>   
<?php endforeach; ?>    
<!-- END MODAL BATAL SALES ORDER -->

<!-- MODAL PERSETUJUAN BAST -->
<?php foreach($all as $row): ?>
 <div class="modal" id="modal_persetujuan_bast<?php echo $row->No_So;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog" style="width:900px;">
      <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 class="modal-title" id="myModalLabel">Persetujuan boleh BAST dengan kondisi dp/tunai belum lunas</h3>
      </div>
      <form class="form-horizontal" method="post" action="<?php echo base_url('transaksi/salesorder/proses_persetujuan_bast')?>">
          <div class="modal-body">
          <table class="table">
            <tr>
                <th>No. SO</th>
                <td><input readonly style="border:none" type="text" name="txt_no_so" value="<?php echo $row->No_So;?>"></td>
            </tr>
            <tr>
                <th>Nama Customer</th>
                <td><input readonly style="border:none" type="text" name="txt_nm_cust" value="<?php echo $row->Nm_Cust;?>"></td>
            </tr>  
            <tr>
                <th>Jenis Pembayaran</th>
                <td><input readonly style="border:none" type="text" name="txt_pembayaran" value="<?php echo $row->Jns_Bayar;?>"></td>
            </tr> 
            <tr>
                <th>Keterangan</th>
                <td><textarea required maxlength="100" class="form-control" id="txt_keterangan" name="txt_keterangan" ></textarea></td>
            </tr>                                      
            </table>
          </div>
          <div class="modal-footer">
              <input type="hidden" name="txt_no_so" value="<?php echo $row->No_So;?>" >
              <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
              <button class="btn btn-danger">Process</button>
          </div>
      </form>
      </div>
      </div>
</div>   
<?php endforeach; ?>
<!-- END MODAL PERSETUJUAN BAST -->


