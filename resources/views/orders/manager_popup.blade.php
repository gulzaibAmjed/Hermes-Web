<tr class="data-row clearfix " id='{{$id}}' style="background-color: transparent;  display: none">
    <td  class="cell row-cell" style="width: 90%; background-color: #e3e3e3; border-radius: 20px; margin: 4%;">
        <div id="detail"  style=" padding: 10px;" >
            <button type="button" class="btn btn-danger pull-left" onclick="seeDetail()"><span class="fa fa-close"></span></button>
            <table style="width: 50%; margin-left: 35%  " class="table">
                  <tr>
                      <th style="text-align: center">
                          <label><strong>סטטוס <i class="fa fa-list"></i></strong></label>
                      </th>
                      <th style="text-align: center">
                          <label><strong>שם  כתובת <i class="fa fa-map-marker"></i> </strong></label>
                      </th>
                      <th style="text-align: center">
                          <label><strong>חברה מספר <i class="fa fa-phone"></i></strong></label>
                      </th>
                      <th style="text-align: center">
                          <label><strong>איסוף/הורדה <i class="fa fa-exclamation-triangle"></i></strong></label>
                      </th>
                     
                  </tr>
                  <tr>
                      <td style="text-align: center">
                          <?php 
                          switch ($order->status) {
                            
                            case Config::get('constants.ORDER_STATUS_ASSIGNED'):
                              $value = "קיבלת משלוח חדש.";
                              break;
                            case Config::get('constants.ORDER_STATUS_ACCEPTED_BY_MANAGER'):
                              $value = "התקבל על ידי שליח";
                              break;
                            case Config::get('constants.ORDER_STATUS_REJECTED_BY_MANAGER'):
                              $value = "נדחה על ידי שליח";
                              break;
                            case Config::get('constants.ORDER_STATUS_PROCESS_START'):
                              $value = "שליח בדרך.";
                              break;
                            case Config::get('constants.ORDER_STATUS_REACH_RESTAURANT'):
                              $value = "שליח הגיע לחברה.";
                              break;
                            case Config::get('constants.ORDER_STATUS_LEAVE_RESTAURANT'):
                              $value = "שליח עזב חברה.";
                              break;
                            case Config::get('constants.ORDER_STATUS_REACH_CUSTOMER'):
                              $value = "שליח הגיע ללקוח.";
                              break;
                            case Config::get('constants.ORDER_STATUS_REACH_DELIVERED'):
                              $value = "בוצע בהצלחה.";
                              break;

                            default:
                            $value = "n/a";
                              $status = '';
                              break;
                          }
                          ?>
                          <label>{{$value}}</label>
                      </td>
                      <td style="text-align: center">
                          <label>{{$order->customer->address}}</label>
                      </td>
                      <td style="text-align: center">
                          <label>{{$order->customer->contact_number}}</label>
                      </td>
                      <td style="text-align: center">
                          <label>{{$order->priority}}/{{$order->drop_priority}}</label>
                      </td>
                     
                  </tr>
              </table>
            <label>
                <strong><i class="fa fa-commenting-o"></i> הערות</strong>
            </label>
            <p>
                {{$order->comments}}
            </p>
</div>
</td>
</tr>