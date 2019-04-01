$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//customer  signup validation
if ($('#register').length) {
    $('#register').validate({// initialize the plugin
        rules: {
            company_name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            authrize_name: {
                required: true
            },
            website: {
                required: true
            },
            password: {
                required: true,
                minlength: 6
            },
            contact_number: {
                required: true,
                digits: true,
                minlength: 7
            }
        },
        submitHandler: function (form) {
            $.ajax({
                type: 'POST',
                url: 'auth/register',
                data: new FormData($('form[name="register"]')[0]),
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                beforeSend: function () {
                    // this is where we append a loading image...
                    //document.getElementById("loader").style.display = "block";
                },
                success: function (data) {
                    // successful request; do something with the data...
                    if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                        notif({
                            msg: data["data"],
                            position: "center",
                            time: 10000
                        });
                    }else{
                        notif({
                            msg: data["data"],
                            position: "center",
                            time: 10000
                        });
                    }
                },
                error: function (data) {
                    // failed request; give feedback to user...
                    notif({
                        msg: "<b>Oops!</b> שגיאה.  נסה שוב מאוחר יותר..",
                        position: "center",
                        time: 10000
                    });
                }
            });
            return true;
        }
    });
}


if ($('form[name="signIn"]').length) {
    $('form[name="signIn"]').validate({// initialize the plugin
        rules: {
            password: {
                required: true
            },
            email: {
                required: true,
                email: true
            }
        },
        submitHandler: function (form) {
            $.ajax({
                type: 'POST',
                url: 'auth/check',
                data: new FormData($('form[name="signIn"]')[0]),
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                beforeSend: function () {
                    // this is where we append a loading image...
                },
                success: function (data) {
                    // successful request; do something with the data...
                    if (data['status'] == RESPONSE_STATUS_SUCCESS) {
                        $('form[name="signIn"]').unbind("submit").submit();
                    } else {
                        notif({
                            msg: "<b>Oops!</b> "+data['data'],
                            position: "center",
                            time: 10000
                        });
                        $('input[id="signEmail"]').css({'border': '2px solid #FF0000'});
                        $('input[id="signPassword"]').css({'border': '2px solid #FF0000'});
                        $('input[id="signEmail"]').focus();
                    }
                },
                error: function (data) {
                    // failed request; give feedback to user...
                    notif({
                        msg: "<b>Oops!</b> שגיאה.  נסה שוב מאוחר יותר..",
                        position: "center",
                        time: 10000
                    });
                }
            });
            return true;
        }
    });
}

if ($('form[name="forgotPassword"]').length) {
    $('form[name="forgotPassword"]').validate({// initialize the plugin
        rules: {
            email: {
                required: true
            }
        },
        submitHandler: function (form) {
            $.ajax({
                type: 'POST',
                url: 'auth/check/forgot',
                data: new FormData($('form[name="forgotPassword"]')[0]),
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                beforeSend: function () {
                    // this is where we append a loading image...
                },
                success: function (data) {
                    // successful request; do something with the data...
                    if (data == RESPONSE_STATUS_ERROR) {
                        notif({
                            msg: "<b>Oops!</b> שם וסיסמא לא נכונים",
                            position: "center",
                            time: 10000
                        });
                        $('input[name="email"]').css({'border': '2px solid #FF0000'});
                        $('input[name="email"]').focus();
                        return false;
                    } else {
                        $.ajax({
                            type: 'POST',
                            url: 'auth/forgot',
                            data: new FormData($('form[name="forgotPassword"]')[0]),
                            contentType: false, // The content type used when sending data to the server.
                            cache: false, // To unable request pages to be cached
                            processData: false,
                            beforeSend: function () {
                                // this is where we append a loading image...
                            },
                            success: function (data) {
                                // successful request; do something with the data...
                                notif({
                                    msg: data['data'],
                                    position: "center",
                                    time: 10000
                                });
                            },
                            error: function (data) {
                                // failed request; give feedback to user...
                                notif({
                                    msg: "<b>Oops!</b> שגיאה.  נסה שוב מאוחר יותר..",
                                    position: "center",
                                    time: 10000
                                });
                            }
                        });
                        return false;
                    }
                },
                error: function (data) {
                    // failed request; give feedback to user...
                    notif({
                        msg: "<b>Oops!</b> שגיאה.  נסה שוב מאוחר יותר..",
                        position: "center",
                        time: 10000
                    });
                    return false;
                }
            });
            return false;
        }
    });
}

$('form[name="forgotPassword"]').on('submit', function (event) {
    event.preventDefault();
});

function setTimeZone (date) {
    var date = new Date(date);
    // console.log(date.getTimezone());
}

function createSessionVariable(variable,value){
    $.ajax({
        url: 'createSessionVariable',
        type:'POST',
        data: {'variable':variable, 'value':value},
        success: function () {
            return true;
        },
        error: function () {
            return false;
        }
    });
}