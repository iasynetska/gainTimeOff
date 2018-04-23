<?php
	include_once "lang_config.php";
?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Log in for parent</title>
	</head>
	<body>
		<a href="login_parent.php?lang=en"><?php echo $lang['en']?></a>
		<a href="login_parent.php?lang=pl"><?php echo $lang['pl']?></a><br /><br />
		
		<form action="login.php" method="post">
			Login: <br /> <input type="text" name="login" /> <br />
			<?php echo $lang['password']?>: <br /> <input type="password" name="password" /> <br /><br />
			<input type="submit" value="<?php echo $lang['login_submit']?>" /><br /><br />
			
			<a href="registration.php"><?php echo $lang['login_parent_link']?></a>
		</form>
	</body>
</html>