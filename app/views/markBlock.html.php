<div class="item-title"><?=$lg_add_marks_title?></div>
<div id = "inputMarkBlock" class="item-marks d-flex flex-column">
    <div id="formMark" class="d-flex justify-content-between">
    	<input id="inputMark" placeholder="<?=$lg_new_mark?>" type="text" name="mark" min="1" max="2" maxlength="2" oninput="removeBorderStyle(this)" />
    	<input id="inputTime" type="time" name="timeForMarks" oninput="removeBorderStyle(this)" />
    	<img class="item-new__img" src="/gaintimeoff/img/checked-32.png" onclick="createNewElement('inputMark', 'inputTime')">
    </div>
	<div class='item__error'><?=$error_mark?></div>
</div> 
<div class="item-marks list-marks__new">
	<div class="item-list">
		<ul id="itemList">
		</ul>
	</div>
</div>
<input class="form__btn" type="button" value="<?=$lg_save?>" onclick="handleMarksChange('<?=$kidName?>')" />
<div class="item-marks list-marks__old">
	<?php if(!empty($marks)):?>
		<div class="item-marks__title"><?=$lg_mark_exist?>&#58;</div>
		<div class="item-list">
    		<ul>
    			<?php foreach($marks as $mark):?>
	    			<li class="item-list__existing"><?=$mark->name?> . " " . "\u2192" . <?=$mark->name?>/li>
    			<?php endforeach;?>
    		</ul>
		</div>
	<?php endif;?>
</div>