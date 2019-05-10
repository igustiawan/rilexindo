<?php echo form_open('master/stokunit/ubahharga/'.$detail->No_Mesin, array('id' => 'FormEditUser')); ?>
<div class='form-group'>
	<label>No Mesin</label>
    <?php 
        echo form_input(array(
            'name' => 'no_mesin',
            'class' => 'form-control',
            'disabled' => 'true',
            'value' => $detail->No_Mesin
	));
	?>
</div>

<div class='form-group'>
	<label>Harga Jual</label>
    <?php 
        echo form_input(array(
            'name' => 'hrg_jual',
            'class' => 'form-control',
            'value' => $detail->Hrg_Jual
	));
    ?>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditUser'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
    $('#ModalFooter').html(Tombol);

    $('#SimpanEditUser').click(function(){
		$.ajax({
			url: $('#FormEditUser').attr('action'),
			type: "POST",
			cache: false,
			data: $('#FormEditUser').serialize(),
			dataType:'json',
			success: function(json){
				if(json.status == 1){ 
					$('#ResponseInput').html(json.pesan);
					setTimeout(function(){ 
				   		$('#ResponseInput').html('');
				    }, 3000);
					$('#dataTable').DataTable().ajax.reload( null, false );
				}
				else {
					$('#ResponseInput').html(json.pesan);
				}
			}
		});
	});

});
</script>
