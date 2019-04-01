@if($order->status == Config::get('constants.ORDER_STATUS_ACCEPTED_BY_MANAGER'))
    <input type="button" class="btn btn-success" onclick="changeStatus({{Config::get('constants.ORDER_STATUS_PROCESS_START')}},{{$order->id}})" value="שליח בדרך" style="margin-top : 3px;">
@elseif($order->status >= Config::get('constants.ORDER_STATUS_PROCESS_START') && $order->status != Config::get('constants.ORDER_STATUS_FINISHED'))
<?php
	    switch ($order->status) {
	      case Config::get('constants.ORDER_STATUS_PROCESS_START'):
	        $value = "שליח הגיע לחברה";
	        $status = Config::get('constants.ORDER_STATUS_REACH_RESTAURANT'); 
	        break;
	      case Config::get('constants.ORDER_STATUS_REACH_RESTAURANT'):
	        $value = "שליח עזב חברה";
	        $status = Config::get('constants.ORDER_STATUS_LEAVE_RESTAURANT'); 
	        break;
	      case Config::get('constants.ORDER_STATUS_LEAVE_RESTAURANT'):
	        $value = "שליח הגיע ללקוח";
	        $status = Config::get('constants.ORDER_STATUS_REACH_CUSTOMER'); 
	        break;
	      default:
	      $value = "n/a";
	        $status = '';
	        break;
	    }
	?>
@if(!empty($status))
<input type="button" class="btn btn-primary" value="{{$value}}" onclick="changeStatus({{$status}},{{$order->id}})" style="margin-top : 3px;">
@endif
<input type="button" class="btn btn-danger" value="לְבַטֵל" onclick="cancelStatus({{$order->id}})" style="margin-top : 3px;">
@endif