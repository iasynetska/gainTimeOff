<?php use core\TimeConverter?>

<main class="dashboard d-flex flex-column flex-wrap">                
    <?=$top_menu?>
    
    <div class="container dashboard-content">
		<div class="row justify-content-center">
			<div class="col flex-shrink-1">
				<h1 class="kids-title"><?=$lg_kid_profile_settings?></h1>
				<div class="kids-block d-flex flex-wrap justify-content-center">
					<div id="<?=$kidName?>" class="kid active-profile d-flex flex-column justify-content-center align-items-center">
                        <img src="<?=$pathPhoto?>" alt="photo" width="64" height="64"/>
                        <div class="kid-name"><?=$kidName?></div>
                    </div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col flex-shrink-1">
        		<div class="form items-block d-flex flex-wrap flex-column justify-content-start">
        			<h3 class="kids-title"><?=$lg_personal_data?></h3>
        			<ul>
        				<li><?=$lg_name?>&#58;&#160;<?=$kidName?><i class="far fa-edit icon"></i></li>
        				<li><?=$gender?><i class="far fa-edit icon"></i></li>
        				<li><?=$lg_login?>&#58;&#160;<?=$kidLogin?><i class="far fa-edit icon"></i></li>
        				<li><?=$lg_date_of_birth?>&#58;&#160;<?=$kidBirthday?><i class="far fa-edit icon"></i></li>
        				<li><?=$lg_photo_title?><i class="far fa-edit icon"></i></li>
        				<li><?=$lg_password?><i class="far fa-edit icon"></i></li>
        			</ul>
                </div>
                <div class="form items-block d-flex flex-wrap flex-column justify-content-start">
        			<h3 class="kids-title"><?=$lg_time_to_play?></h3>
        			<ul>
        				<li><?=$lg_time?>&#58;&#160;<?=$kidTime?><i class="far fa-edit icon"></i></li>
        			</ul>
                </div>
                <div class="form items-block d-flex flex-wrap flex-column justify-content-start">
        			<h3 class="kids-title"><?=$lg_school_subjects?></h3>
        			<?php if(!empty($subjects)):?>
            			<ul>
            				<?php foreach($subjects as $subject):?>
                		    	<li><?=$subject->name?><i class="far fa-edit icon"></i></li>
            		    	<?php endforeach;?>
            			</ul>
        			<?php endif;?>
        			<a class="form__link" href="/parent/adding-subjects-marks?kidName=<?=$kidName?>"><?=$lg_add_subjects_title?></a>
                </div>
                <div class="form items-block d-flex flex-wrap flex-column justify-content-start">
        			<h3 class="kids-title"><?=$lg_marks?></h3>
        			<?php if(!empty($marks)):?>
            			<ul>
            				<?php foreach($marks as $mark):?>
                		    	<li><?=$mark->name?>&#160;&rarr;&#160;<?=TimeConverter::convertSecondsToTimeFormat($mark->gameTime)?><i class="far fa-edit icon"></i></li>
            		    	<?php endforeach;?>
            			</ul>
        			<?php endif;?>
        			<a class="form__link" href="/parent/adding-subjects-marks?kidName=<?=$kidName?>"><?=$lg_add_marks_title?></a>
                </div>
                <div class="form items-block d-flex flex-wrap flex-column justify-content-start">
        			<h3 class="kids-title"><?=$lg_tasks?></h3>
        			<?php if(!empty($tasks)):?>
            			<ul>
            				<?php foreach($tasks as $task):?>
                		    	<li><?=$task->name?>&#160;&rarr;&#160;<?=TimeConverter::convertSecondsToTimeFormat($task->gameTime)?><i class="far fa-edit icon"></i></li>
            		    	<?php endforeach;?>
            			</ul>
        			<?php endif;?>
        			<a class="form__link" href="/parent/adding-tasks?kidName=<?=$kidName?>"><?=$lg_add_tasks_title?></a>
                </div>
			</div>
     	</div>
    </div>
</main>