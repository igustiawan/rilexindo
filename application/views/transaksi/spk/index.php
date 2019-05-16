<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 30px;">
    <h1 class="pull-left">
      <i class="fa fa-tasks"></i> Surat Pesanan Kendaraan (SPK)
    </h1>

   <div class="pull-right">
     <div class="col-xs-12">
        <button class="btn btn-primary pull-right"  type="button" id="btn-reload"><i class="fa fa-refresh"></i> Reload</button>
  
        <a  style="margin-right: 5px;" href="<?php echo base_url('transaksi/spk/tambah')?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> INPUT SPK</a>
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
    $(document).ready(function (){    
        $('#btn-reload').on('click', function(){
            table.ajax.reload();
        });
    });

    $(document).on('click', '#ProsesSpk', function(e){
      e.preventDefault();
      var Link = $(this).attr('href');
      var Check = "<input type='hidden' value = "+$(this).parent().parent().find('td:nth-child(4)').html()+" name='no_mesin'  id='no_mesin'>";
      $('.modal-dialog').removeClass('modal-lg');
      $('.modal-dialog').addClass('modal-sm');
      $('#ModalHeader').html('Konfirmasi');
      $('#ModalContent').html('Anda yakin mau Proses SPK berikut <br /><b>'+$(this).parent().parent().find('td:nth-child(1)').html()+'</b> ?'+ Check);
      $('#ModalFooter').html("<button type='button' class='btn btn-primary' id='YesSpk' data-url='"+Link+"'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
      $('#ModalGue').modal('show');
    });

  $(document).on('click', '#YesSpk', function(e){
      e.preventDefault();
      $('#ModalGue').modal('hide');
      var FormData = "no_mesin="+encodeURI($('#no_mesin').val());
      $.ajax({
        url: $(this).data('url'),
        type: "POST",
        cache: false,
        data: FormData,
        dataType:'json',
        success: function(data){
          alert(data.pesan);
          $('#dataTable').DataTable().ajax.reload( null, false );
        }
      });
	});

  $(document).on('click', '#BatalSpk', function(e){
      e.preventDefault();
      var Link = $(this).attr('href');
      $('.modal-dialog').removeClass('modal-lg');
      $('.modal-dialog').addClass('modal-sm');
      $('#ModalHeader').html('Konfirmasi');
      $('#ModalContent').html('Anda yakin mau batal SPK berikut <br /><b>'+$(this).parent().parent().find('td:nth-child(1)').html()+'</b> ?');
      $('#ModalFooter').html("<button type='button' class='btn btn-primary' id='YesBatalSpk' data-url='"+Link+"'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
      $('#ModalGue').modal('show');
	});

  $(document).on('click', '#YesBatalSpk', function(e){
      e.preventDefault();
      $('#ModalGue').modal('hide');

      $.ajax({
        url: $(this).data('url'),
        type: "POST",
        cache: false,
        dataType:'json',
        success: function(data){
          alert(data.pesan);
          $('#dataTable').DataTable().ajax.reload( null, false );
        }
      });
	});

</script>