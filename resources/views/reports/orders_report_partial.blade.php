<style type="text/css">
    .table-section .data-table .data-row .cell{
    width: 20%;
    }
    .table-section .data-table .table-head .cell{
    width: 20%;
    }
</style>
<div class="data-table six-column">
    <!--Head-->
    <div class="table-head clearfix">
        <div class="head-cell cell">
            <span class="icon fa fa-money"></span><br>
            <span class="text">מחיר</span>
        </div>
        <div class="head-cell cell">
            <span class="icon fa fa-money"></span><br>
            <span class="text">אמצעי תשלום</span>
        </div>
        <div class="head-cell cell">
            <span class="icon fa fa-times"></span><br>
            <span class="text">תאריך</span>
        </div>
        <div class="head-cell cell">
            <span class="icon fa fa-user"></span><br>
            <span class="text">לקוח</span>
        </div>
        <div class="head-cell cell">
            <span class="icon fa fa-user"></span><br>
            <span class="text">שם חברה</span>
        </div>
    </div>
    <!--Scroll Box-->
    <?php $total = 0?>
    <?php $totalOrders = 0?>
    @if(count($orders)>0)
    <table class="table-body" id="pricing_table">
        @foreach($orders as $order)
        <?php $totalOrders++; ?>
        <?php
            if(count($order->street->price)>0){
                $total=$total+$order->street->price->price;
            }else{
                $total=$total+0;
            }
            
        ?>
        <tr class="data-row" onclick='seeDetail("{{$order->id}}")'>
            <td class="cell row-cell pointer">
            @if(count($order->street->price)>0)
                {{$order->street->price->price}}
            @else
                {{'n/a'}}
            @endif
            </td>
            <td class="cell row-cell pointer">
                <?php
                    if ($order->payment_method == Illuminate\Support\Facades\Config::get('constants.PAYMENT_METHOD_CREDIT')) {
                        echo 'Credit';
                    }else{
                        echo 'Cash';
                    }
                    ?>
            </td>
            <td class="cell row-cell pointer">
                <?= date('d-m-Y',(strtotime($order->created_at) + (60*60*env('UTC_PLUS')))) ?>
            </td>
            <td class="cell row-cell pointer">
                {{$order->customer_name}}
            </td>
            <td class="cell row-cell pointer">
                {{$order->customer->company_name}}
            </td>
        </tr>
        <tr class="data-row clearfix " id='{{$order->id}}' style="background-color: transparent;  display: none">
            <td class="cell row-cell" style="width:100%">
                <table class="table-body" id="pricing_table">
                    <h3>Order lifecycle</h3>
                    @foreach($order['jobTimes'] as $timeStamp)
                    <tr class="data-row">
                        <td class="cell row-cell"  style="width:50%">
                            <?php 
                          switch ($timeStamp->status) {
                            
                            case Config::get('constants.ORDER_STATUS_PENDING'):
                              echo "Created";
                              break;
                            case $order->status == Config::get('constants.ORDER_STATUS_APPROVED'):
                            case $order->status == Config::get('constants.ORDER_STATUS_APPROVED+5'):
                            case $order->status == Config::get('constants.ORDER_STATUS_APPROVED+10'):
                            case $order->status == Config::get('constants.ORDER_STATUS_APPROVED+15'):
                              echo "Accepted by Admin.";
                              break;
                            case Config::get('constants.ORDER_STATUS_CANCELED'):
                              echo "Rejected by Admin.";
                              break;
                            case Config::get('constants.ORDER_STATUS_DELETED'):
                              echo "Removed.";
                              break;
                            case Config::get('constants.ORDER_STATUS_ASSIGNED'):
                              echo "Assigned to You.";
                              break;
                            case Config::get('constants.ORDER_STATUS_ACCEPTED_BY_MANAGER'):
                              echo "Accepted By You.";
                              break;
                            case Config::get('constants.ORDER_STATUS_REJECTED_BY_MANAGER'):
                              echo "Rejected By You.";
                              break;
                            case Config::get('constants.ORDER_STATUS_PROCESS_START'):
                              echo "Process Started.";
                              break;
                            case Config::get('constants.ORDER_STATUS_REACH_RESTAURANT'):
                              echo "Reach Restaurant.";
                              break;
                            case Config::get('constants.ORDER_STATUS_LEAVE_RESTAURANT'):
                              echo "Leave Customer.";
                              break;
                            case Config::get('constants.ORDER_STATUS_REACH_CUSTOMER'):
                              echo "Reach Customer.";
                              break;
                            case Config::get('constants.ORDER_STATUS_DELIVERED'):
                              echo "Delivered.";
                              break;
                            case Config::get('constants.ORDER_STATUS_FINISHED'):
                              echo "Finished.";
                              break;

                            default:
                            echo "n/a";
                              break;
                          }
                          ?>
                        </td>
                        <td  style="width:50%">
                            <?= date('Y-m-d H:i:s',strtotime($timeStamp->time) + (60*60*env('UTC_PLUS'))); ?>
                            <?php
                                // $gmtTimezone = new \DateTimeZone('GMT');
                                // $myDateTime = new \DateTime(date('Y-m-d h:i:s'), $gmtTimezone);
                                // var_dump($myDateTime);
                            ?>
                        </td>
                    </tr>
                    @endforeach
                </table>
                                    <h3>***</h3>
            </td>
        </tr>
        @endforeach
    </table>
    @else
    <h2 align="center">אין מופעים כרגע.</h2>
    @endif
    <div class='form-field-box pull-left well'>
        <h3>
            סיכום<br><br> 
            <h5>סהכ הזמנות : {{$totalOrders}} <br> סהכ מחיר: {{$total}} </h5>
        </h3>
    </div>
    <!--Scroll Box End-->
</div>

<script type="text/javascript">

</script>
