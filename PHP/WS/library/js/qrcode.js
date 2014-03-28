jQuery(document).ready(function() {
    $('.form-control').on('blur', function() {
        validateInput();
    });

    $('#generate-qr').on('click', function() {
        $.ajax({
            type: 'POST',
            url: '../ajax/generateqrcode.php',
            data: { medicineName: $('#medicineName').val(),
                    hStart :      $('#hStart').val(),
                    period :      $('#period').val(),
                    span :        $('#span').val(),
                    importance:   $('#importance').val()
                  }
        })
        .done(function(data) {
            if(data){
                data = JSON.parse(data);
                console.log(data.qrPath);
            } else {
                console.log('Nasol');
            }
        });
    });
});

function validateInput() {
    var medicineName = $('#medicineName').val(),
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
