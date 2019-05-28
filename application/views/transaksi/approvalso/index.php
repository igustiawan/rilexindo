<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 30px;">
    <h1 class="pull-left">
      <i class="fa fa-tasks"></i> Approval Sales Order
    </h1>
    <div class="pull-right">
    <!-- <a href="<?php echo base_url('transaksi/approvalso/index')?>" class="btn btn-primary pull-right"><i class="fa fa-refresh"></i> RELOAD</a> -->
    <button class="btn btn-primary pull-right" type="button" id="btn-reload"><i class="fa fa-refresh"></i> Reload</button>
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
                "url": "<?php echo base_url('transaksi/approvalso/get_data_approvalso')?>",
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
 <?php foreach($all as $row): ?>
 <div class="modal" id="modal_approvalso<?php echo $row->No_So;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog" style="width:1000px;">
      <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 class="modal-title" id="myModalLabel">Approval Sales Order</h3>
      </div>
      <form class="form-horizontal" method="post" action="<?php echo base_url('transaksi/approvalso/approve')?>">
          <div class="modal-body">
                 <table class="table">
                     <tr>
                        <th>No. SO</th>
                        <td><input readonly style="border:none" type="text" name="txt_no_so" value="<?php echo $row->No_So;?>"></td>
                     </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>
                        <input  readonly style="border:none" type="text" name="txt_alamat" value="<?php echo $row->Alamat;?>">
                        <input style="border:none" type="hidden" name="txt_kd_cust" value="<?php echo $row->Kd_Cust;?>">
                        <input style="border:none" type="hidden" name="txt_tgl_so" value="<?php echo $row->Tgl_So;?>">
                        <input style="border:none" type="hidden" name="txt_kd_fincoy" value="<?php echo $row->Kd_Fincoy;?>">
                        </td>
                    </tr>                   
                    <?php
                    if($row->Jns_Bayar=="Tunai"){
                     ?>
                        <tr>
                            <th>Pembayaran</th>
                            <td><input  readonly style="border:none" type="text" name="txt_pembayaran" value="<?php echo $row->Jns_Bayar;?>"></td>
                        </tr> 
                        <tr>
                          <th>DP</th>
                          <td><input  readonly style="border:none" type="text" name="txt_dp" value="<?php echo $row->By_Tunai;?>"></td>
                        </tr>
                    <?php
                    }else
                    {
                    ?>     
                    <tr>
                        <th>Pembayaran</th>
                        <td><input  readonly style="border:none" type="text" name="txt_pembayaran" value="<?php echo $row->Jns_Bayar;?>"></td>
                        <th>Leasing</th>
                        <td><input  readonly style="border:none" type="text" name="txt_leasing" value="<?php echo $row->Nm_Fincoy;?>"></td>               
                    </tr> 
                    <tr>
                        <th>Lama Angsuran</th>
                        <td><input  readonly style="border:none" type="text" name="txt_tenor" value="<?php echo $row->Tenor;?> Bulan"></td>            
                        <th>Jumlah Angsuran</th>
                        <td><input  readonly style="border:none" type="text" name="txt_angsuran" value="<?php echo $row->Angsuran;?>"></td>    
                    </tr>  
                    <tr>
                        <th>DP</th>
                        <td><input  readonly style="border:none" type="text" name="txt_dp" value="<?php echo $row->DP;?>"></td>                                
                        <th>ADM</th>
                        <td><input style="border:none" type="text" name="txt_bunga" value="<?php echo $row->ADM;?>"></td>                
                    </tr>  
                    <tr>
                        <th>Bunga</th>
                        <td><input  readonly style="border:none" type="text" name="txt_bunga" value="<?php echo $row->Bunga;?>"></td>                    
                    </tr>             
                    <?php 
                    }
                    ?>
                    <tr>
                        <th>Diskon yang diajukan</th>
                        <td><input  readonly style="border:none" type="text" name="txt_diskon_diajukan" value="<?php echo $row->Diskon;?>"></td>
                    </tr>
                    <tr>
                        <th>Diskon yang disetujui</th>
                        <td><input type="text" name="txt_diskon_disetujui" value="<?php echo $row->Diskon;?>"></td>
                    </tr>
                 </table>
                 <table id="detailso" class="table table-bordered" style="width:100%; margin-bottom: 10px;"> 
                    <thead>
                        <tr>
                            <th>No Mesin</th>
                            <th>Nama Mobil</th>
                            <th>Warna</th> 
                            <th>Harga Jual</th>                
                        </tr>
                    </thead>
                    <tbody>        
                        <tr>
                            <td><input  readonly style="border:none" type="text" name="txt_no_mesin" value="<?php echo $row->No_Mesin;?>"></td>
                            <td><input  readonly style="border:none" type="text" name="txt_tipe" value="<?php echo $row->Tipe;?>"></td>
                            <td><input  readonly style="border:none" type="text" name="txt_warna" value="<?php echo $row->Warna;?>"></td>
                            <td><input  readonly style="border:none" type="text" name="txt_hrg_jual" value="<?php echo $row->Hrg_Jual;?>"></td>
                           
                        </tr>                                 
                    </tbody>
                    <tfoot>
                    </tfoot>                
                </table>

          </div>
          <div class="modal-footer">
              <input type="hidden" name="txt_no_so" value="<?php echo $row->No_So;?>" >  
              <button class="btn btn-danger">Process</button>
              <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>          
             
          </div>
      </form>
       
      </div>
      </div>
</div>   
<?php endforeach; ?>  
