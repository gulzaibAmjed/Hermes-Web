
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
  <!--All Games / table Section-->
   <div class="form-group">
    <div class="form-field-box" style="margin-left: 40%">
    <!-- <input type="text" name="street" value="" placeholder="Start Typing..." id="street" autocomplete="off" > -->
      <select id="customers" name="customers" class="" align="center" style=" width: 30%">
          @foreach($customers as $key=>$customer)
              <option value="" selected>{{"בחר..."}}</option>
              <option value="{{$customer->id}}">{{$customer->company_name}}</option>
          @endforeach
      </select>
    </div>
  </div>
  <section class="all-games table-section">
<br>
<br>
<br>
<br>

  </section>
<script type="text/javascript">
    $(document).ready(function(){
                $('#customers').select2({
                    placeholder: "בחר ...",
                    allowClear: true,
                    maximumSelectionLength: 2
                }).on("change", function(){
                    addOrderView($(this).val(),1);
                });
                });
</script>
