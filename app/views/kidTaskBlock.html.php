<?php use core\TimeConverter?>

<div class="item-title"><?=$lg_tasks?></div>
<?php if(empty($tasks)):?>
	<img class="item-new__img" src="/gaintimeoff/img/plus-32.png" onclick="location.href='./adding-tasks?kidName=<?=$kidName?>';">
	<div class="item-add"><?=$lg_create_new?></div>
<?php else:?>
	<div class="item-tasks">
		<div class="section d-flex justify-content-between">
	    	<select id="tasksList" class="item-tasks__list" oninput="deleteBorderStyle(this)">
		    	<option value = "0"><?=$lg_select_task?></option>
    		    <?php foreach($tasks as $task):?>
    		    	<option value = "<?=$task->name?>"><?=$task->name?>&nbsp;&#8594;&nbsp;<?=TimeConverter::convertSecondsToTimeFormat($task->gameTime)?></option>
		    	<?php endforeach;?>
	    	</select>
			<img class="item-new__img" src="/gaintimeoff/img/plus-32.png" onclick="location.href='./adding-tasks?kidName=<?=$kidName?>';">
		</div>
	</div>
	<input id="btnSaveTask" class="form__btn" type="submit" value="<?=$lg_save?>" onclick="addCompletedTask('<?=$kidName?>');" />
<?php endif;?>