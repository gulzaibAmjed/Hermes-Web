                
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
        <i class="page-name pull-left pointer" onclick="expandTable()"><i id="expand_i" class="fa fa-expand">&nbsp&nbsp פרטים</i></i>
        <h3 class="page-name pull-right">צפה בכל השליחים</h3>
        <i class="fa fa-cog page-name pull-right" onclick="showFilterDiv()"> &nbsp;&nbsp;&nbsp; </i>
    </header>


    <?php
    $status_array = array("מחכה לאישור מהרמס", "אושר עי הרמס", "בוטל עי חברה", "בוטל עי הרמס");
    ?>
    <div class="page-title clearfix filter_div" id="div_filter" >
        <div>
            <button type="button" class="btn btn-danger pull-left" onclick="showFilterDiv()"><span class="fa fa-close"></span></button>
            <input type="text" id="search" placeholder="הקלדלחיפוש" class="inp_txt">
            <label style="margin-right: 5px; color: #777777; margin-left: 10px;">בחר הכל</label>
            <input type="checkbox"  id="selecctall" checked>
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
                    <label style="margin-right: 5px;"><?= $status ?></label>
                    <input class="checkbox1" type="checkbox" name="checkboxlist" checked value="<?= $status ?>">
                </td>
            <?php }
            ?>
        </table>

    </div>

    <!--All Games / table Section-->
    <section class="all-games table-section">
        @include('managers.managers_table_partial')
    </section>
</div>

<script type="text/javascript">
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getThings(page);
    });

    function getThings(page) {
        $.ajax({
            url: "managers?page=" + page,
            success: function (data) {
                $('.table-section').html(data);
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
