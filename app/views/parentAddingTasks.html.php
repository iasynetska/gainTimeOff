<main class="dashboard d-flex flex-column flex-wrap">                
    <?=$top_menu?>
    
    <div class="container dashboard-content">
		<div class="row justify-content-center">
			<div class="col flex-shrink-1">
				<h1 class="kids-title"><?=$titleTasks?></h1>
				<div class="kids-block d-flex flex-wrap justify-content-center">
					<div id="<?=$kidName?>" class="kid active-profile d-flex flex-column justify-content-center align-items-center">
                        <img src="<?=$pathPhoto?>" alt="photo" width="64" height="64"/>
                        <div class="kid-name"><?=$kidName?><i class="far fa-edit icon" onclick="location.href='./kid-profile-settings?kidName=<?=$kidName?>';"></i></div>
                    </div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col flex-shrink-1">
        		<div class="items-block d-flex flex-wrap justify-content-center">
        			<div id="tasks" class="item d-flex flex-column justify-content-center align-items-center">
        				<?=$taskBlock?>
        			</div>
                </div>
			</div>
     	</div>
    </div>
</main>