<footer class="main-footer hidden-print">
  <div class="pull-right hidden-xs">
    <b>Version</b> v1.1.0 
  </div>
  <a target="_blank" href="" rel="noopener">Rilexindo</a>
    project</a>
</footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- bootstrap datepicker -->
<script src="<?php echo base_url();?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Bootstrap slider -->
<script src="<?php echo base_url();?>assets/plugins/bootstrap-slider/bootstrap-slider.js"></script>

<!-- iCheck 1.0.1 -->
<script src="<?php echo base_url();?>assets/plugins/iCheck/icheck.min.js"></script>

<!-- Select2 -->
<script src="<?php echo base_url();?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>

<!-- DataTables -->
<script src="<?php echo base_url();?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/dist/js/adminlte.min.js"></script>

<!-- colorpicker -->
<script src='<?php echo base_url();?>assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js'></script>

<!-- notify -->
<script src="<?php echo base_url();?>assets/plugins/notify/notify.min.js"></script>

<!-- sweetAlert -->
<script src="<?php echo base_url();?>assets/plugins/sweetalert/sweetalert.min.js"></script>

<script src="<?php echo base_url();?>assets/bower_components/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<!-- Main JS -->
<script src="<?php echo base_url();?>assets/dist/js/main.js"></script>

<!-- INPUT MASK-->
<script src="<?php echo base_url();?>assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url();?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url();?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script>
function isNumber(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      alert("Harus berupa angka!");
      return false;
  }
  return true;
}

$('.select2').select2({width: '100%', dropdownParent: $('#modalForm')});
$('#optMerek').select2({placeholder: "Pilh Merek...", width: '100%'});
$('#kd_salesman').select2({placeholder: "Pilh Salesman...", width: '100%'});
$('#kd_leasing').select2({placeholder: "Pilh Leasing...", width: '100%'});
$('#nospk').select2({placeholder: "Pilh Spk...", width: '100%'});
$('#noso').select2({placeholder: "Pilh So...", width: '100%'});
$('#transaksi_category_id').select2({placeholder: "Pilh So...", width: '100%'});


// datetimepicker
$(".form_datetime").datetimepicker({
  format: 'yyyy-mm-dd hh:ii',
  autoclose: true
});

//Date picker
$('#datepicker').datepicker({
  autoclose: true,
  locale: 'no',
  format: 'yyyy-mm-dd',
})
$('#datepickerNow').datepicker({
  autoclose: true,
  locale: 'no',
  format: 'yyyy-mm-dd',
})
$('#datepickerNow').datepicker('setDate', 'today');
$('#datepicker').datepicker('setDate', 'today');
$('#datepicker2').datepicker('setDate', 'today');


$('#datepickeredit').datepicker({
  autoclose: false,
  locale: 'no',
  format: 'yyyy-mm-dd',
})


$('#txt_tanggal_ku').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
$('#txt_tanggal_bg').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })


//$('.tooltip').tooltip();
$("[rel='tooltip']").tooltip();

//dataTables
$('#dataTable1').DataTable({"bAutoWidth": false})
$('#dataTable2').DataTable({"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]})
$('#dataTableDashboard1').DataTable({
"order": [[ 0, "desc" ]],
"lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
"searching": false,
"bLengthChange": false
})
$('#dataTableDashboard2').DataTable({
"order": [[ 1, "desc" ]],
"lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
"searching": false,
"bLengthChange": false
})

</script>

<script>
    $('.hapus-data').on('click', function(e){
        e.preventDefault(); //cancel default action

        var href = $(this).attr('data-url');

        //pop up
        swal({
            title: "Anda yakin ingin menghapus data?",
            icon: "warning",
            buttons: ["Tidak", "Ya"],
            dangerMode: true,
        })
        .then((hapus) => {
          if (hapus) {
            //swal("Data sudah dihapus!", {
            //  icon: "success",
            //});
            window.location.href = href;
            //setTimeout(function(){ window.location.href = href; }, 500);
          }
          else {
          }
        });
    });

    function mask(textbox, e) {
      var charCode = (e.which) ? e.which : e.keyCode;
      if (charCode == 46 || charCode > 31&& (charCode < 48 || charCode > 57)) 
        {
          //alert("Only Numbers Allowed");
          return false;
        }
      else
        {
        return true;
        }
      }

    function formatRupiah(angka)
      {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split	= number_string.split(','),
        sisa 	= split[0].length % 3,
        rupiah 	= split[0].substr(0, sisa),
        ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
        return rupiah;
      }

    function convertToRupiah(angka)
      {
        var rupiah = '';		
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return rupiah.split('',rupiah.length-1).reverse().join('');
      }
      /**
      * Usage example:
      * alert(convertToRupiah(10000000)); -> "Rp. 10.000.000"
      */

   
    function convertToAngka(rupiah)
      {
      return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
      }
      /**
      * Usage example:
      * alert(convertToAngka("Rp 10.000.123")); -> 10000123
      */

    function PemisahTitik(objek) {
      separator = ".";
      a = objek.value;
      b = a.replace(/[^\d]/g,"");
      c = "";
      panjang = b.length; 
      j = 0; 
      for (i = panjang; i > 0; i--) {
      j = j + 1;
      if (((j % 3) == 1) && (j != 1)) {
      c = b.substr(i-1,1) + separator + c;
      } else {
      c = b.substr(i-1,1) + c;
      }
      }
      objek.value = c;
    }   

</script>

<div class="modal" id="ModalGue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class='fa fa-times-circle'></i></button>
						<h4 class="modal-title" id="ModalHeader"></h4>
					</div>
					<div class="modal-body" id="ModalContent"></div>
					<div class="modal-footer" id="ModalFooter"></div>
				</div>
			</div>
		</div>
		
<script>
$('#ModalGue').on('hide.bs.modal', function () {
    setTimeout(function(){ 
      $('#ModalHeader, #ModalContent, #ModalFooter').html('');
    }, 500);
});
</script>
    
<!-- custom js -->
<script src="<?php echo base_url();?>js/custom.js"></script>