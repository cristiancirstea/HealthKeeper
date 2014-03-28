jQuery(document).ready(function() {
    var qrPathPrefix = 'WS/qrcodes/';

    $('.form-control').on('blur', function() {
        $('#form-info').html("");
        validateInput();
    });

    $('#generate-qr').on('click', function() {
        if($('#generate-qr').hasClass('btn-success')) {
            $.ajax({
                type: 'POST',
                url: 'WS/ajax/generateqrcode.php',
                data: { medicineName:   $('#medicineName').val(),
                        activeSubstance:$('#activeSubstance').val(),
                        hStart :        $('#hStart').val(),
                        period :        $('#period').val(),
                        span :          $('#span').val(),
                        importance:     $('#importance').val()
                      }
            })
            .done(function(data) {
                if(data){
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
    var medicineName = $('#medicineName').val(),
        activeSubstance = $('#activeSubstance').val(),
        hStart = $('#hStart').val(),
        period = $('#period').val(),
        span = $('#span').val(),
        importance = $('#importance').val();

    if(medicineName && hStart && period && span && importance) {
        $('#generate-qr').removeClass('btn-danger').addClass('btn-success');
    } else {
        $('#generate-qr').removeClass('btn-success').addClass('btn-danger');
    }
}
