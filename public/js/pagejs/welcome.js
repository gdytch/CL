var sections = null;


$('#lname').keydown(function (e) {
    if (e.keyCode == 13) {
        checkUser();
        return false;
    }
});
$('#password').keydown(function (e) {
    if (e.keyCode == 13) {
        loginUser();
        return false;
    }
});
$('#checkUsersButton').click(function (event) {
    checkUser();
});

$('#loginButton').click(function (event) {
    loginUser();
});

function loginUser() {
    $('#progressBar').fadeIn(1000);
    $.ajax({
        type: 'POST',
        url: 'login',
        data: new FormData($('#login-form-users')[0]),
        processData: false,
        contentType: false,
        success: function (response) {
            var data = response;
            console.log(data)
            if (data.redirect != null) {
                window.location.href = data.redirect;
            } else {
                $('#progressBar').fadeOut(1000);
                $.notify({
                    message: '' + data.error + ''
                }, {
                    type: 'danger',
                    allow_dismiss: true,
                    placement: {
                        from: "top",
                        align: "center"
                    },
                    delay: 5000,
                    offset: 45,
                });
            }
        },
        error: function (data) {
            $.notify({
                message: 'Connection Error'
            }, {
                type: 'danger',
                allow_dismiss: true,
                placement: {
                    from: "top",
                    align: "center"
                },
                delay: 5000,
                offset: 45,

            });
        }
    });
}

function checkUser() {
    $('#login-form-users').hide();
    $('#userList').empty();
    $('#progressBar').fadeIn(1000);


    $.ajax({
        type: 'POST',
        url: 'checkUser',
        data: new FormData($('#login-form-checkusers')[0]),
        processData: false,
        contentType: false,
        success: function (response) {
            var userSections = new Array();
            var x = 0;
            $('#progressBar').fadeOut(100);
            $('#lname').removeClass('is-invalid').addClass('underlined');
            $('#lnameFeedback').text('');
            var data = response;
            console.log(data)
            if (data.users.length != 0) {
                var section_status = '';
                var section_status_closed = '';
                data.users.forEach(function (user) {
                    userSections[x] = user.section;
                    x++;
                    if (user.section_status == false) {
                        if (data.users.length < 2) {
                            $('#password').attr('disabled', true);
                        } else {
                            $('#password').attr('disabled', false);
                        }
                        section_status = 'disabled';
                        section_status_closed = '';
                    } else {
                        section_status = '';
                        section_status_closed = 'hidden';
                    }

                    $('#userList').append('<div id="' + user.id + '"><label>\
                                        <input class="radio ' + user.section_name + '" name="id" type="radio" value="' + user.id + '"  ' + section_status + '>\
                                        <div class="account-block">\
                                            <img src="' + user.avatar_file + '" class="login-img">\
                                            <span class="accounts"> ' + user.lname + ', ' + user.fname + '</span>\
                                            <span class="user-section">' + user.section_name + ' <span class="' + user.section_name + '_closed ' + section_status_closed + '" style="color:#ff7a7a;"><em>(Closed)</em></span></p>\
                                        </div>\
                                    </label></div> \
                            ');
                });
                if (data.users.length < 2) {
                    $(".radio").attr("checked", true);

                }
                $('#login-form-users').show('200');
                sections = userSections;

            } else {
                if (data.redirect != null)
                    window.location.href = data.redirect;

                $('#lname').removeClass('underlined').addClass('is-invalid');
                $('#lnameFeedback').text('Lastname not found.');
            }
        },
        error: function (data) {
            $.notify({
                message: 'Connection Error'
            }, {
                type: 'danger',
                allow_dismiss: true,
                placement: {
                    from: "top",
                    align: "center"
                },
                delay: 5000,
                offset: 45,

            });
        }
    });

}



function checkUserSection() {

    if (sections != null)
        $.ajax({
            type: 'get',
            url: 'checkUserSection',
            data: {
                'sections': sections
            },

            success: function (response) {
                var data = response;
                data.forEach(function (section) {
                    if (section.status == true) {
                        $('.' + section.name).attr('disabled', false);
                        $('.' + section.name + '_closed').hide();
                        $('#password').attr('disabled', false);
                    } else {
                        $('.' + section.name).attr('checked', false);
                        $('.' + section.name).attr('disabled', true);
                        $('.' + section.name + '_closed').show();

                    }
                });
            },
            error: function (data) {
                $.notify({
                    message: 'Connection Error'
                }, {
                    type: 'danger',
                    allow_dismiss: true,
                    placement: {
                        from: "top",
                        align: "center"
                    },
                    delay: 5000,
                    offset: 45,

                });
            }
        });
}
setInterval('checkUserSection()', 1000);
