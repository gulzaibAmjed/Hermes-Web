<style type="text/css">
  .table-section .data-table .data-row .cell{
  width: 25%;
  }
  .table-section .data-table .table-head .cell{
  width: 25%;
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
      <span class="icon fa fa-bar-chart"></span>
      <br>
      <span class="text">יישוב</span>
    </div>
    <div class="head-cell cell">
      <span class="icon fa fa-bar-chart"></span>
      <br>
      <span class="text">שכונה</span>
    </div>
    <div class="head-cell cell">
      <span class="icon fa fa-bar-chart"></span>
      <br>
      <span class="text">רחוב</span>
    </div>

  <!--Scroll Box-->
  @if(count($data)>0)
  <table class="table-body" id="table">
    @foreach($data as $dataRow)
    <tr class="data-row">
      <td class="cell row-cell pointer">
        <!-- <a href="javascript:void(0)" onclick="">
          <i class="fa fa-times fa-2x"></i>
        </a> --> <!-- &nbsp;  -->
        <a href="javascript:void(0)" onclick="editLocation({{$dataRow->id}})">
          <i class="fa fa-pencil-square-o fa-2x"></i>
        </a>
      </td>
      <td class="cell row-cell pointer">
        {{$dataRow->city->name}}
      </td>
      <td class="cell row-cell pointer">
        {{$dataRow->neighbourhood->name}}
      </td>
      <td class="cell row-cell pointer">
        {{$dataRow->name}}
      </td>
    </tr>
    @endforeach
  </table>
  @else
  <h2 align="center"> אין רחובות כרגע</h2>
  @endif
  <!--Scroll Box End-->
</div>
{!! $data->render() !!}