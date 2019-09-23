<div id="<?=$kidName?>" class="kid <?=$kidActive?> d-flex flex-column justify-content-center align-items-center">
    <div class="kid-delete">
    	<i class="icon far fa-trash-alt icon" onclick="handlerDeletingProfile('<?=$kidName?>')"></i>
    </div>
    <img src="<?=$pathPhoto?>" alt="photo" width="64" height="64" onclick="moveActiveProfile(this.parentElement)" />
    <div class="kid-name"><?=$kidName?><i class="icon far fa-edit icon" onclick="location.href='./kid-profile-settings?kidName=<?=$kidName?>';"></i></div>
</div>