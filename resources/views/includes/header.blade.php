            <header class="top-header">
                <div class="sidebar-toggle"></div>
                <div class="header-inner clearfix">
                    <!--Contact Btn-->
                    <!--User Nav-->
                    <div class="user-info">
                        <div class="user-btn"><a href="{{url('/dashboard')}}" class="overlay-link" style="color: #ffffff">
                        <?php error_log($role);?>
                            @if($role == Illuminate\Support\Facades\Config::get('constants.USER_ROLE_CUSTOMER'))
                            <h1 class='header_name'>{{$company}}</h1>
                            @elseif($role == Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
                            <?php error_log($manager);?>
                            <h1 class='header_name'>{{$manager->name}}</h1>
                            @elseif($role == Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
                            <h1 class='header_name'>{{"Administrator"}}</h1>
                            @endif
                        </a></div>
                    </div>
                    <div class="pull-right" id="curr_time"></div>
                </div>
            </header>