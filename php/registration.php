<?php
	include_once "lang_config.php";
?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Registration for parent</title>
	</head>
	<body>
		<a href="registration.php?lang=en"><?php echo $lang['en']?></a>
		<a href="registration.php?lang=pl"><?php echo $lang['pl']?></a><br /><br />
		
		<form action="./services/do_registration.php" method="post">
			<?php echo $lang['name']?>: <br /> <input type="text" name="name" /> <br />
			Login: <br /> <input type="text" name="login" /> <br />
			E-mail: <br /> <input type="email" name="email" /> <br />
			<?php echo $lang['password']?>: <br /> <input type="password" name="password" /> <br />
			<?php echo $lang['confirm_password']?>: <br /> <input type="password" name="confirm_password" /> <br /><br />
			
			<input type="submit" value="<?php echo $lang['signup']?>" />
			
		</form>
	</body>
</html>