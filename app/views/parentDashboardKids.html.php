<main class="dashboard d-flex flex-column flex-wrap">                
    <?=$top_menu?>
    
    <div class="dashboard-content flex-grow-1 d-flex flex-column">
		<div class="kids">
			<div class="container">
				<h1 class="kids-title"><?=$lg_my_kids?></h1>
				<div class="kids-new">
					<img class="kids-new__img" onclick="location.href='./adding-kid';" src="/gaintimeoff/img/plus-32.png" alt="Add kid">
				</div>
				<div class="kids-blocks d-flex flex-wrap justify-content-center">
					<?=$kidBlock?>
				</div>
			</div>
		</div>
    </div>
</main>