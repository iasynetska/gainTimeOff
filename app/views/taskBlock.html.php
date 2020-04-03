<?php use core\TimeConverter?>

<div class="item-title"><?=$lg_add_tasks_title?></div>
<div id = "inputTaskBlock" class="item-tasks d-flex flex-column">
    <div id="formTask" class="d-flex justify-content-between">
    	<input id="inputTask" placeholder="<?=$lg_new_task?>" type="text" name="task" min="2" max="20" oninput="deleteBorderStyle(this)" />
    	<input id="inputTime" type="time" name="timeForTask" oninput="deleteBorderStyle(this)" />
    	<img class="item-new__img" src="/img/checked-32.png" onclick="createNewElement('inputTask', 'inputTime')">
    </div>
	<div class='item__error'><?=$error_task?></div>
</div> 
<div class="item-tasks list-tasks__new">
	<div class="item-list">
		<ul id="itemList">
		</ul>
	</div>
</div>
<input class="form__btn" type="button" value="<?=$lg_save?>" onclick="handlerSavingNewTasks('<?=$kidName?>')" />
<div class="item-tasks list-tasks__old">
	<?php if(!empty($tasks)):?>
		<div class="item-tasks__title"><?=$lg_task_exist?>&#58;</div>
		<div class="item-list">
    		<ul>
    			<?php foreach($tasks as $task):?>
	    			<li class="item-list__existing" title="<?=TimeConverter::convertSecondsToTimeFormat($task->gameTime)?>"><?=$task->name?></li>
    			<?php endforeach;?>
    		</ul>
		</div>
	<?php endif;?>
</div>