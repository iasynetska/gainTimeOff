<main class="dashboard d-flex flex-column flex-wrap">                
    <?=$top_menu?>
    
    <div class="dashboard-content flex-grow-1 d-flex flex-column">
		<div class="kids">
			<div class="container">
				<h1 class="kids-title"><?=$kidsTitle?></h1>
				<div class="kids-new">
					<img class="kids-new__img" src="/gaintimeoff/img/plus-32.png" alt="Add kid" onclick="location.href='./adding-kid';" >
				</div>
				<div class="kids-block d-flex flex-wrap justify-content-center">
					<?=$kidBlock?>
				</div>
			</div>
		</div>
		<div id="items" class="items">
			<?=$itemsBlock?>
		</div>
    </div>
</main>