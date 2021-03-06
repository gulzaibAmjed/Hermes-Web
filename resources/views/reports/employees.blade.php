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
    .content-area{
    /*height: ;*/
    }
    input[type=checkbox], input[type=radio] {
    vertical-align: middle;
    position: relative;
    bottom: 1px;
    }
</style>
<div class="main-content" id="div_main" style="">
<div class="forms" style="margin-top: 8px">
    <div class="form-group">
        <form name="employeeReportForm" id="employeeReportForm" action="#">
<div class="" style="width:100%;float: left;display: inline-block;white-space: nowrap;margin-left: 10%;margin-right: -46%">
            <input type="checkbox" name="all_employees" id="all_employees" style="margin-left: 10px">
            <label for="all_employees">צור דוח</label>
            <input type="text" name="end_date" id="end_date" value="" placeholder="תאריך סיום" style="width: 20%;margin-left: 10px">
            <input type="text" name="start_date" id="start_date" value="" placeholder="תאריך התחחלה" style="width: 20%; margin-left: 10px">
</div>
            <div class="form-field-box" style="margin-left:2%;width:20%;float: left;display: inline-block;white-space: nowrap">
                            <select id="employees" name="employees" class="" align="center" style="">
                                <option value="" selected>{{"בחר..."}}</option>
                                <option value="" name="all" id="all" selected>בחר הכל</option>
                                @foreach($managers as $key=>$manager)
                                <option value="{{$manager->id}}">{{$manager->name}}</option>
                                @endforeach
                            </select>
                        </div>
            <br>
            <button id="addOrder" class="btn btn-danger btn-place-order" value="Save" type="submit" style="margin-top: 15px">צור דוח</button>
        </form>
    </div>
    <br><br>
</div>
<section class="all-games table-section">
    <br>
    <br>
    <br>
    <br>
</section>
<script type="text/javascript">
    $(document).ready(function(){
    $('#start_date').datetator({
    	useDimmer: true,
    	placeholder: "תאריך התחחלה"
    });
    $('#end_date').datetator({
      	useDimmer: true
      });
    $('#employees').select2({
        placeholder: "בחר עובד ...",
        allowClear: true,
        maximumSelectionLength: 2
    })
    });
    
    $('#datetator_start_date').attr('placeholder','תאריך התחחלה');
    $('#datetator_end_date').attr('placeholder','תאריך סיום');

    $(document).on('submit','#employeeReportForm',function(e){
        e.preventDefault()
        var id = $('#employees').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        if($('#all_employees').is(':checked')){
            var all = 1;
        }else{
            var all = 0;
        }
        $.ajax({
        type: 'POST',
        url: 'employeesReport',
        data: {"id": id, 'start_date': start_date, 'end_date': end_date, 'all': all},
        success: function (data) {
            // successful request; do something with the data
            if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                $('.table-section').html(data['data']);
            }else{
            console.log(data['data']);
                notif({
                    msg: data['data'],
                    position: "center",
                    time: 10000
                });
            }
            // $('#view_orders').click();
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                position: "center",
                time: 10000
            });
            // $('#view_orders').click();
        }
    });
    
    });
    
    $('#all_employees').on('change',function(){
    if($('#all_employees').is(':checked')){
            $('#employees').attr('disabled','disabled');
        }else{
            $('#employees').removeAttr('disabled');
        }
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
            }
        });
    }
</script>