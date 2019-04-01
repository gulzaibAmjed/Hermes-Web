
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
    <i class="page-name pull-left" onclick=""><i id="expand_i" class="fa fa-expand">&nbsp&nbsp פרטים</i></i>
    @if(1==2)
    <h3 class="page-name pull-right">All Orders</h3>
    <i class="fa fa-cog page-name pull-right" onclick="showFilterDiv()"> &nbsp;&nbsp;&nbsp; </i>
    @endif
  </header>

  <!--All Games / table Section-->
   <div class="form-group">
    <div class="form-field-box" style="margin-left: 40%">
    <!-- <input type="text" name="street" value="" placeholder="Start Typing..." id="street" autocomplete="off" > -->
      <select id="managers" name="managers" class="" align="center" style=" width: 30%">
          @foreach($managers as $key=>$manager)
              <option value="" selected>בחר עובד...</option>
              <option value="{{$manager->id}}">{{$manager->company_name}}</option>
          @endforeach
      </select>
    </div>
  </div>
  <section class="all-games table-section">
<h2 align="center"> לא נבחר לקוח</h2>

  </section>
<script type="text/javascript">
    $(document).ready(function(){
                $('#managers').select2({
                    placeholder: "בחר...",
                    allowClear: true,
                    maximumSelectionLength: 2
                }).on("change", function(){
                    pricing($(this).val());
                });
                });

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
            },
        });
    }
</script>
