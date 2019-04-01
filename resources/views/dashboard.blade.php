@extends('layouts.master')
@section('content')
@stop

@section('scripts')
<script type="text/javascript">
//On loading firstly it will show orders...
	$(document).ready(function(){
		switch({{$role}}) {
		    case {{\Illuminate\Support\Facades\Config::get('constants.USER_ROLE_CUSTOMER')}}:
		        $('#view_orders').click();
		        break;
		    case {{\Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN')}}:
		        $('#view_orders').click();
		        break;
		    case {{\Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER')}}:
		        $('#view_jobs').click();
		        break;
		}
	});
</script>
@stop