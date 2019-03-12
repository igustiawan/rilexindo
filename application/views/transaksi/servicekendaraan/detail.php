<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 40px;">
    <h1 class="pull-left">
    	Detail Service Kendaraan
    </h1>
    <div class="pull-right">
    <a href="<?php echo base_url('transaksi/servicekendaraan')?>" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
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
          		<div class="row">
                 	<div class="col-md-12">
	                 	<div class="form-group ">
	                      	<label for="dari" class="col-md-3 control-label">No Transaksi</label>
	                      	<div class="col-md-7 col-sm-12 required">
	                        	<input readonly type="text" value="<?php echo $list[0]->No_Transaksi?>" class="form-control" name="txt_no_trx">
	                    	</div>
	                  	</div>
	                  	<div class="form-group">
	                        <label for="dari" class="col-md-3 control-label">No Mesin</label>
	                        <div class="col-md-7 col-sm-12 required">
	                        	<input readonly type="text" value="<?php echo $list[0]->No_Mesin?>"  class="form-control" name="txt_nomesin">
	                        </div>
	                    </div>
	                    <div class="form-group ">
                        	<label for="dari" class="col-md-3 control-label">Tgl Service</label>
                            <div class="col-md-7 col-sm-12 required">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" readonly name="txt_tgl_service" class="form-control pull-right"  data-date-format="dd/mm/yyyy" required  value="<?php echo datetime_only($list[0]->Tgl_Service); ?>" >
                                </div>
                            </div>
	                    </div>               
	                    <div class="form-group ">
                        	<label for="dari" class="col-md-3 control-label">Keterangan</label>
                            <div class="col-md-7 col-sm-12 required">
                                <input readonly type="text" value="<?php echo $list[0]->Keterangan?>" class="form-control" name="txt_keterangan" required>
                            </div>
	                    </div> 
	                    <div class="form-group ">
	                        <label for="dari" class="col-md-3 control-label">Total Harga</label>
                            <div class="col-md-3 col-sm-12 required">
                                 <input type="text" class="form-control" value="<?php echo number_format($list[0]->Total_Harga); ?>"  readonly name="txt_totalharga" required>
                            </div>
	                    </div> 
                   	</div>
                </div> 
            </div>
            <div class="box-body">
	            <div class="row">
	             	<div class="col-md-12">
	                    <div class="form-group">
	                    	<table class="table table-bordered">
	                    		<thead>
	                    			<tr>
	                    				<th>#</th>
	                    				<th>Kode Service</th>
	                    				<th>Deskripsi</th>
	                    				<th class="text-right">Biaya Service</th>
	                    			</tr>
	                    		</thead>
	                    		<tbody>
	                    			<?php 
	                    				$total = 0;
	                    				if($list!=false){
		                    				foreach ($list as $key => $row) {
		                    					?>
		                    						<tr>
					                    				<td><?php echo $key+1;?></td>
					                    				<td><?php echo $row->Kd_Service;?></td>
					                    				<td><?php echo $row->Deskripsi;?></td>
					                    				<td class="text-right"><?php echo number_format($row->Biaya_Service);?></td>
					                    			</tr>
		                    					<?php
		                    					$total += $row->Biaya_Service;
		                    				}
		                    			}
	                    			?>
	                    		</tbody>
	                    		<tfoot>
	                    			<tr>
	                    				<th colspan="3">Total</th>
	                    				<th class="text-right"><?php echo number_format($total);?></th>
	                    			</tr>
	                    		</tfoot>
	                    	</table>
	                    </div>
	                </div>
	            </div>
            </div>
        </div>
    </div> <!-- col -->
  </div><!-- row -->

</div>
<!-- /.content-wrapper-->
