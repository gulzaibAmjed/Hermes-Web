<div class="forms">
    <div class="form-group">
        <form name="addLocation" id="addLocation" method="POST" action="#">
            <div class="form-field-box">
                <input type="text" name="city" value="" placeholder="הקלד..." id="city">
            </div>
            <div class="current-value">
                <div class="current-value-box text_align_right">
                    <span class="editable-value"></span><span class="value-label"> : יישוב </span>  <span class="fa fa-user"></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>
            <div class="form-field-box">
                <input type="text" name="neighbourhood" value="" placeholder="הקלד..." id="neighbourhood">
            </div>
            <div class="current-value">
                <div class="current-value-box text_align_right">
                    <span class="editable-value"></span><span class="value-label"> : שכונה </span>  <span class="fa fa-user"></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>
            <div class="form-field-box">
                <input type="text" name="street" value="" placeholder="הקלד..." id="street">
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