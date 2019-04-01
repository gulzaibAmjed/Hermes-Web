@extends('layouts.front')
@section('content')
<section id="main-slider" class="main-slider">
    	
        <ul class="slider">
            
            <li class="slide-item active-slide" style="background-image:url(assets/images/main-slider/image-4.jpg);">
            	<div class="auto-container"> </div>
            </li>
              
        </ul>
        
        <!-- Scroll Down -->
        <div class="scroll-down" id="down_to_signin"  data-id="#game-developer">
        	<span class="fa fa-angle-down"></span><br>
            <span class="fa fa-angle-down"></span><br>
            <span class="fa fa-angle-down"></span>
        </div>
        
    </section>
    
    <!--Developer Section-->
    <section class="developer-sec" id="game-developer">
    	<div class="auto-container">
            
            <div class="row clearfix">
            	<!--Sign In-->
            	<div class="col-md-6 col-sm-6 col-xs-12">
                	<div class="dev-login wow zoomIn" data-wow-delay="500" data-wow-duration="2s" data-wow-offset="5">
                    	<h3>כניסת שליחים</h3>
                        <form name="signIn" id="managerSignIn" method="post" action="{{url('/auth/login')}}">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        	<fieldset class="form-group">
                            	<input class="username" type="text" name="email" id="signEmail" value="" placeholder="אי מייל">
                            </fieldset>
                            <fieldset class="form-group">
                            	<input class="user-password" type="password" name="password" id="signPassword" value="" placeholder="סיסמא">
                            </fieldset>
                            <div class="clearfix">
                                <button class="pull-left" type="submit">כניסה</button>
                                <a href="#" class="pull-right forgot-pass has-popup" data-target="#pwdModal" data-toggle="modal" title="Contact-Now">שכחת סיסמא?</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!--Image-->
                <div class="col-md-6 col-sm-6 col-xs-12">
                	<div class="right-image wow fadeInRight" data-wow-delay="1000" data-wow-duration="2s" data-wow-offset="0"><a href="#"><img src="{{url('assets/images/resource/developer-sec-image.png')}}" alt=""></a></div>
                </div>
                
            </div>
			<br><br>
        </div>
    </section>    
<!--End pagewrapper-->
@stop