<div class="data-table six-column">
                            
                            <!--Head-->
                            <div class="table-head clearfix">
                                <div class="head-cell cell">
                                    <span class="icon fa fa-cogs"></span>
                                    <br>
                                    <span class="text">פעולות</span>
                                </div>

                                <div class="head-cell cell">
                                    <span class="icon fa fa-bar-chart"></span>
                                    <br>
                                    <span class="text">סטטוס</span>
                                </div>

                                <div class="head-cell cell">
                                    <span class="icon fa fa-user"></span>
                                    <br>
                                    <span class="text">שם</span>
                                </div>


                                <!-- <div class="head-cell cell">
                                    <span class="icon fa fa-calendar"></span>
                                    <p class="sort-by">
                                        <a href="#" class="fa fa-caret-up"></a>
                                        <a href="#" class="fa fa-caret-down"></a>
                                    </p><br>
                                    <span class="text">Date</span>
                                </div> -->
                            </div>
                            <!--Scroll Box-->
                            @if(count($managers)>0)
                                <table class="table-body" id="table">
                            @foreach($managers as $manager)
                            <?php $attendance = $manager->attendances->first();?>
                                    <tr class="data-row">
                                        <?php $id = Vinkla\Hashids\Facades\Hashids::encode($manager->id);?>
                                                <td class="cell row-cell pointer"><a href="javascript:void(0)" onclick="editManagerView('{{$id}}');"><i class="fa fa-pencil-square-o fa-2x"></i></a></td>
                                        <td class="cell row-cell pointer" onclick="seeDetail('{{$id}}')">
                                            @if(!is_null($attendance) && $attendance->stop == '0000-00-00 00:00:00')
                                                {{"פָּעִיל"}}
                                            @else
                                                {{"לֹא פָּעִיל"}}
                                            @endif
                                        </td>
                                        <td class="cell row-cell pointer" onclick="seeDetail('{{$id}}')">@if(is_null($manager->name)){{"N.A"}}@else{{$manager->name}}@endif</td>
                                    </tr>
                                @endforeach
                                </table>
                                @else
                                    <h2 align="center"> אין שליחים כרגע</h2>
                                @endif
                            <!--Scroll Box End-->
                        </div>

                    {!! $managers->render() !!}