<style type="text/css">
	.table-section .data-table .data-row .cell{
	width: 20%;
	}
	.table-section .data-table .table-head .cell{
	width: 20%;
	}
</style>
<div class="data-table six-column">
	<!--Head-->
	<div class="table-head clearfix">
		<div class="head-cell cell">
			<span class="icon fa fa-clock-o"></span></br>
			<span class="text">שעות</span>
		</div>
		<div class="head-cell cell">
			<span class="icon fa fa-clock-o"></span></br>
			<span class="text">תאריך סיום</span>
		</div>
		<div class="head-cell cell">
			<span class="icon fa fa-clock-o"></span></br>
			<span class="text">תאריך התחחלה</span>
		</div>
		<div class="head-cell cell">
			<span class="icon fa fa-calendar"></span></br>
			<span class="text">תאריך</span>
		</div>
		<div class="head-cell cell">
			<span class="icon fa fa-book"></span></br>
			<span class="text">שפ</span>
		</div>
	</div>
	<!--Scroll Box-->
	<?php $total = 0?>
	@if(count($employees)>0)
	<table class="table-body" id="pricing_table">
		@foreach($employees as $employee)
		@foreach($employee['attendances'] as $attendance)
		<tr class="data-row">
			<td class="cell row-cell pointer">
				<?= round($attendance->hours,2) ?>
				<?php $total = $total + $attendance->hours; ?>
			</td>
			<td class="cell row-cell pointer">
				@if($attendance->stop == '0000-00-00 00:00:00')
				<?= '00:00:00'?>
			@else
			   <?php $stop_time = strtotime($attendance->stop) + (60*60*env('UTC_PLUS'));?>
			    <?= date('H:i:s',$stop_time) ?>
			@endif
			</td>
			<td class="cell row-cell pointer">
	    		<?php $start_time = strtotime($attendance->start) + (60*60*env('UTC_PLUS'));?>
				<?= date('H:i:s',$start_time) ?>
			</td>
			<td class="cell row-cell pointer">
    			<?php $date = strtotime($attendance->created_at) + (60*60*env('UTC_PLUS'));?>
				<?= date('d-m-Y',$date) ?>
			</td>
			<td class="cell row-cell pointer">
				{{$employee->name}}
			</td>
		</tr>
		@endforeach
		@endforeach
	</table>
	@else
	<h2 align="center">אין מופעים כרגע.</h2>
	@endif
	<?php
	$total = round($total,2);
	?>
	<div class='form-field-box pull-left well'>
		<h3>
			סיכום<br><br> 
			<h5>ימים: {{$diff}} <br> שעות: {{$total}} </h5>
		</h3>
	</div>
	<!--Scroll Box End-->
</div>