@extends('layouts.front')
@section('content')
    <section id="main-slider" class="main-slider">
    	
        <ul class="slider">
            
            <li class="slide-item active-slide" style="background-image:url({{asset('/assets/images/main-slider/image-4.jpg')}});">
            	<div class="auto-container"> </div>
            </li>
              
        </ul>
        
        <!-- Scroll Down -->
        <div class="scroll-down" id="down_to_signin" data-id="#game-developer">
        	<span class="fa fa-angle-down"></span><br>
            <span class="fa fa-angle-down"></span><br>
            <span class="fa fa-angle-down"></span>
        </div>
    </section>

    <section class="developer-sec" id="game-developer">
    	<div class="auto-container">
            
            <div class="row clearfix">
            	<!--Sign In-->
            	<div class="col-md-6 col-sm-6 col-xs-12">
                	<div class="dev-login wow zoomIn" data-wow-delay="500" data-wow-duration="2s" data-wow-offset="5">
                    	<h3>כניסת לקוחות</h3>
                        <form name="signIn" id="customerSignIn" method="post" action="{{url('/auth/login')}}" class="signIn">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
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
                	<div class="right-image wow fadeInRight" data-wow-delay="1000" data-wow-duration="2s" data-wow-offset="0"><a href="#"><img src="{{asset('/assets/images/resource/developer-sec-image.png')}}" alt=""></a></div>
                </div>
                
            </div>
			<br><br>
                      
            <div class="login-text clearfix wow fadeInUp" data-wow-delay="500" data-wow-duration="1.5s" data-wow-offset="0">
            	<div class="sec-title"><h2>צור חשבון לקוח</h2></div>
                <div class="text">
                	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
                </div>
            </div>
            
            <!--Sign Up-->
            <div class="sign-up wow fadeInUp" data-wow-delay="500" data-wow-duration="1.5s" data-wow-offset="10">
            	<div class="sec-title toggle-btn"><h2>הרשם עכשיו</h2></div>
                <!-- Toggle-Box -->
                <div class="toggle-box" style="text-align: right">
                
                    <form name="register" id="register" enctype="multipart/form-data">
                        <div class="form-container clearfix">
                            <fieldset class="sign-form-group">
                                <input type="text" name="company_name" id="company_name" value="" placeholder="שם עסק">
                            </fieldset><fieldset class="sign-form-group">
                                <input type="email" name="email" id="email" value="" placeholder="אי מייל">
                            </fieldset>
                            <fieldset class="sign-form-group">
                                <input type="text" name="address" id="address" value="" placeholder="כתובת">
                            </fieldset>
                            <fieldset class="sign-form-group">
                                <input type="text" name="website" id="website" value="" placeholder="www.website.com">
                            </fieldset>
                            <fieldset class="sign-form-group">
                                <input type="password" name="password" id="password" value="" placeholder="סיסמא">
                            </fieldset>
                            <fieldset class="sign-form-group">
                                <input type="text" name="contact_number" id="contact_number" value="" placeholder="2324-567-89000">
                            </fieldset>
                        </div>
                        <button type="submit" class="btn">כניסת לקוחות</button>
                    </form>
                </div>
                
            </div>
        </div>
    </section>


@stop