@include('orders.style')
<div class="data-table six-column">
	@include('orders.index_table_headers')
	<!--Scroll Box-->
	@if(count($orders)>0)
	<table class="table-body" id="table">
		@foreach($orders as $order)
		<?php
        	$currentTime = strtotime(date('Y-m-d H:i:s'))+(60*60*env('UTC_PLUS'));
        	$diff = $order->delivery_time - $currentTime;
			if($order->status==\Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_REACH_CUSTOMER') && (\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN') || \Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))){
			    $color = '#0bd18c'; //green
			    $fontcolor = 'white';
			}elseif(($order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_REACH_RESTAURANT') || $order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_LEAVE_RESTAURANT')) && (\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN') || \Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))){
                $color = '#90EE90'; //light green
                $fontcolor = 'white';
			}elseif($order->status < \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_REACH_RESTAURANT') && $diff < 0 && (\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN') || \Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))){
                $color = '#f06666'; //red
                $fontcolor = 'white';
			}elseif(($diff<300 && $diff>0) && (\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN') || \Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))){
			    $color = '#2D05EB'; //blue
			    $fontcolor = 'white';
			}else{
			    $color = '#6489FF';
			    $fontcolor = 'white';
			}
			?>
		<tr class="data-row" style="background: {{$color}}">
			<?php $id = Vinkla\Hashids\Facades\Hashids::encode($order->id);?>
			{{--      ********Action CELL********       --}}
			@if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
			<td class="cell row-cell pointer" name="{{$id}}">
				<select style="width:100%" id="orderAction">
				@if($order['status']==0 || $order['status']=='')
				<option value="" {{($order['status']==null)?'selected':'' || $order['status']==''?'selected':''}}>{{"בחר..."}}</option>
				@endif
				<option onclick="approve('{{$id}}',0);" value="0" {{($order['status']== \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_APPROVED'))?'selected':''}}>{{'אושר'}}</option>
				<option onclick="approve('{{$id}}',5);" value="5" {{($order['status']== \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_APPROVED+5'))?'selected':''}}>{{'אושר + 5'}}</option>
				<option onclick="approve('{{$id}}',10);" value="10" {{($order['status']== \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_APPROVED+10'))?'selected':''}}>{{'אושר + 10'}}</option>
				<option onclick="approve('{{$id}}',15);" value="15" {{($order['status']== \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_APPROVED+15'))?'selected':''}}>{{'אושר + 15'}}</option>
				<option onclick="reject('{{$id}}');" value="2" {{($order['status']== \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_CANCELED'))?'selected':''}}>{{'דחה!'}}</option>
				</select>
			</td>
			@elseif(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_CUSTOMER'))
			@if($order->status == Config::get('constants.ORDER_STATUS_PENDING'))
			<td class="cell row-cell pointer"><a href="javascript:void(0)" onclick="deleteOrder('{{$id}}');"><i class="fa fa-times fa-2x"></i></a> &nbsp; <a href="javascript:void(0)" onclick="editOrder('{{$id}}');"><i class="fa fa-pencil-square-o fa-2x"></i></a></td>
			@else
			<td class="cell row-cell pointer"></td>
			@endif
			@elseif(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
			@if($order->status == Config::get('constants.ORDER_STATUS_ASSIGNED'))
			<td class="cell row-cell pointer">
				<a href="javascript:void(0)" onclick="rejectJob('{{$id}}');"><i class="fa fa-times fa-2x"></i></a> &nbsp;
				<a href="javascript:void(0)" onclick="acceptJob('{{$id}}');"><i class="fa fa-check fa-2x"></i></a>
			</td>
			@else
			<td class="cell row-cell pointer"></td>
			@endif
			@endif
			{{--      ********Action CELL END********       --}}
			{{--      ********Status CELL********       --}}
			@if(\Auth::user()->role != \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
			<td class="cell row-cell pointer" onclick="seeDetail('{{$id}}')" style="color: {{$fontcolor}}">
				@if($order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_PENDING'))
                    {{"מחכה אלישור"}}
                    @elseif(($order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_APPROVED') || $order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_APPROVED+5') ||$order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_APPROVED+10') ||$order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_APPROVED+15')))
                    {{"אושר"}}
                    @elseif($order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_CANCELED'))
                    {{"בוטל"}}
                    @elseif($order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_DELETED'))
                    {{"נמחק"}}
                    @elseif($order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_ASSIGNED'))
                    {{"הושם שליח"}}
                    @elseif($order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_ACCEPTED_BY_MANAGER'))
                    @if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
                    {{"התקבל על ידי שליח"}}
                    @elseif(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
                    {{'אושר על ידי  שליח'}}
                    @endif
                    @elseif($order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_REJECTED_BY_MANAGER'))
                    @if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
                    {{"נדחה על ידי שליח"}}
                    @elseif(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
                    {{"נדחה על ידי שליחr"}}
                    @endif
                    @elseif($order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_PROCESS_START'))
                    {{"התחיל משלוח"}}
                    @elseif($order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_REACH_RESTAURANT'))
                    {{"הגיע לבית העסק"}}
                    @elseif($order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_LEAVE_RESTAURANT'))
                    {{"עזב את בית העסק"}}
                    @elseif($order->status == \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_REACH_CUSTOMER'))
                    {{"הגיע ללקוח"}}
                    @endif
			</td>
			@endif
			{{--      ********Status CELL END********       --}}
			{{--********Priority CELL********--}}
			@if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
			<td class="cell row-cell pointer" style="text-align: center" name="{{$id}}">
				<select style="width:100%" id="priority">
				<option value="{{\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_0')}}" {{($order['priority']==\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_0'))?'selected':''}}>0</option>
				<option value="{{\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_1')}}" {{($order['priority']==\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_1'))?'selected':''}}>1</option>
				<option value="{{\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_2')}}" {{($order['priority']==\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_2'))?'selected':''}}>2</option>
				<option value="{{\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_3')}}" {{($order['priority']==\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_3'))?'selected':''}}>3</option>
				</select>
				/
				<select style="width:100%" id="drop_priority">
				<option value="{{\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_0')}}" {{($order['drop_priority']==\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_0'))?'selected':''}}>0</option>
				<option value="{{\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_1')}}" {{($order['drop_priority']==\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_1'))?'selected':''}}>1</option>
				<option value="{{\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_2')}}" {{($order['drop_priority']==\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_2'))?'selected':''}}>2</option>
				<option value="{{\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_3')}}" {{($order['drop_priority']==\Illuminate\Support\Facades\Config::get('constants.ORDER_PRIORITY_3'))?'selected':''}}>3</option>
				</select>
			</td>
			@elseif(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
			<td class="cell row-cell pointer" style="color:{{$fontcolor}};text-align: center" name="{{$id}}">
				{{$order['priority'].'/'.$order['drop_priority']}}
			</td>
			@endif
			{{--********Priority CELL END********--}}
			{{--      ********Date CELL********       --}}
			@if(\Auth::user()->role != \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
			<td class="cell row-cell pointer" style="color:{{$fontcolor}}};text-align: center">
				<label style="color: {{$fontcolor}}">{{date('d-m-Y',strtotime($order->created_at)+(60*60*env('UTC_PLUS')))}}</label>
			</td>
			@endif
			{{--      ********Date CELL END********       --}}
			{{--      ********Select Manager CELL********       --}}
			@if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
			<td class="cell row-cell pointer" name="{{$id}}">
				@if($order['status']== \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_APPROVED') || $order['status'] > \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_DELETED'))
				<select style="width:100%" id="assignManager">
				@if($order['manager_id']==null)
				<option value="" {{($order['manager_id']==null)?'selected':''}}>{{"לא נבחר שליח!"}}</option>
				@endif
				@foreach($managers as $manager)
                    @if(count($manager->attendances)>0 && !is_null($manager->attendances) && !empty($manager->attendances))
                        <option value="{{$manager['id']}}" {{($order['manager_id']==$manager['id'])?'selected':''}} color="black">{{$manager['name']}}</option>
                    @endif
				@endforeach
				</select>
				@else
				<font color="white">{{'לא אושר עדיין.'}}</font>
				@endif
			</td>
			@endif
			{{--      ********Select Manager CELL END********       --}}
			{{--      ********Customer/Company Name CELL********       --}}
			@if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_CUSTOMER') || \Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
			<td style="color:{{$fontcolor}};" class="cell row-cell pointer" onclick='seeDetail("{{$id}}")'>@if(is_null($order->customer_name)){{"N.A"}}@else{{$order->customer_name}}@endif</td>
			@else
			<td style="color:{{$fontcolor}};" class="cell row-cell pointer" onclick='seeDetail("{{$id}}")'>@if(is_null($order->customer->company_name)){{"N.A"}}@else{{$order->customer->company_name}}@endif</td>
			@endif
			{{--      ********Customer/Company Name CELL END********       --}}
			{{--      ********Customer Address CELL********       --}}
			@if(\Auth::user()->role != \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
			<td style="color:{{$fontcolor}};" class="cell row-cell pointer" onclick="seeDetail('{{$id}}')">
			    @if($order->address)
			        {{$order->address.', '}}
			    @endif
				@if($order->street)
				{{$order->street->name.', '.$order->street->city->name}}
				@endif
			</td>
			@endif
			{{--      ********Customer Address CELL END********       --}}
			{{--      ********Delivery Time CELL********       --}}
			<td style="color:{{$fontcolor}};" class="cell row-cell pointer" align="center" onclick="seeDetail('{{$id}}')">
				@if($diff > 0 && $order->status != \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_REACH_CUSTOMER'))
				    <div style="margin: auto 1.5em; display: inline-block;font-weight:bold;font-size:100%" class="timer" data-seconds-left={{$diff}}></div>
				@else
				    00:00:00
				@endif
			</td>
			{{--      ********Delivery Time CELL END********       --}}
			{{--********Status Button********--}}
			@if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
			<td class="cell row-cell pointer" align="center">
				@include('orders.status_button')
			</td>
			@endif
			{{--********Status Button END********--}}
		</tr>
		{{--POPUP IF MANAGER--}}
		@if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))
		@include('orders.manager_popup')
		@endif
		{{--POPUP FOR EVERYONE--}}
		@include('orders.popup')
		@endforeach
	</table>
	@else
	<h2 align="center">אין הזמנות כרגע</h2>
	@endif
	<!--Scroll Box End-->
</div>
{!! $orders->render() !!}
<script type="text/javascript">
	function initializeTimer(){
    	    $('.timer').startTimer({
    	      onComplete: function(){
    	      }
    	    });
	}
	@if((\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN') || \Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER')))
            refresh = setTimeout( function(){
                            $('#view_orders').click();
                          }  , 60000 );
        @endif
</script>