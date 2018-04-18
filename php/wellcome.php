<?php
	include_once "lang_config.php";
?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Wellcome</title>
	</head>
	<body>
		<a href="wellcome.php?lang=en"><?php echo $lang['wellcome_en']?></a>
		<a href="wellcome.php?lang=pl"><?php echo $lang['wellcome_pl']?></a><br /><br />
		<a href="#"><?php echo $lang['wellcome_btn_parent']?></a>
		<a href="#"><?php echo $lang['wellcome_btn_kid']?></a>
	</body>
</html>