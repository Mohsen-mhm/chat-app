import './bootstrap';

$('#Send').keypress(function (e) {
    if (e.which == 13) {
        var text = $('#Send').val();
        $.ajax({
            url: "/",
            method: "post",
            data: {
                message: text
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (response) {
            console.log(response);
            if (response == true) {
                $('#Send').val('');
            }
        }).fail(function (r) {
            console.log(r);
        });
    }
});
