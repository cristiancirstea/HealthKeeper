jQuery(document).ready(function() {
    var qrPathPrefix = 'WS/qrcodes/';

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

    $('.form-control').on('blur', function() {
        $('#form-info').html("");
        validateInput();
    });

    $('#generate-qr').on('click', function() {
        if($('#generate-qr').hasClass('btn-success')) {
            $.ajax({
                type: 'POST',
                url: 'WS/ajax/generateqrcode.php',
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
