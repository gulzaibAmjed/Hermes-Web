<style type="text/css">
    .pagination>.active>a,
    .pagination>.active>a:focus,
    .pagination>.active>a:hover,
    .pagination>.active>span, .pagination>.active>span:focus, 
    .pagination>.active>span:hover{
        z-index: 2;
        color: #fff;
        cursor: default;
        background-color: #C3322F;
        border-color: #C3323F;
    }
    .pagination>li>a:focus,
    .pagination>li>a:hover,
    .pagination>li>span:focus,
    .pagination>li>span:hover{
        color : #2d2d2d;
    }
    .pagination>li>a,
    .pagination>li>span{
        color : #2d2d2d;
        /*color: rgba(183, 51, 51, 0.88);*/
    }
</style>
<div class="main-content" id="div_main">
  <!--Page Title-->
  <header class="page-title clearfix">
    <i class="page-name pull-left" onclick="expandTable()"><i id="expand_i" class="fa fa-expand">&nbsp&nbsp פרטים נוספים</i></i>
    <h3 class="page-name pull-right">בכל ההזמנות</h3>
    <i class="fa fa-cog page-name pull-right" onclick="showFilterDiv()"> &nbsp;&nbsp;&nbsp; </i>
  </header>
  <?php
    $status_array = array(
      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_PENDING')=>"מחכה לאישור מהרמס",
      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_APPROVED')=>"אושר עי הרמס",
      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_DELETED')=>"בוטל עי אתה",
      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_CANCELED')=>"בוטל עי הרמס",

      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_ACCEPTED_BY_MANAGER')=>"מקובלת על מנהל",
      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_REJECTED_BY_MANAGER')=>"בוטל על ידי מנהל",

      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_PROCESS_START')=>"תַהֲלִיך התחיל",
      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_REACH_RESTAURANT')=>"שליח הגיע לעסק",
      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_LEAVE_RESTAURANT')=>"שליח עזב את העסק",
      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_REACH_CUSTOMER')=>"שליח הגיע לעסק",
      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_DELIVERED')=>"שליחות בוצעה בהצלחה",
      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_NOT_DELIVERED')=>"שליחות לא בוצעה",

      );
    ?>
    <div class="page-title clearfix filter_div" id="div_filter" >
    <form name="filter" id="filter" action="/filter" method="post">
    <input name="type" type="hidden" value="{{\Illuminate\Support\Facades\Config::get('constants.SEARCH_TYPE_ORDER')}}"></input>
        <div>
            <button type="button" class="btn btn-danger pull-left" onclick="showFilterDiv()"><span class="fa fa-close"></span></button>
            <input type="text" name="search" id="search" placeholder="הקלדלחיפוש" class="inp_txt">
            <label style="margin-right: 5px; color: #777777; margin-left: 10px;">בחר הכל</label>
            <input type="checkbox"  id="selecctall" name="selecctall" checked>
        </div>
        <button id="search_order" name="search_order" class="btn btn-danger btn-place-order" value="Save" type="button" style="margin-top: 15px">חיפוש</button>
        <label class="line"></label>
        <br>
        <table style="width: 90%" class="pull-right">
            <?php
            foreach ($status_array as $index => $status) {
                if ($index % 3 == 0) {
                    echo "<tr></tr>";
                }
                ?>
                <td class="filter_td">
                    <label style="margin-right: 5px;">{{$status}}</label>
                    <input class="checkbox1" type="checkbox" name="checkboxlist[]" checked value="{{$index}}">
                </td>
            <?php }
            ?>
        </table>
        </form>
    </div>
  <!--All Games / table Section-->
  <section class="all-games table-section">
    @include('orders.orders_table_partial')
  </section>
</div>
<script type="text/javascript">
    function getThings(page,is_search=0) {
        if (is_search) {
            var url = "search?page=" + page;
            var data = new FormData($('form[name="filter"]')[0]);
        }else{
            var url = "orders?page=" + page;
            var data = '';
        }
        $.ajax({
            url: url,
            data: data,
            success: function (data) {
                $('.table-section').html(data);
            },
            error: function (data) {
                notif({
                    msg: "<b>Oops!</b> שגיאה.  נסה שוב מאוחר יותר..",
                    position: "center",
                    time: 10000
                });
            }
        });
    }

    $('.track_manager').click(function(){

//        if(){
createSessionVariable('track_manager_id',$(this).attr('name'));
setTimeout(function(){
            $('#manager_location').click();
}, 1000);
//        }else{
//            alertify.alert('Note:','There is something wrong, please try again.');
//        }
    });
</script>
