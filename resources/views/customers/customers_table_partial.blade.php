<style type="text/css">
    .table-section .data-table .data-row .cell{
        width: 20%;
    }

    .table-section .data-table .table-head .cell{
        width: 20% ;
    }
</style>

<div class="data-table six-column">
                            
                            <!--Head-->
                            <div class="table-head clearfix">
                                <div class="head-cell cell">
                                    <span class="icon fa fa-cogs"></span>
                                    <br>
                                    <span class="text">פעולות</span>
                                </div>

                                <div class="head-cell cell">
                                    <span class="icon fa fa-user"></span><br>
                                    <span class="text">שם חברה</span>
                                </div>
                                <div class="head-cell cell">
                                    <span class="icon fa fa-location-arrow"></span>
                                    <br>
                                    <span class="text">כתובת</span>
                                </div>

                                <div class="head-cell cell">
                                    <span class="icon fa fa-globe"></span>
                                    <br>
                                    <span class="text">אתר</span>
                                </div>

                                <div class="head-cell cell">
                                    <span class="icon fa fa-phone"></span>
                                    <br>
                                    <span class="text">מספר טלפון</span>
                                </div>
                            </div>
                            <!--Scroll Box-->
                            @if(count($customers)>0)
                                <table class="table-body" id="table">
                            @foreach($customers as $customer)
                                    <tr class="data-row">
                                        <?php $id = Vinkla\Hashids\Facades\Hashids::encode($customer->id);?>
                                        <td class="cell row-cell pointer"><a href="javascript:void(0)" onclick="editCustomer('{{$customer->user_id}}');"><i class="fa fa-pencil-square-o fa-2x"></i></a></td>
                                        <td class="cell row-cell pointer" onclick="seeDetail('{{$id}}')">@if(is_null($customer->company_name)){{"N.A"}}@else{{$customer->company_name}}@endif</td>
                                        <td class="cell row-cell pointer" onclick="seeDetail('{{$id}}')">@if(is_null($customer->address)){{"N.A"}}@else{{$customer->address}}@endif</td>
                                        <td class="cell row-cell pointer" onclick="seeDetail('{{$id}}')">@if(is_null($customer->website)){{"N.A"}}@else{{$customer->website}}@endif</td>
                                        <td class="cell row-cell pointer" onclick="seeDetail('{{$id}}')">@if(is_null($customer->contact_number)){{"N.A"}}@else{{$customer->contact_number}}@endif</td> 
                                            <!-- <i class="fa fa-star"></i> -->
                                    </tr>

                                    <tr class="data-row clearfix " id='{{$id}}' style="background-color: transparent;  display: none">
                                        <td  class="cell row-cell" style="width: 90%; background-color: #e3e3e3; bmanager-radius: 20px; margin: 4%;">
                                            <div id="detail"  style=" padding: 10px;" >
                                                <button type="button" class="btn btn-danger pull-left" onclick="seeDetail('{{$id}}')"><span class="fa fa-close"></span></button>
                                                <table style="width: 70%; margin-left: 25%  " class="table">
                                                    <tr>
                                                        <th style="text-align: center">
                                                            <label><strong><i class="fa fa-list"></i> שם עסק</strong></label>
                                                        </th>
                                                        <th style="text-align: center">
                                                            <label><strong><i class="fa fa-calendar-o"></i> אתר</strong></label>
                                                        </th>
                                                        <th style="text-align: center">
                                                            <label><strong><i class="fa fa-calendar-o"></i> אי מייל</strong></label>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center">
                                                            <label>
                                                                {{$customer->company_name}}
                                                            </label>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <label>{{$customer->website}}</label>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <label>{{$customer['user']['email']}}</label>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <label><strong><i class="fa fa-commenting-o"></i> כתובת</strong></label>
                                                <p>{{$customer->address}}</p>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                                </table>
                                @else
                                    <h2 align="center">אין לקוחות עכשיו.</h2>
                                @endif
                            <!--Scroll Box End-->
                        </div>

                    {!! $customers->render() !!}

                    <script>
                    function editCustomer(id){
                        $.ajax({
                            type: 'GET',
                            url: 'customers/' + id + '/edit',
                            beforeSend: function () {
                                // this is where we append a loading image
                            },
                            success: function (data) {
                                // successful request; do something with the data
                                var content = '<li>edit Customer</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp;'+ '<?php echo "עמוד הבית";?>'+' </a></li>';
                                $('#page_path').html(content);
                                $('.content-area').html(data['data']);
                            },
                            error: function (data) {
                                // failed request; give feedback to user
                                notif({
                                    msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                                    position: "center",
                                    time: 10000
                                });
                            }
                        });
                    }

                    </script>