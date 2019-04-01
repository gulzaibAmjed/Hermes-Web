<tr class="data-row clearfix " id="{{$id}}" style="background-color: transparent;  display: none">
      <td  class="cell row-cell" style="width: 90%; background-color: #e3e3e3; border-radius: 20px; margin: 4%;">
        <div id="detail"  style=" padding: 10px;" >
        <button type="button" class="btn btn-danger pull-left" onclick="seeDetail('{{$id}}')"><span class="fa fa-close"></span></button>
          <table style="width: 90%; margin-left: 10%  " class="table">
            <tr>
            <th style="text-align: center">
                <label><strong><i class="fa fa-money"></i> {{"אמצעי תשלום"}}</strong></label>
            </th>
            @if(\Auth::user()->role != \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_CUSTOMER'))
            <th style="text-align: center">
                <label><strong><i class="fa fa-list"></i> {{"שם לקוח"}}</strong></label>
            </th>
            <th style="text-align: center">
                <label><strong><i class="fa fa-calendar-o"></i> {{"אי מייל"}}</strong></label>
            </th>
            <th style="text-align: center">
                <label><strong><i class="fa fa-calendar-o"></i> {{"טלפון"}}</strong></label>
            </th>
            @endif
            @if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
                <th style="text-align: center">
                    <label><strong><i class="fa fa-map-marker"></i> {{"כתובת"}}</strong></label>
                </th>
            @endif
            @if(!is_null($order->manager_id) && \Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
                <th style="text-align: center">
                  <label><strong><i class="fa fa-map-marker"></i> {{"מסלול שליח"}}</strong></label>
                </th>
            @endif
            </tr>
            <tr>
            <td style="text-align: center">
                            <label>
                              @if($order->payment_method == Config::get('constants.PAYMENT_METHOD_CREDIT'))
                                {{"כרטיס אשראי"}}
                              @else
                                {{"מזומן"}}
                              @endif
                            </label>
                          </td>
            @if(\Auth::user()->role != \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_CUSTOMER'))
              <td style="text-align: center">
                <label>
                    {{$order->customer_name}}
                </label>
              </td>
              <td style="text-align: center">
                <label>
                  {{$order->customer->user->email}}
                </label>
              </td>
              <td style="text-align: center">
              <label>
              {{$order->customer->contact_number}}
              </label>
              </td>
              @endif
              @if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
                <td style="text-align: center">
                    <label>
                        @if($order->address)
                            {{$order->address.', '}}
                        @endif
                        @if($order->street)
                            {{$order->street->name.', '.$order->street->city->name}}
                        @endif
                    </label>
                </td>
              @endif
              @if(!is_null($order->manager_id) && \Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))
                                <td style="text-align: center">
                                  <input type="button" class="btn btn-info track_manager" value="מַסלוּל" name="{{$order->manager_id}}" id="track_manager">
                                </td>
                            @endif
            </tr>
          </table>
          <label><strong><i class="fa fa-commenting-o"></i> הערות</strong></label>
          <p>{{$order->comments}}</p>
        </div>
      </td>
    </tr>