<div class="p-3 row">
	<div class="col d-flex flex-shrink-1 justify-content-center">
		<button type="button" class="btn button-calender" onclick="--dm; calendar(dm, dj, 'calendar');"><i class="bi-arrow-left-circle button-icon"></i></button>
	</div>
	<div class="col d-flex flex-grow-1 justify-content-center align-items-end">
		<h5 id="headline"></h5>
	</div>
	<div class="col d-flex flex-shrink-1 justify-content-center ">
		<button type="button" class="btn button-calender" onclick="++dm; calendar(dm, dj, 'calendar');"><i class="bi-arrow-right-circle button-icon"></i></button>
	</div>
</div>
<div class="row">
	<div class="col d-flex justify-content-center">
		<table id="calendar" class="table text-white border"> </table>
	</div>
</div>