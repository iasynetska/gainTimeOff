<div class="item-title"><?=$lg_add_subjects_title?></div>
<div id = "inputSubjectBlock" class="item-subjects d-flex flex-column">
    <div id="formSubject" class="d-flex justify-content-between">
    	<input id="inputSubject" class="form__field form__field_width_80" placeholder="<?=$lg_new_subject?>" type="text" name="subject" min="2" max="20" oninput="deleteBorderStyle(this)" />
    	<img class="item-new__img" src="/gaintimeoff/img/checked-32.png" onclick="createNewSubElement('inputSubject')">
    </div>
	<div class='item__error'><?=$error_subject?></div>
</div> 
<div class="item-subjects list-subjects__new">
	<div class="item-list">
		<ul id="subNewList">
		</ul>
	</div>
</div>
<input class="form__btn" type="button" value="<?=$lg_save?>" onclick="handlerSavingNewSubjects('<?=$kidName?>')" />
<div class="item-subjects list-subjects__old">
	<?php if(!empty($subjects)):?>
		<div class="item-subjects__title"><?=$lg_sub_exist?>&#58;</div>
		<div class="item-list">
    		<ul id="subOldList">
    			<?php foreach($subjects as $subject):?>
	    			<li class="item-list__existing"><?=$subject->name?></li>
    			<?php endforeach;?>
    		</ul>
		</div>
	<?php endif;?>
</div>