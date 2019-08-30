<div class="container d-flex flex-column justify-content-center align-items-center">
	<div id="timeBlock" class="items-time d-flex flex-column justify-content-center align-items-center">
		<div class="item-title"><?=$lg_time_to_play?></div>
		<div class="item-time ">
			<div class="d-flex justify-content-around">
    			<div id="kidTime" class="items-time__display"><?=$kidTime?></div>
    			<img class="item-time__img" src="/gaintimeoff/img/setTime-32.png" onclick="location.href='./set-time';">	
    		</div>
    		<div class="item-time__playing d-flex justify-content-center">
    			<div><?=$lg_time_played?>:</div>
    			<input id="inputTime" type="time" name="timeForGame" oninput="removeBorderStyle(this)" />
    			<img class="item-time__img" src="/gaintimeoff/img/updated-24.png" onclick="handleTimePlay('<?=$kidName?>')">
			</div>
		</div>
	</div>
	<div class="items-block d-flex flex-wrap justify-content-center">
		<div class="item d-flex flex-column align-items-center">
			<div class="item-title"><?=$lg_school_subjects?></div>
			<?php if(empty($subjects) && empty($marks)):?>
    			<img class="item-new__img" src="/gaintimeoff/img/plus-32.png" onclick="location.href='./adding-subjects-marks?kidName=<?=$kidName?>';">
    			<div class="item-add"><?=$lg_create_new?></div>
			<?php else:?>
				<?php if(empty($subjects)):?>
    				<div class="item-subjects__adding d-flex align-items-center">
    					<div class="item-marks__title"><?=$lg_add_subjects_title?>&#58;</div>
    					<img class="item-new__img" src="/gaintimeoff/img/plus-32.png" onclick="location.href='./adding-subjects-marks?kidName=<?=$kidName?>';">
					</div>
				<?php else:?>
        			<div class="item-subjects d-flex justify-content-between">
        		    	<select id="subjectsList" class="item-subjects__list">
        		    	<option value = "0"><?=$lg_select_subject?></option>
            		    <?php foreach($subjects as $subject):?>
            		    	<option value = "<?=$subject->name?>"><?=$subject->name?></option>
        		    	<?php endforeach;?>
        		    	</select>
          				<img class="item-new__img" src="/gaintimeoff/img/plus-32.png" onclick="location.href='./adding-subjects-marks?kidName=<?=$kidName?>';">
        			</div>
    			<?php endif;?>
    			<div class="item-marks">
				<?php if(empty($marks)):?>
					<div class="item-marks__adding d-flex align-items-center">
						<a class="form__link" href="/gaintimeoff/parent/adding-subjects-marks?kidName=<?=$kidName?>"><?=$lg_add_marks_title?></a>
					</div>
				<?php else:?>
					<div class="item-marks__title"><?=$lg_select_mark?>&#58;</div>
     				<fieldset>
         				<div id="marksList" class="item-marks__elements">
         					<?php foreach($marks as $mark):?>
                 				<input id="<?=$mark->name?>" type="radio" name="mark" value="<?=$mark->name?>" />
                 				<label for="<?=$mark->name?>"><?=$mark->name?></label>
             				<?php endforeach;?>
         				</div>
     				</fieldset>
 				<?php endif;?>
    			</div>
    			<?php if(!empty($subjects) && !empty($marks)):?>
    				<input class="form__btn" type="submit" value="<?=$lg_save?>" onclick="myFunction('subjectsList', 'marksList', '<?=$kidName?>')" />
				<?php endif;?>
			<?php endif;?>
		</div>
		
		<div id="taskBlock" class="item d-flex flex-column align-items-center">
			<div class="item-title"><?=$lg_tasks?></div>
			<?php if(empty($tasks)):?>
    			<img class="item-new__img" src="/gaintimeoff/img/plus-32.png" onclick="location.href='./adding-tasks?kidName=<?=$kidName?>';">
    			<div class="item-add"><?=$lg_create_new?></div>
			<?php else:?>
    			<div class="item-tasks">
    				<div class="section d-flex justify-content-between">
        		    	<select id="tasksList" class="item-tasks__list" oninput="removeBorderStyle(this)">
            		    	<option value = "0"><?=$lg_select_task?></option>
                		    <?php foreach($tasks as $task):?>
                		    	<option value = "<?=$task->name?>"><?=$task->name?></option>
            		    	<?php endforeach;?>
        		    	</select>
          				<img class="item-new__img" src="/gaintimeoff/img/plus-32.png" onclick="location.href='./adding-tasks?kidName=<?=$kidName?>';">
      				</div>
    			</div>
    			<input id="btnSaveTask" class="form__btn" type="submit" value="<?=$lg_save?>" onclick="addComplitedTask('<?=$kidName?>')" />
			<?php endif;?>
		</div>
	</div>
</div>