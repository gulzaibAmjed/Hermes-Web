<header class="main-header">
        <div class="auto-container">
            <div class="row clearfix">
            
                <!-- Logo -->
                <div class="col-md-3 col-sm-12 col-xs-12 logo  wow fadeInRight" data-wow-delay="500" data-wow-duration="2s" data-wow-offset="5"><a href="{{url()}}"><img src="{{asset('/assets/images/logo.png')}}" alt="Logo" title="Hermes"></a></div>
                
                <div class="col-md-9 col-sm-12 col-xs-12 header-right clearfix">
                    
                    <div></div>
                    
                    <div class="social-links">
                        <a href="#" class="fa fa-facebook-f" title="Facebook"></a>
                        <a href="#" class="fa fa-twitter" title="Twitter"></a>
                        <a href="#" class="fa fa-google-plus" title="Google-Plus"></a>
                    </div>
                    
                    <!-- Main Menu -->
                    <nav class="main-menu clearfix">
                        <div class="navbar-header">
                            <!-- Toggle Button -->      
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <?php $current_route = Route::getCurrentRoute()->getPath();error_log($current_route)?>
                        <div class="navbar-collapse collapse clearfix">                                                                                              
                            <ul class="nav navbar-nav navbar-right">
                                <li class="@if($current_route=='manager'){{'current'}}@endif" ><a href="{{url('/manager')}}"><?php echo "שליחים";?></a></li>
                                <li class="@if($current_route=='customer'){{'current'}}@endif"><a href="{{url('/customer')}}"><?php echo "לקוחות";?></a></li>
                                <li class="@if($current_route=='/'){{'current'}}@endif"><a href="{{url('/')}}"><?php echo "עמוד הבית";?></a></li>
                            </ul>
                        </div>
                    </nav><!-- Main Menu End-->
                </div>
                
            </div>
        </div>
    </header>