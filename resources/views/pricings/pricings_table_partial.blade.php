<style type="text/css">
  .table-section .data-table .data-row .cell{
  width: 50%;
  }
  .table-section .data-table .table-head .cell{
  width: 50%;
  }
</style>

<div class="data-table six-column">
                            
                            <!--Head-->
                            <div class="table-head clearfix">
                                <div class="head-cell cell">
                                    <span class="icon fa fa-cogs"></span>
                                    <br>
                                    <span class="text">שכונה</span>
                                </div>

                                <div class="head-cell cell">
                                    <span class="icon fa fa-bar-chart"></span>
                                    <span class="text">Price</span>
                                </div>
                            </div>
                            <!--Scroll Box-->
                            @if(count($prices)>0)
                                <table class="table-body" id="pricing_table">
                            @foreach($prices as $price)
                            <?php
                                if(!empty($price->pricing)){
                                    $value = $price->pricing->price;
                                    $id = $price->pricing->id;
                                }else{
                                    $value = 0;
                                    $id = 0;
                                }
                            ?>
                                    <tr class="data-row">   
                                        <td class="cell row-cell pointer">
                                        {{$price->name}}
                                        </td>
                                        <td class="cell row-cell pointer">
                                        <input type="text" class="price" name="price" id="{{$id}}"  mid="{{$customer_id}}" lid="{{$price->id}}" value="{{$value}}"></input>
                                        </td>
                                    </tr>
                                @endforeach
                                </table>
                                @else
                                    <h2 align="center">No Locations Right Now.</h2>
                                @endif
                            <!--Scroll Box End-->
                        </div>

