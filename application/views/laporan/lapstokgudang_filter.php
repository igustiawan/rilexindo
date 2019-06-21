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
              <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" >Custom Filter : </h3>
                </div>
                <div class="panel-body">
                  <form id="form-filter" class="form-horizontal">
                      <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label">Status</label>
                          <div class="col-sm-4">
                            <select class="form-control" id="status" name="status">    
                            <option value="" >Pilih Status</option>                     
                            <option value="Received" >Received</option>
                            <option value="Sale to Customers" >Sale to Customers</option>
                            </select>
                          </div>
                      </div>
                      <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                          <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                          <button type="button" id="btn-download" class="btn btn-default">Download</button>
                        </div>
                      </div>
                  </form>
                </div>
              </div>            
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
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </section>
</div>

<script>
 var table;
    $(document).ready(function() {
        table = $('#dataTable').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
             
            "ajax": {
                "url": "<?php echo base_url('laporan/filterstokgudang')?>",
                "type": "POST",
                "data": function ( data ) {          
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
        $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
    });
    });
</script>