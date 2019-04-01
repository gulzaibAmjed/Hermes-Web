<div class="forms">
    <div class="form-group">
        <!-- <form name="order" id="order" method="PUT" action="{{url('/orders')}}"> -->
        <?php $id = Vinkla\Hashids\Facades\Hashids::encode($order->id);?>
        {!!Form::open(array('url' => '/orders/'.$id, 'method' => 'put','name' => 'order','id' => 'order'))!!}
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
<div class="form-field-box">
                <!-- <input type="text" name="street" value="" placeholder="Start Typing..." id="street" > -->
                                <select id="streets" name="street" class="">
            @foreach($streets as $key=>$childStreets)
                <optgroup label="{{$key}}">
                  @foreach($childStreets as $child)
                        <option @if($order->street_id == $child->child_id){{"selected"}}@endif value="{{$child->child_id}}">{{$child->child_category}}</option>
                   @endforeach
                </optgroup>
              @endforeach
                </select>
            </div>
            <div class="current-value">
                <div class="current-value-box text_align_right">
                    <span class="editable-value"></span><span class="value-label"> : מספר </span>  <span class="fa fa-location-arrow"></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>


            <div class="form-field-box text_align_right">
                <input type="text" name="address" value="{{$order->address}}" placeholder="סוּג">
            </div>
            <div class="current-value text_align_right">
                <div class="current-value-box">
                    <span class="editable-value"></span><span class="value-label"> : רחוב</span><span class="fa fa-map-marker"></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>
<!--             <div class="form-field-box">
                <input type="text" name="street" value="" placeholder="Start Typing...">
            </div>
            <div class="current-value">
                <div class="current-value-box text_align_right">
                    <span class="editable-value"></span><span class="value-label"> : Street </span>  <span class="fa fa-street-view"></span>
                </div>
            </div>

            <div class="clearfix"></div>
            <br> -->

            <div class="form-field-box text_align_right">
                <input type="text" name="customer_name" value="{{$order->customer_name}}" placeholder="אופציונאלי">
            </div>
            <div class="current-value text_align_right">
                <div class="current-value-box">
                    <span class="editable-value"></span><span class="value-label"> : שם לקוח </span><span class="fa fa-user"></span>
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
                    <span class="editable-value"></span><span class="value-label"> :אמצעי תשלום</span><span class="fa fa-credit-card"></span>
                </div>
            </div>
            
            <div class="clearfix"></div>
            <br>

            <div class="form-field-box text_align_right" style="width: 100%">
                <input type="text" name="comments" value="{{$order->comments}}" placeholder="הערות" rows="4">
            </div>
            <div class="clearfix"></div>
            <br>

            <button class="btn btn-danger btn-place-order" value="Save" type="submit" >שמור</button>
            {!!Form::close()!!}
        <!-- </form> -->
    </div>
    <br><br>
    
</div>
<!--Forms End-->

<script type="text/javascript">
   var d = new Date();
   $('#timepicker1').timepicki();
   $('#timepicker1').val(d.getHours() + " : " + d.getMinutes());
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
                     source: availableCities
                 });
             }else{
                notif({
                        msg: "<b>Oops!</b> "+data+".",
                        position: "center",
                        time: 10000
                    });
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
    $(document).ready(function(){
        $('#streets').select2({
        placeholder: "בחר ...",
          allowClear: true,
          maximumSelectionLength: 2
        });
    });
</script>