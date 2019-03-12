function thousandFormat(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function removeThousand(num){
    return num.replace(/,/g, '')
}

function checkIfArrayIsUnique(myArray){
    for (var i = 0; i < myArray.length; i++){
        for (var j = 0; j < myArray.length; j++){
            if (i != j){
                if (myArray[i] == myArray[j]){
                    return true; // means there are duplicate values
                }
            }
        }
    }
    return false; // means there are no duplicate values.
}

function checkIfArrayIsZero(myArray){
    for (var i = 0; i < myArray.length; i++){
        if (myArray[i] == 0 || myArray[i] == '0'){
            return true; // means there are 0 values
        }
    }
    return false; // means there are no 0 values.
}
