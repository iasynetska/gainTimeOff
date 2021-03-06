<main class="dashboard d-flex flex-column flex-wrap">                
    <?=$top_menu?>
    
    <div class="dashboard-content flex-grow-1 d-flex flex-column">
		<div class="kids">
			<div class="container">
				<h1 class="kids-title"><?=$kidsTitle?></h1>
				<div class="kids-new">
					<img class="kids-new__img" src="/img/plus-32.png" alt="Add kid" onclick="location.href='./adding-kid';" >
				</div>
				<div id="kidsBlock" class="kids-block d-flex flex-wrap justify-content-center">
					<?=$kidBlock?>
				</div>
			</div>
		</div>
		<div id="itemsBlock" class="items">
			<div class="container d-flex flex-column justify-content-center align-items-center">
				<div id="kidTimeBlock" class="items-time d-flex flex-column justify-content-center align-items-center">
					<?=$dashboardTimeBlock?>
				</div>
			</div>
			<div class="container items-block d-flex flex-wrap justify-content-center">
				<div  id="kidSubjectBlock" class="item d-flex flex-column align-items-center">
					<?=$dashboardSubjectBlock?>
				</div>
				<div id="kidTaskBlock" class="item d-flex flex-column align-items-center">
					<?=$dashboardTaskBlock?>
				</div>
			</div>
            <div class="container d-flex flex-column justify-content-center align-items-center">
                <div id="kidReportReceivedMarksBlock" class="items-report d-flex flex-column align-items-center">
                    <?=$dashboardReportReceivedMarksBlock?>
                </div>
            </div>
		</div>
    </div>
</main>