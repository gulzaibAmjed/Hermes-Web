<style type="text/css">
  .table-section .data-table .data-row .cell{
    @if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_CUSTOMER'))
        width: 16.66%;
    @elseif(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
        width: 16.66%;
    @else
        width: 14.28%;
    @endif
  }
  .table-section .data-table .table-head .cell{
    @if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_CUSTOMER'))
        width: 16.66%;
    @elseif(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
        width: 16.66%;
    @else
        width: 14.28%;
    @endif
  }

.hours {
  float: left;
}
.minutes {
  float: left;
}
.seconds {
  float: left;
}
.clearDiv {
  clear: both;
}

.table-section .data-table .data-row {
@if((\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER') || \Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN')))
	background: #6489FF;
@endif
}

</style>