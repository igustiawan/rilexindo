$("#transaksi_category_id").on("change",function(e){
     e.preventDefault();
    var url =  'check_so_piutang/' + this.value;    
    $.get(url, function(data, status){
        if(status == 'success'){           
            var arr = $.parseJSON(data);
            $.each(arr, function(key,value){               
                $('[name="no_reff"]').val(value.No_Ref);
                $('[name="tgl_piutang"]').val(value.Tgl_So);
                $('[name="tgl_jtp"]').val(value.Tgl_Jtp);
                $('[name="nom_piutang"]').val(value.Nilai_Piutang);             
            });
        }
    });
});

 $(document).ready(function(){
    var counter = 0;
    $("input.tr_clone_add").on('click', function() {   
            alert("A");

//         //  $(this).val('Delete');
//         // // $(this).attr('class','del');
//         // var appendTxt = 
//         // '<tr>' +
//         // '<td><input type="text" name="input_box_one[]" />' +
//         // '</td> <td><input type="text" name="input_box_two[]" />' +
//         // '</td> <td><input type="button" class="tr_clone_add" value="Add More" /></td>' +
//         // '</tr>';
//         // $("tr:last").after(appendTxt);	

//         var regex = /^(.*)(\d)+$/i;
//         var cindex = 1;
        
//         var $tr    = $(this).closest('.tr_clone');
//         var $clone = $tr.clone(true);
//         cindex++;
//         $clone.find(':text').val('');
//         $clone.attr('id', 'id'+(cindex) ); //update row id if required
//         //update ids of elements in row
//         $clone.find("*").each(function() {
//             var id = this.id || "";
//             var match = id.match(regex) || [];
//             if (match.length == 3) {
//                 this.id = match[1] + (cindex);
//             }
//         });
//         $tr.after($clone);
    });    
});

// function addToHiddenField(addColumn,hiddenField) {
//     var columnValue = $(addColumn).text();
//     $("#"+hiddenField).val(columnValue);
// }

// $(document).ready(function(){
//     $("#tambah-barang").on("click",function(e){
//     alert("A");

//         var nominal = $("#txt_nominal").val();
//         var tgl_bg = $("#datepicker").val();
//         var no_bg = $("#txt_no_bg").val();
//         var nama_bank = $("#txt_nama_bank").val();

//         if(nominal !== "" && tgl_bg !== "" && no_bg !== "" !== "" && nama_bank !== ""){
//             var display = '<tr>' +
//                         '<td>'+ nominal +'</td>' +
//                         '<td>'+ tgl_bg +'</td>' +
//                         '<td>'+ no_bg +'</td>' +
//                         '<td>'+ nama_bank +'</td>' +
//                         '<td><button type="button" class="deletebtn" title="Remove row">X</button></td>' +
//                         '</tr>';                       
//             $("#transaksi-item tr:last").after(display);
//             $("#transaksi-item").find("input[type=text], input[type=number]").val("0");
//         }else{
//             alert("Silahkan isi semua box");
//         }
       
//     });
    
// });

// $(document).on('click', 'button.deletebtn', function () {
//     $(this).closest('tr').remove();
//     return false;
// });