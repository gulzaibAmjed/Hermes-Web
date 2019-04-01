
    <!--Main Content-->
    <div class="main-content">
    	<!--Main Error Box-->
    	 <!--Page Title-->
        <header class="page-title clearfix ">
            <h3 class="prof-id pull-right">{{"הזמנות"}} </h3>
        </header>
        
        <!--Content Area-->
        <div class="content-area" style="text-align: center">
    		<input type="button" @if($flag)onclick="stopJob({{$id}})" value="סיים דיווח" class="btn btn-error" @else onclick="startJob()" value="התחל דיווח" class="btn btn-info" @endif  style="width: 300px; height:300px;  font-size: 35px;">
        </div>


        <!--Content Area End-->
        
    </div><!--Main Content End-->