<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header" style="padding-bottom: 40px;">
    <h1 class="pull-left">
      Tambah Data Service Kendaraan
    </h1>
    <div class="pull-right">
    <a href="<?php echo base_url('transaksi/servicekendaraan')?>" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border"><b>Input Service Kendaraan</b>
            </div>
            <div class="box-body">
                <form action="<?php echo base_url('transaksi/servicekendaraan/simpan_data')?>" method="post" class="form-horizontal">
                    <div class="form-group ">
                        <label class="col-md-3 control-label">No Mesin</label>
                        <div class="col-md-7 col-sm-12 required">
                            <select name="txt_nomesin" required class="form-control select2">
                                <option value="">- Pilih No Mesin -</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label">Tgl Service</label>
                        <div class="col-md-7 col-sm-12 required">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                <!-- <input type="text"  name="txt_tgl_service" class="form-control pull-right" id="datepicker" data-date-format="dd/mm/yyyy" required> -->
                                <input type="text" name="txt_tgl_service" placeholder="Pilih Tanggal" readonly required class="form_datetime form-control pull-right">
                            </div>
                        </div>
                    </div>               
                    <div class="form-group ">
                        <label for="dari" class="col-md-3 control-label">Keterangan</label>
                            <div class="col-md-7 col-sm-12 required">
                                 <input  type="text" class="form-control" name="txt_keterangan" required>
                            </div>
                    </div> 
                    <div class="form-group ">
                        <label for="dari" class="col-md-3 control-label">Total Harga</label>
                            <div class="col-md-3 col-sm-12 required">
                                 <input type="text" class="form-control" value="0" readonly name="txt_totalharga" required>
                            </div>
                    </div>  
                    
                    <?php 
                        $index = 0;
                    ?>
                    <table id="detailService" class="table table-bordered" style="width:100%; margin-bottom: 10px;"> 
                        <thead>
                            <tr>
                                <th class="col-md-2" style="text-align:center;">Kode Service</th>
                                <th class="col-md-3" style="text-align:center;">Deskripsi</th>
                                <th class="col-md-3" style="text-align:center;">Biaya Service</th>
                                <th class="col-md-1" colspan=2 style="text-align:center;">Aksi</th>                    
                            </tr>
                        </thead>
                        <tbody id="data_detail">
                            <?php /*
                            <tr id="row_<?php echo $index; ?>">
                                <td>
                                    <?php echo $list;?>
                                </td>
                                <td>
                                    <div>
                                        <input type="text" readonly class="form-control" name="deskripsi[]" >
                                    </div>
                                </td>                    
                                <td>
                                    <div>
                                        <input type="text" readonly class="form-control" name="cost[]">
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            */?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-right" style="font-weight: bold">Total</td>
                                <td class="text-right" style="font-weight: bold" id="total_service"> 0 </td>
                                <td style="float:right;">
                                    <button onclick="addRow()" type="button" class="btn btn-info btn-sm">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>   
                    <div class="box-footer text-right"> 
                        <button type="submit" name="btnSimpan" class="btn btn-success"><i class="fa fa-check icon-white"></i> Simpan</button>
                        <a class="btn btn-default" href="<?php echo base_url('transaksi/servicekendaraan/tambah')?>"><i class="fa fa-close"></i> Clear</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    var index_row = '<?php echo $index;?>';
    var total_service = 0;

    $(function(){
        $('.select2').select2({
            minimumInputLength: 1,
            allowClear: true,
            placeholder: 'Pilih No Mesin',
            ajax: {
                dataType: 'json',
                url: "<?php echo base_url('transaksi/servicekendaraan/getListKendaraan') ?>",
                delay: 400,
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                },
            }
        });

        addRow();
    });

    function addRow() {
        //boleh tambah tampilan loading form

        var request = $.ajax({
            url: '<?php echo base_url('transaksi/servicekendaraan/getJasaService') ?>',
            method: "POST",
            data: { row: index_row},
            dataType: "json"
        });

        request.done(function( msg ) {
            $('#detailService').append(msg.form);
            onchangeValue(index_row); // redeclare
            index_row++;
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }

    function deleteRow(r){
        var harga_service = removeThousand($('input[name="cost['+r+']"]').val());
        
        if(harga_service != 0){
            total_service -= parseInt(harga_service);
            if(isNaN(total_service)){
                total_service = 0;
            }
            $('#total_service').html(thousandFormat(total_service));
            $('input[name="txt_totalharga"]').val(thousandFormat(total_service));
        }
        
        $('#row_'+r).remove();
    }

    function onchangeValue(index){
        $('select[name="kd_service['+index+']"]').change(function(e){
            var harga_service = removeThousand($('input[name="cost['+index+']"]').val());
            if(harga_service == ''){
                harga_service = 0 ;
            }
            if(isNaN(total_service)){
                total_service = 0;
            }
            total_service -= parseInt(harga_service);

            $('#total_service').html(thousandFormat(total_service));
            $('input[name="txt_totalharga"]').val(thousandFormat(total_service));

            var request = $.ajax({
                url: '<?php echo base_url('transaksi/servicekendaraan/getHargaService') ?>',
                method: "POST",
                data: { serviceID: e.target.value},
                dataType: "json"
            });

            request.done(function( msg ) {
                $('input[name="deskripsi['+index+']"]').val(thousandFormat(msg.deskripsi));
                $('input[name="cost['+index+']"]').val(thousandFormat(msg.harga));
                total_service += parseInt(msg.harga);
                $('#total_service').html(thousandFormat(total_service));
                $('input[name="txt_totalharga"]').val(thousandFormat(total_service));
            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });
        });
    }

    $("form").submit(function(e){
        e.preventDefault();
        var status_input = true;
        var arr_kd_service = [];
        var arr_cost = [];

        $(".detail_kd_service" ).each(function( index, e) {
            index = $( e ).attr( "index" );
            var is_checked = $('select[name="kd_service['+index+']"] option:selected').val();
            var is_zero = $('input[name="cost['+index+']"]').val();
            arr_kd_service.push(is_checked);
            arr_cost.push(is_zero);

            if (is_checked == -1){
                status_input = false;
            }
        });

        if(status_input == false){
            alert('Silahkan pilih kode service terlebih dahulu!');
        }else if(total_service == 0){
            alert('Detail service tidak boleh kosong, Silahkan diisi terlebih dahulu!');
        }else if(checkIfArrayIsUnique(arr_kd_service)){
            alert('Ada Kode Service yang sama, Silahkan cek kembali!');
        }else if(checkIfArrayIsZero(arr_cost)){
            alert('Ada Kode Service yang biayanya 0, Silahkan isi biaya service terlebih dahulu!');
        }else{
            $(this).unbind('submit').submit();    
        }
    });
</script>