<!-- Sidebar -->
<aside id="sidebar">
  <!-- Logo -->
  <div class="logo"><a href="{{url('/dashboard')}}"><img src="{{asset('/assets/images/logo.png')}}" alt="Logo" title="Hermes"></a></div>
  <!-- Navbar -->
  <nav class="nav-bar scroll-box">
    <div class="nav-block game text_align_right">
      @if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_CUSTOMER'))
      <div class="nav-btn"><a id="add_order" href="javascript:void(0)" onclick="addOrderView()">הוסף הזמנה &nbsp;<span class="fa fa-plus-circle"></span></a></div>
      <div class="nav-btn"><a id="view_orders" href="javascript:void(0)" onclick="getOrders()">הזמנות &nbsp;<span class="fa fa-eye"></span></a></div>
      <div class="nav-btn"><a id="edit_profile" href="javascript:void(0)" onclick="getProfile()">עדכון פרופיל&nbsp;<span class="fa fa-user"></span></a></div>
      @elseif(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
      <div class="nav-btn"><a id="view_customers" href="javascript:void(0)" data-toggle="collapse" data-target="#customerList">ניהול לקוחות &nbsp;<span class="fa fa-list "></span><span class="fa fa-chevron-down pull-left"></span></a></div>
      <div id="customerList" class="sublinks collapse ">
        <a class="list-group-item small" onclick="getCustomers()"><span class="glyphicon glyphicon-chevron-right"></span> צפה בכל הלקוחות</a>
      </div>
      <div class="nav-btn"><a href="javascript:void(0)" data-toggle="collapse" data-target="#orderList">ניהול הזמנות&nbsp;<span class="fa fa-cart-plus"></span><span class="fa fa-chevron-down pull-left"></span></a></div>
      <div id="orderList" class="sublinks collapse ">
        <a class="list-group-item small" id="view_orders" onclick="getOrders()"><span class="glyphicon glyphicon-chevron-right"></span> צפה בכל ההזמנות</a>
        <a class="list-group-item small" id="add_order_admin" onclick="createOrderAdmin()"><span class="glyphicon glyphicon-chevron-right"></span> הוסף הזמנה</a>
      </div>
      <div class="nav-btn"><a href="javascript:void(0)" data-toggle="collapse" data-target="#managerList">ניהול שליחים &nbsp;<span class="fa fa-user"></span><span class="fa fa-chevron-down pull-left"></span></a></div>
      <div id="managerList" class="sublinks collapse ">
        <a id="create_manager_view" class="list-group-item small" onclick="createManagerView()"><span class="glyphicon glyphicon-chevron-right"></span> הוסף שליח</a>
        <a id="all_managers" class="list-group-item small" onclick="getManagers()"><span class="glyphicon glyphicon-chevron-right"></span> צפה בכל השליחים</a>
        <a id="manager_location" class="list-group-item small" onclick="managerLocation()"><span class="glyphicon glyphicon-chevron-right"></span> מעקב שליחים</a>
      </div>
      <div class="nav-btn"><a href="javascript:void(0)" data-toggle="collapse" data-target="#areaList">ניהול איזורים &nbsp;<span class="icon fa fa-location-arrow"></span><span class="fa fa-chevron-down pull-left"></span></a></div>
      <div id="areaList" class="sublinks collapse ">
        <a id="locations_view" class="list-group-item small" onclick="viewAllLocations()"><span class="glyphicon glyphicon-chevron-right"></span> צפה בכל האיזורים</a>
        <a id="add_view" class="list-group-item small" onclick="createLocation()"><span class="glyphicon glyphicon-chevron-right"></span> הוסף איזור</a>
        <a id="add_bulk_location_view" class="list-group-item small" onclick="bulkLocations()"><span class="glyphicon glyphicon-chevron-right"></span> הוסף מספר איזורים</a>
      </div>
      <div class="nav-btn"><a href="javascript:void(0)" data-toggle="collapse" data-target="#priceList">ניהול מחירים &nbsp;<span class="icon fa fa-money"></span><span class="fa fa-chevron-down pull-left"></span></a></div>
      <div id="priceList" class="sublinks collapse ">
        <a id="prices_view" class="list-group-item small" onclick="priceList()"><span class="glyphicon glyphicon-chevron-right"></span> רשימת מחירים</a>
      </div>
      <div class="nav-btn"><a href="javascript:void(0)" data-toggle="collapse" data-target="#reports">דוחות &nbsp;<span class="icon fa fa-bar-chart"></span><span class="fa fa-chevron-down pull-left"></span></a></div>
            <div id="reports" class="sublinks collapse ">
              <a id="employee_report" class="list-group-item small" onclick="employeeReport()"><span class="glyphicon glyphicon-chevron-right"></span>דוח עובדים </a>
              <a id="orders_report" class="list-group-item small" onclick="ordersReport()"><span class="glyphicon glyphicon-chevron-right"></span> דוח הזמנות</a>
            </div>
      @elseif(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
      <div class="nav-btn"><a id="start_job" href="javascript:void(0)" onclick="viewStartJob()">התחל דיווח &nbsp;<span class="fa fa-clock-o"></span></a></div>
      <div class="nav-btn"><a id="view_jobs" href="javascript:void(0)" onclick="viewJobs()">הזמנות &nbsp;<span class="fa fa-tasks"></span></a></div>
      @endif
    </div>
    <div class="nav-block text_align_right">
      <div class="nav-btn"><a href="{{url('/auth/logout')}}">יציאה &nbsp;<span class="fa fa-sign-out"></span></a></div>
    </div>
  </nav>
</aside>