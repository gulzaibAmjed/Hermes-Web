<div class="forms">
    <div class="form-group">
    	<form name="editManager" id="editManager" method="POST" action="#" enctype="multipart/form-data">
        <?php $id = Vinkla\Hashids\Facades\Hashids::encode($manager->id);?>
        <input type="hidden" id="id" name="id" value={{$id}}>
            <div class="form-field-box">
                <input type="text" name="name" value="{{$manager->name}}" placeholder="שם ..." id="inp_name">
            </div>
            <div class="current-value">
                <div class="current-value-box text_align_right">
                    <span class="editable-value"></span><span class="value-label"> : שם  </span>  <span class="fa fa-user"></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>


            <button class="btn btn-danger btn-place-order" value="Add Manager" type="submit" >עדכן שליח</button>
        </form>
    </div>
    <br><br>
</div>
<!--Forms End-->

<script type="text/javascript">
   //  var d = new Date();
   // $('#timepicker1').timepicki();
   // $('#timepicker1').val("0" + d.getHours() + " : " + d.getMinutes());
    $('#from').timepicki({
        // show_meridian:true,
        min_hour_value:0,
        max_hour_value:23,
        overflow_minutes:true,
        increase_direction:'up'});

    $('#to').timepicki({
        // show_meridian:true,
        min_hour_value:0,
        max_hour_value:23,
        overflow_minutes:true,
        increase_direction:'up'});
</script>
<script src="{{asset('/assets/back/js/admin.js')}}"></script>
