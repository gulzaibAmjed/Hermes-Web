                        <!--Forms-->
                        <div class="forms">
                    <form method="POST" action="profile" name="updateProfile" id="updateProfile">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="form-group">
                                    <div class="form-field-box">
                                        <input type="text" name="company_name" id="company_name" value="{{$user['customer']['company_name']}}" placeholder="Start Typing...">
                                    </div>
                                    <div class="current-value text_align_right">
                                        <div class="current-value-box">
                                            <span class="editable-value">{{$user['customer']['company_name']}}</span><span class="value-label"> : שם חברה` </span><span class="fa fa-briefcase"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
                            
                            <div class="form-group">
                                    <div class="form-field-box">
                                        <input type="text" name="address" value="{{$user['customer']['address']}}" placeholder="הקלד..." >
                                    </div>
                                    <div class="current-value text_align_right">
                                        <div class="current-value-box">
                                            <span class="editable-value">{{$user['customer']['address']}}</span><span class="value-label"> : כתובת </span><span class="fa fa-map-marker"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
@if(\Illuminate\Support\Facades\Auth::user()->role == 1))
                            <div class="form-group">
                                    <div class="form-field-box">
                                        <input type="password" name="old_password" id="old_password" value="" placeholder="ישן סיסמא" >
                                    </div>
                                    <div class="current-value text_align_right">
                                        <div class="current-value-box">
                                            <span class="editable-value"></span><span class="value-label"> : ישן סיסמא </span><span class="fa fa-key"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                    <div class="form-field-box">
                                        <input type="password" name="password" id="password" value="" placeholder="חָדָשׁ סיסמא" >
                                    </div>
                                    <div class="current-value text_align_right">
                                        <div class="current-value-box">
                                            <span class="editable-value"></span><span class="value-label"> : חָדָשׁ סיסמא </span><span class="fa fa-key"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
                            
                            <div class="form-group">
                                    <div class="form-field-box">
                                        <input type="password" name="password_confirmation" id="password_confirmation" value="" placeholder="לְאַשֵׁר סיסמא" >
                                    </div>
                                    <div class="current-value text_align_right">
                                        <div class="current-value-box">
                                            <span class="editable-value"></span><span class="value-label"> : לְאַשֵׁר סיסמא </span><span class="fa fa-key"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
                            @else
                            <input type="hidden" value="{{$user['customer']['id']}}">
                            @endif

                            <div class="form-group">
                                    <div class="form-field-box">
                                        <input type="tel" name="contact_number" value="{{$user['customer']['contact_number']}}" placeholder="הקלד...">
                                    </div>
                                    <div class="current-value text_align_right">
                                        <div class="current-value-box">
                                            <span class="editable-value">{{$user['customer']['contact_number']}}</span><span class="value-label"> : טלפון</span><span class="fa fa-phone"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                            <button class="btn btn-danger btn-update-changes" value="Update Profile"  type="submit" >עדכן פרופיל</button>
                            </div>
                            <br><br>
                            </form>
                        </div>

                        <script type="text/javascript">
@if(\Illuminate\Support\Facades\Auth::user()->role == 1)
//customer  signup validation
if ($('#updateProfile').length) {
    $('#updateProfile').validate({// initialize the plugin
        rules: {
            old_password: {
                required: true
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            },
            company_name: {
                required: true
            },
            authrize_name: {
                required: true
            },
            address: {
                required: true
            },
            contact_number: {
                required: true
            }
        },
        submitHandler: function (form) {
        $.ajax({
            type: 'POST',
            url: 'profile',
            data: new FormData($('form[name="updateProfile"]')[0]),
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            beforeSend: function () {
                // this is where we append a loading image
            },
            success: function (data) {
                // successful request; do something with the data
                if(data['response'] == RESPONSE_STATUS_SUCCESS){
                    notif({
                        type: "success",
                        msg: data['data'],
                        position: "center",
                        fade: true
                    });
                $('.header_name').html($('#company_name').val());
                $('#edit_profile').click();
                }else{
                    notif({
                        type: "error",
                        msg: data['data'],
                        position: "center",
                        fade: true
                    });
                }
            },
            error: function (data) {
                // failed request; give feedback to user
                notif({
                    msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                    position: "center",
                    time: 10000
                });
            }
        });
        return true;
        }
    });
}
@else
if ($('#updateProfile').length) {
    $('#updateProfile').validate({// initialize the plugin
        rules: {
            company_name: {
                required: true
            },
            address: {
                required: true
            },
            contact_number: {
                required: true
            }
        },
        submitHandler: function (form) {
        $.ajax({
            type: 'POST',
            url: 'profile',
            data: new FormData($('form[name="updateProfile"]')[0]),
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            beforeSend: function () {
                // this is where we append a loading image
            },
            success: function (data) {
                // successful request; do something with the data
                if(data['response'] == RESPONSE_STATUS_SUCCESS){
                    notif({
                        type: "success",
                        msg: data['data'],
                        position: "center",
                        fade: true
                    });
                $('.header_name').html($('#company_name').val());
                $('#edit_profile').click();
                }else{
                    notif({
                        type: "error",
                        msg: data['data'],
                        position: "center",
                        fade: true
                    });
                }
            },
            error: function (data) {
                // failed request; give feedback to user
                notif({
                    msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                    position: "center",
                    time: 10000
                });
            }
        });
        return true;
        }
    });
}
@endif

$('form[name="updateProfile"]').on('submit', function (event) {
    event.preventDefault();
});
</script>
<!--Forms End-->