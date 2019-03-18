<style>
    .pilih_cust:hover{
        cursor: pointer;
    }

    #daftar-autocomplete { 
        list-style:none; 
        margin:0; 
        padding:0; 
        width:100%;
    }

    #daftar-autocomplete li {
        padding: 5px 10px 5px 10px; 
        background:#FAFAFA; 
        border-bottom:#ddd 1px solid;
    }

    #daftar-autocomplete li:hover,
    #daftar-autocomplete li.autocomplete_active { 
        background:#2a84ae; 
        color:#fff; 
        cursor: pointer;
    }

    #hasil_pencarian{ 
        padding: 0px; 
        display: none; 
        position: absolute; 
        max-height: 350px;
        overflow: auto;
        border:1px solid #ddd;
        z-index: 1;
    }
</style>
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 40px;">
    <h1 class="pull-left">
      Tambah Pembayaran
    </h1>
    <div class="pull-right">
        <a href="<?php echo base_url('transaksi/pembayaran')?>" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </section>

  <section class="content">
        <!-- Default box -->
        <div class="form-horizontal">          
                <div class="box">
                    <div class="box-header with-border">
                </div>
                <div class="box-body"> 
                    <?php if (validation_errors()) : ?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php endif; ?>
                    <div class="row">         
                        <div class="form-group ">                           
                            <label for="dari" class="col-md-2 control-label">Nama Customer</label>
                            <div class="col-md-4 col-sm-12 ">                                                                 
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalCust">Browse</button>
                                        </div>
                                        <input readonly type="text" maxlength="30" class="form-control" id = "txt_cust" name="txt_cust" > 
                                        <input type="hidden" readonly name="txt_kd_cust" class="form-control pull-right" id="txt_kd_cust" >    
                                    </div>
                            </div>       
                                <label for="dari" class="col-md-2 control-label">Total Pembayaran</label>
                                <div class="col-md-3 col-sm-12 ">
                                     <input type="text" readonly maxlength="30" class="form-control" id="txt_total_bayar" name="txt_total_bayar" >                 
                                </div>                           
                        </div>                                                       
                        <div class="form-group">
                            <label for="dari" class="col-md-2 control-label">Tgl. Transaksi</label>
                            <div class="col-md-3 col-sm-12 ">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" readonly name="txt_tgl_transaksi" class="form-control pull-right" id="txt_tgl_transaksi" value="<?php echo date('Y-m-d')?>" >                    
                                </div>
                            </div>
                            <label for="dari" class="col-md-3 control-label">Sisa Piutang</label>
                            <div class="col-md-3 col-sm-12 ">
                                <input type="text" readonly maxlength="30" class="form-control" id="txt_sisa_piutang" name="txt_sisa_piutang" >                        
                            </div>
                        </div> 
                        <div class="form-group">  
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="content-process">
                                    <table>
                                        <thead>
                                            <tr>
                                                <td>Deskripsi</td>
                                                <td>Nominal</td>
                                                <td>Tanggal KU/BG</td>
                                                <td>No BG/Rekening</td>
                                                <td>Nama Bank</td>                                           
                                            </tr>
                                        </thead>                                    
                                        <tbody>
                                        <tr>                                        
                                            <td><input readonly type="text" maxlength="30" class="form-control" value="Tunai" ></td>
                                            <td><input type="text" maxlength="30" class="form-control"  onkeyup="change_harga()" onchange="PemisahTitik(this)" onkeypress="return mask(this,event);" id="txt_nominal_tunai" name="txt_nominal_tunai" ></td>
                                            <td><input readonly class="form-control" type="text"></td>
                                            <td><input readonly class="form-control" type="text"></td>
                                            <td><input readonly class="form-control" type="text"></td>
                                        </tr>
                                        <tr>                                        
                                            <td><input readonly type="text" maxlength="30" class="form-control" value="Transfer (KU)" ></td>
                                            <td><input type="text" maxlength="30" class="form-control"   onkeyup="change_harga()" onchange="PemisahTitik(this)" onkeypress="return mask(this,event);" id="txt_nominal_ku" name="txt_nominal_ku" ></td>
                                            <td><input type="text" class="form-control" name="txt_tanggal_ku" id="txt_tanggal_ku" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask></td>
                                            <td>
                                                <select class="form-control" name="rekening" id="rekening">
                                                <option></option>
                                                <?php
                                                if($d_no_rekening){
                                                foreach($d_no_rekening as $d){
                                                echo "<option value='$d->No_Rek'>$d->No_Rek</option>";
                                                }
                                                }
                                                ?>
                                                </select>                               
                                            </td>
                                            <td><input id="txt_nama_bank_ku" name="txt_nama_bank_ku"  readonly class="form-control" type="text"></td>
                                        </tr>
                                        <tr>                                        
                                            <td><input readonly type="text" maxlength="30" class="form-control" value="Bg/Cek"></td>
                                            <td><input type="text" maxlength="30" class="form-control"  onkeyup="change_harga()" onchange="PemisahTitik(this)" onkeypress="return mask(this,event);" id="txt_nominal_bg" name="txt_nominal_bg" ></td>
                                            <td><input type="text" class="form-control" name="txt_tanggal_bg" id="txt_tanggal_bg" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask></td>
                                            <td><input type="text" maxlength="30" class="form-control" id="txt_no_bg" name="txt_no_bg" ></td>
                                            <td><input type="text" maxlength="30" class="form-control" id="txt_nama_bank_bg" name="txt_nama_bank_bg" ></td>
                                        </tr>
                                        <tr>                                        
                                            <td><input readonly type="text" maxlength="30" class="form-control" value="Total"></td>
                                            <td><input readonly type="text" maxlength="30" class="form-control" id="txt_total" name="txt_total" ></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                        </div> 
                        <div class="form-group"> 
                            <div class="col-md-10 col-md-offset-1">
                                <textarea name='txt_keterangan' id='txt_keterangan' class='form-control' rows='2' placeholder="Catatan Transaksi (Jika Ada)" style='resize: vertical; width:83%;'></textarea>
                            </div>	
                        </div>
                        <div class="form-group"> 
                             <div class="col-md-10 col-md-offset-1">
                                    <div class="content-process">
                                        <font size="2">
                                        <table class='table table-bordered' id='TabelTransaksi'>
                                            <thead>
                                                <tr>
                                                    <th style='width:17px;'>#</th>
                                                    <th style='width:140px;'>No.SO</td>
                                                    <th style='width:37px;'>No.Ref</td>
                                                    <th style='width:37px;'>Tgl. Piutang</td>
                                                    <th style='width:37px;'>Tgl. Jtp</td>
                                                    <th style='width:37px;'>Nom. Piutang</td>
                                                    <th style='width:37px;'>Sisa Piutang</td>
                                                    <th style='width:100px;'>Jumlah Bayar</td>
                                                    <th style='width:10px;'></th>
                                                </tr>
                                            </thead>
                                        <tbody></tbody>
                                        </table>
                                        </font>
                                        <button id='BarisBaru' class='btn btn-default pull-left'><i class='fa fa-plus fa-fw'></i> Baris Baru</button>
                                    </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-md-3 col-md-offset-4">
                                <a class="btn btn-default" href="<?php echo base_url('transaksi/pembayaran/tambah')?>"><i class="fa fa-close"></i> Batal</a>
                                <button type='button' class='btn btn-default' id='Simpann'>
								<i class="fa fa-check icon-white"></i> Simpan			
										</button>
                            </div>
                        </div>
                    </div>          
                </div>               
         </div>
    </section>
</div>
<div class="modal" id="modalCust" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:770px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">List Customer</h4>
            </div>
            <div class="modal-body">
                    <table style="width:100%" id="tblcust" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode Cust</th>
                                <th>Nama Cust</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>                                
                    </table>  
            </div>            
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Add New</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#rekening').change(function(){
			$.ajax({
                url:"<?php echo base_url('transaksi/pembayaran/get_nama_bank')?>",
				type: "POST",
				cache: false,
				data: "rekening="+$(this).val(),
				dataType:'json',
				success: function(json){
                    $('#txt_nama_bank_ku').val(json.Nama_Bank);
				}
			});
	});

    var table_cust;
    $(document).ready(function() {
        //datatables
        table_cust = $('#tblcust').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            
            "ajax": {
                "url": "<?php echo base_url('transaksi/spk/get_data_list_cust')?>",
                "type": "POST"
            },          
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            $(nRow).addClass('pilih_cust');
            return nRow;
            }
        }); 
    });

    $(document).on('click', '.pilih_cust', function (e) {
        $(this).toggleClass('selected');
        var data_ = table_cust.row($(this)).data(); 
            document.getElementById("txt_kd_cust").value =data_[0];    
            document.getElementById("txt_cust").value =data_[1];
             $('#modalCust').modal('hide');
    });
    
    function change_harga(){
        var nominal_tunai = $("#txt_nominal_tunai").val()==''?0:convertToAngka($("#txt_nominal_tunai").val());  
        var nominal_ku = $("#txt_nominal_ku").val()==''?0:convertToAngka($("#txt_nominal_ku").val()); 
        var nominal_bg = $("#txt_nominal_bg").val()==''?0:convertToAngka($("#txt_nominal_bg").val());   
        
        var total = parseInt(nominal_tunai)+parseInt(nominal_ku)+parseInt(nominal_bg);
        $("#txt_total").val(convertToRupiah(total));  
    }
   
    $(document).ready(function(){
        for(B=1; B<=1; B++){
            BarisBaru();
        }

        $('#BarisBaru').click(function(){
            BarisBaru();
        });
    });

    function BarisBaru()
    {
        var Nomor = $('#TabelTransaksi tbody tr').length + 1;
        var Baris = "<tr>";
            Baris += "<td>"+Nomor+"</td>";
            Baris += "<td>";
                Baris += "<input type='text' class='form-control' name='no_so[]' id='pencarian_kode' placeholder='Ketik No. SO'>";
                Baris += "<div id='hasil_pencarian'></div>";
            Baris += "</td>";
            Baris += "<td>";
                Baris += "<input type='hidden' name='no_ref[]'>";
                Baris += "<span></span>";
		    Baris += "</td>";  
            Baris += "<td>";
                Baris += "<input type='hidden' name='tgl_ref[]'>";
                Baris += "<span></span>";
		    Baris += "</td>";    
            Baris += "<td>";
                Baris += "<input type='hidden' name='tgl_jtp[]'>";
                Baris += "<span></span>";
		    Baris += "</td>";   
            Baris += "<td></td>";
            Baris += "<td>";
                Baris += "<input type='hidden' name='sisa_piutang[]'>";
                Baris += "<span></span>";
		    Baris += "</td>"; 
            Baris += "<td><input type='text' class='form-control' id='jml_bayar' name='jml_bayar[]'  onkeypress='return mask(this,event);'  disabled></td>";
            Baris += "<td><button class='btn btn-default' id='HapusBaris'><i class='fa fa-times' style='color:red;'></i></button></td>";
            Baris += "</tr>";

        $('#TabelTransaksi tbody').append(Baris);

        $('#TabelTransaksi tbody tr').each(function(){
            $(this).find('td:nth-child(2) input').focus();
        });
        HitungTotalBayar();
        HitungSisaPiutang();
    }
  
    $(document).on('click', '#HapusBaris', function(e){
	e.preventDefault();
	$(this).parent().parent().remove();

	var Nomor = 1;
	$('#TabelTransaksi tbody tr').each(function(){
		$(this).find('td:nth-child(1)').html(Nomor);
		Nomor++;
	});
    HitungTotalBayar();
    HitungSisaPiutang();
});

function AutoCompleteGue(Lebar, KataKunci, Indexnya)
{
	$('div#hasil_pencarian').hide();
	var Lebar = Lebar + 25;
	var Registered = '';
    var kdcust = $("#txt_kd_cust").val();

	$('#TabelTransaksi tbody tr').each(function(){
		if(Indexnya !== $(this).index())
		{
			if($(this).find('td:nth-child(2) input').val() !== '')
			{
				Registered += $(this).find('td:nth-child(2) input').val() + ',';
			}
		}
	});

	if(Registered !== ''){
		Registered = Registered.replace(/,\s*$/,"");
	}

	$.ajax({
        url:"<?php echo base_url('transaksi/pembayaran/ajax_kode')?>",
		type: "POST",
		cache: false,
		data:'keyword=' + KataKunci + '&registered=' + Registered + '&kdcust=' + kdcust,
		dataType:'json',
		success: function(json){
			if(json.status == 1)
			{
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').css({ 'width' : Lebar+'px' });
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html(json.datanya);
			}
			if(json.status == 0)
			{
                $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input').val('');
                $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3) span').html('');
                $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html('');
                $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) span').html('');
                $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6)').html('');
                // $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7)').html('');
                $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7) span').html('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').prop('disabled', true).val('');			
			}
		}
	});
    HitungTotalBayar();
    HitungSisaPiutang();
}

$(document).on('keyup', '#pencarian_kode', function(e){
    if($(this).val() !== '')
	{
        AutoCompleteGue($(this).width(), $(this).val(), $(this).parent().parent().index());
    }else
    {
        $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian').hide();
    }
    HitungTotalBayar();
    HitungSisaPiutang();
});

$(document).on('click', '#daftar-autocomplete li', function(){
	$(this).parent().parent().parent().find('input').val($(this).find('span#noso').html());
	
	var Indexnya = $(this).parent().parent().parent().parent().index();
	var noref = $(this).find('span#noref').html();
	var tglpiutang = $(this).find('span#tglpiutang').html();
    var tgljtp = $(this).find('span#tgljtp').html();
    var Nompiutang = $(this).find('span#nompiutang').html();
    var Sisapiutang = $(this).find('span#sisapiutang').html();
    var Noref = $(this).find('span#noref').html();

   

	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3) input').val(Noref);
    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3) span').html(Noref);
    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(tglpiutang);
    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(tglpiutang);
    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').val(tgljtp);
    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) span').html(tgljtp);
    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6)').html(to_rupiah(Nompiutang));
    // $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7)').html(to_rupiah(Sisapiutang));
    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7) input').val((Sisapiutang));
    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7) span').html(to_rupiah(Sisapiutang));
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').removeAttr('disabled').val((Sisapiutang));

	var IndexIni = Indexnya + 1;
	var TotalIndex = $('#TabelTransaksi tbody tr').length;
	if(IndexIni == TotalIndex){
		BarisBaru();
		$('html, body').animate({ scrollTop: $(document).height() }, 0);
	}
	else {
		$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').focus();
	}
    HitungTotalBayar();
    HitungSisaPiutang();
});

function to_rupiah(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return rev2.split('').reverse().join('');
}

$(document).on('click', '#Simpann', function(){
	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').addClass('modal-sm');
	$('#ModalHeader').html('Konfirmasi');
	$('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
	$('#ModalFooter').html("<button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button><button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button>");
	$('#ModalGue').modal('show');

	setTimeout(function(){ 
   		$('button#SimpanTransaksi').focus();
    }, 500);
});

$(document).on('click', 'button#SimpanTransaksi', function(){
	SimpanTransaksi();
});

function SimpanTransaksi()
{
    var FormData = "tgltransaksi="+encodeURI($('#txt_tgl_transaksi').val());
    FormData += "&sisapiutang="+$('#txt_sisa_piutang').val();
    FormData += "&" + $('#TabelTransaksi tbody input').serialize();
    FormData += "&nobg="+$('#txt_no_bg').val();
    FormData += "&norek="+$('#rekening').val();
    FormData += "&tglbg="+$('#txt_tanggal_bg').val();
    FormData += "&bankbg="+$('#txt_nama_bank_bg').val();
    FormData += "&bankku="+$('#txt_nama_bank_ku').val();
    FormData += "&tglku="+$('#txt_tanggal_ku').val();
    FormData += "&nomtunai="+$('#txt_nominal_tunai').val();
    FormData += "&nombg="+$('#txt_nominal_bg').val();
    FormData += "&nomku="+$('#txt_nominal_ku').val();
    FormData += "&total="+$('#txt_total').val();
    FormData += "&totalbayar="+encodeURI($('#txt_total_bayar').val());
    FormData += "&keterangan="+$('#txt_keterangan').val();
    FormData += "&kd_cust="+$('#txt_kd_cust').val();


    $.ajax({
        url:"<?php echo base_url('transaksi/pembayaran/simpan_pembayaran')?>",
		type: "POST",
		cache: false,
		data: FormData,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{       
				alert(data.pesan);
				window.location.href="<?php echo base_url('transaksi/pembayaran'); ?>";
			}
			else 
			{    
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
				$('#ModalGue').modal('show');
			}	
		}
	});
}

$(document).on('keyup', '#jml_bayar', function(){
	var Indexnya = $(this).parent().parent().index();
	var Harga = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val();
   
    var SubTotal = parseInt(Harga);
    if(SubTotal > 0){
        var SubTotalVal = SubTotal;
        SubTotal = to_rupiah(SubTotal);
    } else {
        SubTotal = '';
        var SubTotalVal = 0;
    }

    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val(SubTotalVal);
    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) span').html(SubTotal);
    HitungTotalBayar();
    HitungSisaPiutang();
});

function HitungTotalBayar()
{
	var Total = 0;
	$('#TabelTransaksi tbody tr').each(function(){
		if($(this).find('td:nth-child(8) input').val() > 0)
		{
			var SubTotal = $(this).find('td:nth-child(8) input').val();
			Total = parseInt(Total) + parseInt(SubTotal);
		}
	});
 
    $('#txt_total_bayar').val(to_rupiah(Total));
}


function HitungSisaPiutang()
{
	var Total = 0;
	$('#TabelTransaksi tbody tr').each(function(){
		if($(this).find('td:nth-child(7) input').val() > 0)
		{
			var SubTotal = $(this).find('td:nth-child(7) input').val();
			Total = parseInt(Total) + parseInt(SubTotal);
		}
	});
  
    $('#txt_sisa_piutang').val(to_rupiah(Total));
}
</script>
