<?php use core\TimeConverter?>

<div class="item-title"><?=$lg_school_subjects?></div>
<?php if(empty($subjects) && empty($marks)):?>
	<img class="item-new__img" src="/img/plus-32.png" onclick="location.href='./adding-subjects-marks?kidName=<?=$kidName?>';">
	<div class="item-add"><?=$lg_create_new?></div>
<?php else:?>
	<?php if(empty($subjects)):?>
		<div class="item-subjects__adding d-flex align-items-center">
			<div class="item-marks__title"><?=$lg_add_subjects_title?>&#58;</div>
			<img class="item-new__img" src="/img/plus-32.png" onclick="location.href='./adding-subjects-marks?kidName=<?=$kidName?>';">
		</div>
	<?php else:?>
		<div class="item-subjects">
			<div class="section d-flex justify-content-between">
				<select id="subjectsList" class="item-subjects__list" oninput="deleteBorderStyle(this)">
		    	<option value = "0"><?=$lg_select_subject?></option>
    		    <?php foreach($subjects as $subject):?>
    		    	<option value = "<?=$subject->name?>"><?=$subject->name?></option>
		    	<?php endforeach;?>
		    	</select>
  				<img class="item-new__img" src="/img/plus-32.png" onclick="location.href='./adding-subjects-marks?kidName=<?=$kidName?>';">
			</div>
		</div>
	<?php endif;?>
	<div class="item-marks">
	<?php if(empty($marks)):?>
		<div class="item-marks__adding d-flex align-items-center">
			<a class="form__link" href="/parent/adding-subjects-marks?kidName=<?=$kidName?>"><?=$lg_add_marks_title?></a>
		</div>
	<?php else:?>
		<div class="item-marks__title"><?=$lg_select_mark?>&#58;</div>
		<fieldset>
			<div id="marksList" class="item-marks__elements">
				<?php foreach($marks as $mark):?>
     				<input id="<?=$mark->name?>" type="radio" name="mark" value="<?=$mark->name?>" onclick="deleteBorderStyle(this.parentElement);" />
     				<label title="<?=TimeConverter::convertSecondsToTimeFormat($mark->gameTime)?>" for="<?=$mark->name?>"><?=$mark->name?></label>
 				<?php endforeach;?>
			</div>
		</fieldset>
	<?php endif;?>
	</div>
	<?php if(!empty($subjects) && !empty($marks)):?>
		<input class="form__btn" type="submit" value="<?=$lg_save?>" onclick="addReceivedMark('<?=$kidName?>');" />
	<?php endif;?>
<?php endif;?>