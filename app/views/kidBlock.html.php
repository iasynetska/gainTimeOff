<div id="<?=$kidName?>" class="kid <?=$kidActive?> d-flex flex-column justify-content-center align-items-center" onclick="changeActiveProfile(this.id)">
<div class="kid-delete">
	<i class="far fa-trash-alt icon" onclick="areYouSure(<?=$kidName?>)"></i>
</div>
<img src="<?=$pathPhoto?>" alt="photo" width="64" height="64"/>
<div class="kid-name"><?=$kidName?><i class="far fa-edit icon"></i></div>
</div>