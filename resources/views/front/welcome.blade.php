@extends('layouts.front')
@section('content')
    <section id="main-slider" class="main-slider">
        
        <ul class="slider">
            
            <li class="slide-item active-slide" style="background-image:url({{asset('/assets/images/main-slider/image-4.jpg')}})">
                <div class="auto-container">
                    <h2> <span></span> </h2>
                    <div class="slide-txt"></div>

                </div>
            </li>
              
        </ul>
        
        <!-- Scroll Down -->
        <div class="scroll-down" data-id="#what-we-do">
            <span class="fa fa-angle-down"></span><br>
            <span class="fa fa-angle-down"></span><br>
            <span class="fa fa-angle-down"></span>
        </div>
        
    </section>
    
    <!--What we do-->
    <section id="what-we-do">
        <div class="auto-container">
            <div class="sec-title wow fadeInUp" data-wow-delay="500" data-wow-duration="1s" data-wow-offset="10"><h2>What We Do?</h2></div>
            
            <div class=" clearfix wow fadeInUp" data-wow-delay="500" data-wow-duration="1s" data-wow-offset="10">
                
                <div class="box">
                    <a class="img-circle icon hvr-ripple-out" style="background-image:url({{asset('/assets/images/icons/icon-1.png')}})"></a>
                    <h3><a href="#">Our Managers</a></h3>
                    <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country. </p>
                </div>
                <div class="box">
                    <a class="img-circle icon hvr-ripple-out" style="background-image:url({{asset('/assets/images/icons/icon-2.png')}})"></a>
                    <h3><a href="#">Our Services</a></h3>
                    <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country. </p>
                </div>
                <div class="box">
                    <a class="img-circle icon hvr-ripple-out" style="background-image:url({{asset('/assets/images/icons/icon-3.png')}})"></a>
                    <h3><a href="#">Quick Deliver</a></h3>
                    <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country. </p>
                </div>                
            </div>
        </div>
    </section>
  
    <!--About Us-->
    <section id="about-us">
        <div class="auto-container">
            <div class="sec-title wow fadeInDown" data-wow-delay="500" data-wow-duration="1s" data-wow-offset="10"><h2>About Us</h2></div>
            
            <div class="row clearfix" >
                
                <div class="col-md-7 col-sm-6 col-xs-12 wow fadeInRight" data-wow-delay="500" data-wow-duration="2s" data-wow-offset="10" >
                    <div class="about-text">
                        <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, A small river named Duden flows by their place.</p>
                        <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, A small river named Duden flows by their place.</p>
                    </div>
                </div>
                
                <div class="col-md-5 col-sm-6 col-xs-12 wow fadeInLeft" data-wow-delay="500" data-wow-duration="2s" data-wow-offset="10">
                    <div class="image-slider">
                        <figure class="image-item"><a href="#"><img src="{{asset('/assets/images/resource/image-1.png')}}" alt="" title=""></a></figure>
                    </div>
                </div>
                
            </div>
            
            <br>  
                    
                </div>
            </div>
                
        </div>
    </section>
@stop