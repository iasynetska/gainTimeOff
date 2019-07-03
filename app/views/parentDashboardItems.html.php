<div class="container d-flex flex-column justify-content-center align-items-center">
	<div class="items-time d-flex flex-column justify-content-center align-items-center">
		<div class="item-title"><?=$lg_time_to_play?></div>
		<div class="item-time d-flex justify-content-around">
			<div class="items-time__display"><?=$kidTime?></div>
			<img class="item-new__img" src="/gaintimeoff/img/setTime-32.png" onclick="location.href='./set-time';">	
		</div>
	</div>
	<div class="items-block d-flex flex-wrap justify-content-center">
		<div class="item d-flex flex-column justify-content-center align-items-center">
			<div class="item-title"><?=$lg_school_subjects?></div>
			<?php if(empty($subjects)):?>
    			<img class="item-new__img" src="/gaintimeoff/img/plus-32.png" onclick="location.href='./adding-subjects-marks?kidName=<?=$kidName?>';">
    			<div class="item-add"><?=$lg_create_new?></div>
			<?php else:?>
    			<div class="item-subjects d-flex justify-content-between">
    		    	<select class="item-subjects__list">
    		    	<option value = "0"><?=$lg_select_subject?></option>
        		    <?php foreach($subjects as $subject):?>
        		    	<option value = "<?=$subject->name?>"><?=$subject->name?></option>
    		    	<?php endforeach;?>
    		    	</select>
      				<img class="item-new__img" src="/gaintimeoff/img/plus-32.png" onclick="location.href='./adding-subjects-marks?kidName=<?=$kidName?>';">
    			</div>
    			
    			<div class="item-marks">
    				<div class="item-marks__title"><?=$lg_select_mark?>&#58;</div>
     				<fieldset>
         				<div class="item-marks__elements">
         					<?php foreach($marks as $mark):?>
                 				<input id="<?=$mark->name?>" type="radio" name="mark" value="<?=$mark->name?>" />
                 				<label for="6"><?=$mark->name?></label>
             				<?php endforeach;?>
         				</div>
     				</fieldset>
    			</div>
    			<input class="form__btn" type="submit" value="<?=$lg_save?>" />
			<?php endif;?>
		</div>
		
		<div class="item d-flex flex-column align-items-center">
			<div class="item-title"><?=$lg_tasks?></div>
			<?php if(empty($tasks)):?>
    			<img class="item-new__img" src="/gaintimeoff/img/plus-32.png" onclick="location.href='./adding-task';">
    			<div class="item-add"><?=$lg_create_new?></div>
			<?php else:?>
    			<div class="item-tasks d-flex justify-content-between">
    		    	<select class="item-tasks__list">
    		    	<option value = "0"><?=$lg_select_task?></option>
        		    <?php foreach($tasks as $task):?>
        		    	<option value = "<?=$task->name?>"><?=$task->name?></option>
    		    	<?php endforeach;?>
    		    	</select>
      				<img class="item-new__img" src="/gaintimeoff/img/plus-32.png" onclick="location.href='./adding-subject';">
    			</div>
    			<input class="form__btn" type="submit" value="<?=$lg_save?>" />
			<?php endif;?>
		</div>
	</div>
</div>