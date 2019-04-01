<div class="forms">
    <div class="form-group">
        <form name="updateLocation" id="updateLocation" method="POST" action="#">
            <div class="form-field-box">
                <input type="text" name="city" value="{{$street['city']['name']}}" placeholder="הקלד..." id="city">
                <input name="city_id" type="hidden" value="{{$street['city']['id']}}"></input>
                <input name="neighbourhood_id" type="hidden" value="{{$street['neighbourhood']['id']}}"></input>
                <input name="street_id" type="hidden" value="{{$street['id']}}"></input>
            </div>
            <div class="current-value">
                <div class="current-value-box text_align_right">
                    <span class="editable-value"></span><span class="value-label"> : יישוב </span>  <span class="fa fa-user"></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>
            <div class="form-field-box">
                <input type="text" name="neighbourhood" value="{{$street['neighbourhood']['name']}}" placeholder="הקלד..." id="neighbourhood">
            </div>
            <div class="current-value">
                <div class="current-value-box text_align_right">
                    <span class="editable-value"></span><span class="value-label"> : שכונה </span>  <span class="fa fa-user"></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>
            <div class="form-field-box">
                <input type="text" name="street" value="{{$street['name']}}" placeholder="הקלד..." id="street">
            </div>
            <div class="current-value">
                <div class="current-value-box text_align_right">
                    <span class="editable-value"></span><span class="value-label"> : רחוב </span>  <span class="fa fa-user"></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>
            <button class="btn btn-danger btn-place-order" value="Add Location" type="submit" >הוסף איזור</button>
        </form>
    </div>
<br><br>
</div>
<!--Forms End-->
<script type="text/javascript" src="{{asset('assets/back/js/admin.js')}}"></script>