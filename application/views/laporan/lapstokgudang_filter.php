<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 30px;">
    <h1 class="pull-left">
      <i class="fa fa-tasks"></i> Laporan Stok Gudang
    </h1>
  </section>

<!-- Main content --> 

  <section class="content">
  <!-- Main row -->
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">   
          <div class="box-header with-border">
                <form method="post" action="<?php echo base_url();?>laporan/lapstokgudang">
                    <div class="col-xs-3">
                        <select class="form-control" id="status" name="status">    
                            <option value="" >Pilih Status</option>                     
                            <option value="<?php echo set_value('status'); ?>" >Received</option>
                            <option value="<?php echo set_value('status'); ?>" >Sale to Customers</option>
                        </select>
                        <?php echo form_error('status'); ?>
                    </div>

                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Filter</button>
                    <!-- <a class="btn btn-success" href="<?php echo base_url();?>akunting/rugilaba_print"><i class="fa fa-print"></i> Print</a> -->
                </form>  
            <!-- <div class="pull-left">
                 <a href="<?php echo base_url();?>laporan/preview" class="btn btn-primary"><i class="fa fa-search"></i> Filter</a>                        
            </div> -->
          </div>
          <div class="box-body">
            <div class="row">     
              <div class="col-md-12">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>TIPE</th>
                            <th>WARNA</th>
                            <th>NO MESIN</th>
                            <th>NO RANGKA</th>
                            <th>STATUS</th>
                            <th>TGL INV</th>
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
        var status = $('#status').val()
        alert($('#status').val());
        //datatables
        table = $('#dataTable').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
             
            "ajax": {
                "url": "<?php echo base_url('laporan/filterstokgudang')?>",
                "type": "POST",
                "data": function ( data ) { 
                        // alert(data.status) ;
                        //alert(document.getElementById("status").value);          
                        data.status = $('#status').val();                    
                }
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