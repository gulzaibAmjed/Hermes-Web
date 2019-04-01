<div class="forms">
                            <div class="form-group">
                            	<form name="addManager" id="addManager" method="POST" action="#">
                                    <div class="form-field-box">
                                        <input type="text" name="name" value="" placeholder="שפ..." id="inp_name">
                                    </div>
                                    <div class="current-value">
                                        <div class="current-value-box text_align_right">
                                            <span class="editable-value"></span><span class="value-label"> : שפ </span>  <span class="fa fa-user"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>

                                    <div class="form-field-box">
                                        <input type="email" name="email" value="" placeholder="שפ..." id="inp_email">
                                    </div>
                                    <div class="current-value">
                                        <div class="current-value-box text_align_right">
                                            <span class="editable-value"></span><span class="value-label"> : אי מייל </span>  <span class="fa fa-mail"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>

                                    <div class="form-field-box">
                                        <input type="password" name="password" value="" placeholder="אי מייל..." id="inp_password">
                                    </div>
                                    <div class="current-value">
                                        <div class="current-value-box text_align_right">
                                            <span class="editable-value"></span><span class="value-label"> : סיסמא </span>  <span class="fa fa-key"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <button class="btn btn-danger btn-place-order" value="Add Manager" type="submit" >הוסף שליח</button>
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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->
                       <script>
// $(document).ready(function(){
//     alert("1");
//     if (navigator.geolocation) {
//         navigator.geolocation.getCurrentPosition(showLocation);
//         showLocation();
//     } else { 
//         //$('#location').html('Geolocation is not supported by this browser.');
//     }
// });

// function showLocation(position) {
//     alert("2");
//     var latitude = position.coords.latitude;
//     var longitude = position.coords.longitude;
//     $.ajax({
//         type:'POST',
//         url:'',
//         data:'latitude='+latitude+'&longitude='+longitude,
//         success:function(msg){
//             if(msg){
//                 alert(msg);
//                //$("#location").html(msg);
//             }else{
//                 //$("#location").html('Not Available');
//             }
//         }
//     });
// }

// <?php
// if(!empty($_POST['latitude']) && !empty($_POST['longitude'])){
//     //Send request and receive json data by latitude and longitude
//     $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($_POST['latitude']).','.trim($_POST['longitude']).'&sensor=false';
//     $json = @file_get_contents($url);
//     $data = json_decode($json);
//     $status = $data->status;
//     if($status=="OK"){
//         //Get address from json data
//         $location = $data->results[0]->formatted_address;
//     }else{
//         $location =  '';
//     }
//     //Print address 
//     echo $location;
// }
// ?>
</script>
                       <script type="text/javascript" src="{{asset('assets/back/js/admin.js')}}"></script>