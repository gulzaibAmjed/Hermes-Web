<style type="text/css">
    .ui-menu-item{
        cursor: pointer;
    }
</style>

<div class="forms">
    <div class="form-group">
        <form name="addOrder" id="addOrder" action="#">
            @if(\Auth::user()->type == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
            <input name='id' value="{{$customer_id}}" type="hidden" />
            @endif

            <div class="form-field-box">
                <!-- <input type="text" name="street" value="" placeholder="Start Typing..." id="street" autocomplete="off" > -->
                <select id="streets" name="street" class="">
            @foreach($streets as $key=>$childStreets)
                <optgroup label="{{$key}}">
                  @foreach($childStreets as $child)
                        <option value="{{$child->child_id}}">{{$child->child_category}}</option>
                   @endforeach
                </optgroup>
              @endforeach
                </select>
            </div>

            <div class="current-value">
                <div class="current-value-box text_align_right">
                    <span class="editable-value"></span><span class="value-label"> : מספר</span>  <span class="fa fa-location-arrow"></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>

            <div class="form-field-box text_align_right">
                <input type="text" name="address" value="" placeholder="">
            </div>
            <div class="current-value text_align_right">
                <div class="current-value-box">
                    <span class="editable-value"></span><span class="value-label">:  רמספר רחוב</span><span class="fa fa-map-marker"></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>

            <div class="div_add_order_time">
                <div style="width: 100%; " class="div-btns_add_order_time">
                    <input type="button" class="btn btn-danger btn-sm time-plus" value="R" onclick="setTime('clear')" >
                    <input type="button" class="btn btn-info btn-sm time-plus" value="10" onclick="setTime(10)">
                    <input type="button" class="btn btn-info btn-sm time-plus" value="15" onclick="setTime(15)">
                    <input type="button" class="btn btn-info btn-sm time-plus" value="20" onclick="setTime(20)">
                    <input type="button" class="btn btn-info btn-sm time-plus" value="25" onclick="setTime(25)">
                    <input type="hidden" id="time_plus" name="time_plus" value="0">
                    <div class="pull-right " style="width:45%;"><input name="delivery_time" id="timepicker1" style="width:100%;background-color: transparent"></div>
                </div>
            </div>
            <div class="current-value">
                <div class="current-value-box text_align_right">
                    <span class="editable-value"></span><span class="value-label"> : זמן משלוח </span>  <span class="fa fa-clock-o"></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>

            <div class="form-field-box text_align_right">
                <input type="text" name="customer_name" value="" placeholder="">
            </div>
            <div class="current-value text_align_right">
                <div class="current-value-box">
                    <span class="editable-value"></span><span class="value-label"> : לקוח </span><span class="fa fa-user"></span>
                </div>
            </div>

            <div class="clearfix"></div>
            <br>

            <div class="current-value text_align_right">
                <br>
                <label label-default="" class="radio-inline">
                <input name="payment_method" id="cash" value="1" type="radio">מזומן</label>
                <label label-default="" class="radio-inline">
                <input name="payment_method" id="credit" value="2" checked="" type="radio">כרטיס אשראי</label>
                </div>

            <div class="current-value text_align_right">
                <div class="current-value-box">
                    <span class="editable-value"></span><span class="value-label"> : אמצעי תשלום </span><span class="fa fa-credit-card"></span>
                </div>
            </div>

            <div class="clearfix"></div>
            <br>

            <div class="form-field-box text_align_right" style="width: 100%">
                <input type="text" name="comments" value="" placeholder="הערות" rows="4" >
            </div>
            <div class="clearfix"></div>
            <br>

            <button id="addOrder" class="btn btn-danger btn-place-order" value="Save" type="submit" >הוסף הזמנה</button>
        </form>
    </div>
    <br><br>

</div>
<!--Forms End-->
<script type="text/javascript">
    var d = new Date();
    $('#timepicker1').timepicki();
    $('#timepicker1').val(d.getHours() + " : " + d.getMinutes());

    if ($('#addOrder').length) {
        var validator = $('#addOrder').validate({// initialize the plugin
            rules: {
                city: {
                    required: true
                },
                street: {
                    required: true
                },
                timepicker1: 'required|timeValidation'
            },
            submitHandler: function (form) {
                $.ajax({
                    type: 'POST',
                    url: 'orders',
                    data: new FormData($('form[name="addOrder"]')[0]),
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    beforeSend: function () {
                        // this is where we append a loading image...
                    },
                    success: function (data) {
                        // successful request; do something with the data
                        if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                            notif({
                                msg: "<b>Success!</b>" + data['data'] ,
                                position: "center",
                                time: 10000
                            });
                            $('#view_orders').click();
                        } else {
                            notif({
                                msg: "<b>Oops!</b>" + data['data'] ,
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
//        validator.registerCallback('timeValidation',function(value) {
//        if (d.getHours()==$('#timepicker1').split(':')[0] && $('#timepicker1').split(':')[1]>=(d.getMinutes()+10)) {
//            return true;
//        }else{
//        return false;
//
//        }
//
//    }).setMessage('timeValidation', 'Please enter time more than 10 minutes.');
    }

    $('form[name="addOrder"]').on('submit', function (event) {
        event.preventDefault();
        // Function to make view of add order...
    });
</script>

        <script>
             var d = new Date();
             var hours = d.getHours();
             var minutes = d.getMinutes();

            if((hours>=1 && hours<10) && (minutes>=1 && minutes<10)){
                hours = '0'+hours;
                minutes = '0'+minutes;
            }else if(hours>=1 && hours<10){
             hours = '0'+hours;
            }else if(minutes>=1 && minutes<10){
              minutes = '0'+minutes;
             }

            if(hours == 0){
                hours = '00'
            }
            $('#timepicker1').timepicki();
            $('#timepicker1').val(hours+' : '+minutes);

                        // $("#suggesstion-box").show();
            // $("#suggesstion-box").html(data);
            // $("#street").css("background","#FFF");

                 $(function() {
                 
             });

$('.time-plus').click(function(){
var value = $(this).val();
if(value == 'R'){
$('#time_plus').val(0);
}else{
$('#time_plus').val(value);
}
});

$("#street").keyup(function(){
        $.ajax({
        type: "POST",
        url: "streets",
        data:'keyword='+$(this).val(),
        beforeSend: function(){
                        $.LoadingOverlay("hide");
        },
        success: function(data) {
            if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                var availableCities = data['data'];
                 $( "#street" ).autocomplete({
                     source: [
                        {lable:'1',value:'asddd',id:'1'}
                     ]
                     // source: availableCities
                 });
             }else{
               /* notif({
                        msg: "<b>Oops!</b> "+data+".",
                        position: "center",
                        time: 10000
                    });*/
             }
         },
         error: function(data) {
            notif({
                        msg: "<b>Oops!</b> שגיאה.  נסה שוב מאוחר יותר..",
                        position: "center",
                        time: 10000
                    });
         }  
    });
    });
            function setTime(time){
                if(time != 'clear'){
                    var d = new Date();
                    var hours = d.getHours();
                    var minutes = d.getMinutes();
                    if((minutes + time) > 59){
                        var minutes = (minutes + time) - 59;
                        if(minutes == 0){
                            minutes = '00';
                        }else if(minutes>=1 && minutes<10){
                            minutes = '0'+minutes;
                            }

                        if((hours + 1) == 24){
                        hours = '00';
                        }else{
                            if((hours + 1)>=1 && (hours + 1)<10){
                                hours = '0'+(hours+1);
                            }else{
                                hours = hours+1;
                            }
                        }
                    }else{
                        if((hours>=1 && hours<10) && ((minutes+time)>=1 && (minutes+time)<10)){
                                        hours = '0'+hours;
                                        minutes = '0'+(minutes+time);
                                    }else if(hours>=1 && hours<10){
                                     hours = '0'+hours;
                                     if((minutes+time)>=1 && (minutes+time)<10){
                                        minutes = '0'+(minutes+time);
                                     }else{
                                        minutes = minutes+time;
                                     }
                                    }else if((minutes+time)>=1 && (minutes+time)<10){
                                      minutes = '0'+(minutes+time);
                                     }else{
                                     minutes = minutes+time;
                                     }

                                    if(hours == 0){
                                        hours = '00'
                                    }
                    }
                }else{
                    var d = new Date();
                                 var hours = d.getHours();
                                 var minutes = d.getMinutes();
                                if((hours>=1 && hours<10) && (minutes>=1 && minutes<10)){
                                    hours = '0'+hours;
                                    minutes = '0'+minutes;
                                }else if(hours>=1 && hours<10){
                                 hours = '0'+hours;
                                }else if(minutes>=1 && minutes<10){
                                  minutes = '0'+minutes;
                                 }

                                if(hours == 0){
                                    hours = '00'
                                }
                }

                $('#timepicker1').val(hours+' : '+minutes);

            }

            // Move to login screen if its from logout...
            $(document).ready(function(){
            $('#streets').select2({
            placeholder: "בחר ...",
              allowClear: true,
              maximumSelectionLength: 2
            });
            });
        </script>
