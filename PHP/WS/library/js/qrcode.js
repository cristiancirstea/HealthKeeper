jQuery(document).ready(function() {
    var qrPathPrefix = 'WS/qrcodes/';

    // Pregătesc cele două câmpuri pentru selectarea utilizatorilor înregistrați
    $('#lastName').select2({
        minimumInputLength: 2,
        ajax: {
            url: 'WS/ajax/getUserIdFromName.php',
            dataType: "json",
            data: function(term) {
                return {lastName: term};
            },
            results: function(data) {
                return {results: data};
            }
        },
        formatResult: function(result) {
            return result.text;
        }
    });  

    $('#firstName').select2({
        minimumInputLength: 2,
        ajax: {
            url: 'WS/ajax/getUserIdFromName.php',
            dataType: "json",
            data: function(term) {
                return {lastName: $('#lastName').select2('data').text,
                        firstName: term};
            },
            results: function(data) {
                return {results: data};
            }
        },
        formatResult: function(result) {
            $('#userId').val(result.userId);
            result.text = result.firstName;
            return result.text;
        }
    });

    // La fiecare modificare a câmpurilor se verifică validitatea lor
    $('.form-control').on('blur', function() {
        $('#form-info').html("");
        validateInput();
    });

    // Când este apăsat butonul de generare, este apelată funcția care generează
    // imaginea codului QR.
    $('#generate-qr').on('click', function() {
        if($('#generate-qr').hasClass('btn-success')) {
            $.ajax({
                type: 'POST',
                url: 'WS/ajax/generateQRCode.php',
                data: { userId:         $('#userId').val(), 
                        medicineName:   $('#medicineName').val(),
                        activeSubstance:$('#activeSubstance').val(),
                        hStart:         $('#hStart').val(),
                        period:         $('#period').val(),
                        span:           $('#span').val(),
                        importance:     $('#importance').val()
                      }
            })
            .done(function(data) {
                if(data){
                    console.log(data);
                    data = JSON.parse(data);
                    // Mesajul inițial este înlocuit cu codul QR
                    $("#QR").attr('src', qrPathPrefix + data.qrPath).removeClass('hidden');
                    $('#qr-placeholder').addClass('hidden');
                } else {
                    $('#form-info').html("Ceva a fost în neregulă");
                }
            });
        } else {
            $('#form-info').html("Nu ai completat toate câmpurile");
        }
    });
});

/**
 * Validează datele adăugate în câmpuri, verificând să nu fie goale
 */
function validateInput() {
    var userId = $('#userId').val(),
        medicineName = $('#medicineName').val(),
        activeSubstance = $('#activeSubstance').val(),
        hStart = $('#hStart').val(),
        period = $('#period').val(),
        span = $('#span').val(),
        importance = $('#importance').val();

    if(userId && medicineName && hStart && period && span && importance) {
        $('#generate-qr').removeClass('btn-danger').addClass('btn-success');
    } else {
        $('#generate-qr').removeClass('btn-success').addClass('btn-danger');
    }
}
