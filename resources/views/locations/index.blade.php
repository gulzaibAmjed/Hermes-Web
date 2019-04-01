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

    <i class="page-name pull-left" onclick="expandTable()"><i id="expand_i" class="fa fa-expand">&nbsp&nbsp פרטים</i></i>

    <h3 class="page-name pull-right">{{"בכל האיזורים"}}</h3>

    <i class="fa fa-cog page-name pull-right" onclick="showFilterDiv()"> &nbsp;&nbsp;&nbsp; </i>

  </header>

  <?php

    $status_array = array(

      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_PENDING')=>"City",

      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_APPROVED')=>"Street",

      \Illuminate\Support\Facades\Config::get('constants.ORDER_STATUS_DELETED')=>"Neighbourhood"

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

    @include('locations.locations_table_partial')

  </section>

</div>

<script type="text/javascript">

    function getThings(page) {

        $.ajax({

            url: "locations?page=" + page,

            success: function (data) {

                if (data['response'] == RESPONSE_STATUS_SUCCESS) {

                    $('.table-section').html(data['data']);

                }else{

                     notif({

                    msg: "<b>Oops!</b> שגיאה.  נסה שוב מאוחר יותר..",

                    position: "center",

                    time: 10000

                });

                }

                

            },

            error: function (data) {

                notif({

                    msg: "<b>Oops!</b> שגיאה.  נסה שוב מאוחר יותר..",

                    position: "center",

                    time: 10000

                });

            },

        });

    }

</script>

