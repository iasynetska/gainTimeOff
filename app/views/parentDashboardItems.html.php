<div class="container d-flex flex-column justify-content-center align-items-center">
	<div class="items-time d-flex flex-column justify-content-center align-items-center">
		<div class="item-title"><?=$lg_time_to_play?></div>
		<div class="item-time d-flex justify-content-around">
			<div class="items-time__display"><?=$timeKid?></div>
			<img class="item-new__img" src="/gaintimeoff/img/setTime-32.png" onclick="location.href='./set-time';">	
		</div>
	</div>
	<div class="items-block d-flex flex-wrap justify-content-center">
		<div class="item d-flex flex-column justify-content-center align-items-center">
			<div class="item-title"><?=$lg_school_subjects?></div>
			<img class="item-new__img" src="/gaintimeoff/img/plus-32.png" onclick="location.href='./adding-subjects-marks';">
			<div class="item-add">Create new</div>
		</div>
		<div class="item d-flex flex-column align-items-center">
			<div class="item-title"><?=$lg_tasks?></div>
			<img class="item-new__img" src="/gaintimeoff/img/plus-32.png" onclick="location.href='./adding-task';">
			<div class="item-add">Create new</div>
		</div>
	</div>
</div>