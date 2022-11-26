import './bootstrap';

const errorEl = $('#showErr')
const sendEl = $('#Send')
sendEl.keypress(function (e) {
    if (e.which === 13) {
        var text = sendEl.val();
        $.ajax({
            url: "/saveMessage",
            method: "post",
            data: {
                message: text
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (response) {
            if (response.status === 200) {
                sendEl.val('');
                if (!errorEl.hasClass('d-none'))
                    errorEl.addClass('d-none')
            } else {
                errorEl.text("Couldn't send a message, Server Error...!");
                errorEl.removeClass('d-none')
            }
        }).fail(function (r) {
            console.error(r.responseJSON.message);
        });
    }
});
