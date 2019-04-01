
<form name="bulkLocations" id="bulkLocations" action="#" method="post" style="text-align: center">
	<input type="button" name="bulkButton" id="bulkButton" value="להעלות" class="btn btn-info" style="width: 300px; height:300px;  font-size: 35px;">
	<span style="display: none;"> 
	<input type="file" name="bulkFile" id="bulkFile" value="להעלות" class="btn btn-info" style="width: 300px; height:300px;  font-size: 35px;">
	</span>
</form>
<script type="text/javascript">
	$(document).on('click','#bulkButton',function(){
		$('#bulkFile').click();
	});
</script>
