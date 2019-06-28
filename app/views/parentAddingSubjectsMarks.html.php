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
		<div class="items">
			<div class="container d-flex flex-wrap justify-content-center align-items-center">
        		<form id="formAddingSubjects" class="adding-sub form" action="/gaintimeoff/kid/do-adding-sub" method="post" enctype = "multipart/form-data" onsubmit="return validateForm(this.id)">
                	<input class="form__btn" type="submit" value="<?=$lg_save?>" />
                </form>
                <form id="formAddingSubjects" class="adding-sub form" action="/gaintimeoff/kid/do-adding-sub" method="post" enctype = "multipart/form-data" onsubmit="return validateForm(this.id)">
                	<input class="form__btn" type="submit" value="<?=$lg_save?>" />
                </form>
            </div>
        </div>
    </div>
</main>