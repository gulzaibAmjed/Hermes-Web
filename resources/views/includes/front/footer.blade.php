<footer id="main-footer">
        <div class="auto-container">
        
            <div class="contact-sec">
                <div class="sec-title wow fadeIn" data-wow-delay="500" data-wow-duration="1s" data-wow-offset="10">
                    <h2>צור קשר</h2>
                </div>
                <div class="contact-text">
                  <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. <br>It is a paradisematic country, A small river named Duden flows by their place and supplies</p>
                </div>
                <div class="row clearfix">
                    <div class="contact-block col-md-4 col-sm-6 col-xs-12 wow fadeInRight" data-wow-delay="500" data-wow-duration="2s" data-wow-offset="10">
                        <span class="icon img-circle" style="background-image:url({{asset('/assets/images/icons/icon-briefcase.png')}});"></span>
                        <p class="margin-right-25"><a href="mailto:3rdharmonics@gmail.com">hermes@gmail.com</a></p>
                    </div>
                    <div class="contact-block col-md-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="500" data-wow-duration="2s" data-wow-offset="10">
                        <span class="icon img-circle" style="background-image:url({{asset('/assets/images/icons/icon-phone.png')}});"></span>
                        <p class="margin-right-25">+11 234 567 890 <br>+11 286 543 850</p>
                    </div>
                    <div class="contact-block col-md-4 col-sm-6 col-xs-12 wow fadeInLeft" data-wow-delay="500" data-wow-duration="2s" data-wow-offset="10">
                        <p class="margin-right-25">123 Fifth Avenue, 12th, <br>New York,NY 10010</p>
                        <span class="icon img-circle" style="background-image:url({{asset('/assets/images/icons/location-marker.png')}});"></span>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="contact-form wow fadeIn" data-wow-delay="500" data-wow-duration="1s" data-wow-offset="10">
                    <form method="post" action="{{url('/contact')}}" id="contact-form">
                        <div class="clearfix">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <fieldset class="form-group ">
                                <input type="text" name="name" value="" placeholder="שם">
                            </fieldset>
                            
                            <fieldset class="form-group">
                                <input type="email" name="email" value="" placeholder="אי מייל ">
                            </fieldset>
                            
                            <fieldset class="form-group">
                                <textarea name="message" placeholder="הודעה"></textarea>
                            </fieldset>
                            
                            <button type="submit" class="btn">שליח</button>
                        
                        </div>
                    </form>
                </div>
                
            </div>
            
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bootom">
            <div class="auto-container">
                <div class="logo wow fadeInDown" data-wow-delay="500" data-wow-duration="2s" data-wow-offset="10"><a href="#"><img src="{{asset('/assets/images/logo.png')}}" alt="" title=""></a></div>
                <div class="copyright">Copyright &copy;2016 Group Hermes.</div>
                <div class="social-links wow fadeInUp" data-wow-delay="500" data-wow-duration="1s" data-wow-offset="10">
                    <a href="#" class="fa fa-facebook-f" title="Facebook"></a>
                    <a href="#" class="fa fa-twitter" title="Twitter"></a>
                    <a href="#" class="fa fa-google-plus" title="Google-Plus"></a>
                </div>
            </div>
        </div>
    </footer>