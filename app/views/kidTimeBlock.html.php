<div class="item-title"><?=$lg_time_to_play?></div>
<div class="item-time ">
	<div class="d-flex justify-content-around">
		<div id="kidTime" class="items-time__display"><?=$kidTime?></div>
		<img class="item-time__img" src="/gaintimeoff/img/setTime-32.png" onclick="location.href='./set-time';">	
	</div>
	<div class="item-time__playing d-flex justify-content-center">
		<div><?=$lg_time_played?>:</div>
		<input id="inputTime" type="time" name="timeForGame" oninput="deleteBorderStyle(this)" />
		<img class="item-time__img" src="/gaintimeoff/img/updated-24.png" onclick="handlerTimePlay('<?=$kidName?>')">
	</div>
</div>