<main class="dashboard d-flex flex-column flex-wrap">                
    <?=$top_menu?>
    
    <div class="dashboard-content flex-grow-1 d-flex flex-column">
		<div class="kids">
			<div class="container">
				<h1 class="kids-title"><?=$titleSubject?></h1>
				<div class="kids-block d-flex flex-wrap justify-content-center">
					<div id="<?=$kidName?>" class="kid active-profile d-flex flex-column justify-content-center align-items-center">
                        <img src="<?=$pathPhoto?>" alt="photo" width="64" height="64"/>
                        <div class="kid-name"><?=$kidName?><i class="far fa-edit icon"></i></div>
                    </div>
				</div>
			</div>
		</div>
		<div class="items-block d-flex flex-wrap justify-content-center">
			<div id="subjects" class="item d-flex flex-column justify-content-center align-items-center">
				<?=$subjectBlock?>
			</div>
            <div class="item d-flex flex-column align-items-center">
                <div class="item-title"><?=$lg_add_marks_title?></div>
            	<input class="form__btn" type="submit" value="<?=$lg_save?>" />
            </div>
        </div>
    </div>
</main>