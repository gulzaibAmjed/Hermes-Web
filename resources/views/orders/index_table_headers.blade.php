  <!--Head-->
  <div class="table-head clearfix" xmlns="http://www.w3.org/1999/html">
    <div class="head-cell cell">
      <span class="icon fa fa-cogs"></span>
      <br>
      <span class="text">פעולות</span>
    </div>

    @if(\Auth::user()->role != \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
        <div class="head-cell cell">
          <span class="icon fa fa-bar-chart"></span></br>
          <span class="text">סטטוס</span>
        </div>
    @endif

    @if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN') || \Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
        <div class="head-cell cell">
          <span class="icon fa fa-bar-chart"></span></br>
          <span class="text">איסוף/הורדה</span>
        </div>
    @endif

    @if(\Auth::user()->role != \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
        <div class="head-cell cell">
          <span class="icon fa fa-calendar"></span></br>
          <span class="text">תאריך</span>
        </div>
    @endif

    @if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
        <div class="head-cell cell">
          <span class="icon fa fa-clock-o"></span>
          <br>
          <span class="text">שליח</span>
        </div>
    @endif

    <div class="head-cell cell">
      <span class="icon fa fa-user"></span>
      <br>
      <span class="text">@if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_CUSTOMER'))שם לקוח @else שם חברה @endif</span>
    </div>

    @if(\Auth::user()->role != \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
    <div class="head-cell cell">
      <span class="icon fa fa-location-arrow"></span>
      <br>
      <span class="text">כתובת </br>לקוח</span>
    </div>
    @endif

    <div class="head-cell cell">
      <span class="icon fa fa-clock-o"></span></br>
      <span class="text">זמן</br> משלוח</span>
    </div>

    @if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
            <div class="head-cell cell">
                  <span class="icon fa fa-clock-o"></span></br>
                  <span class="text">סטטוס</span>
            </div>
        @endif
  </div>