<?php
require_once 'users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';


if (isset($user) && $user->isLoggedIn()) { }
?>

<div class="jumbotron">
	<h1 align="center"><?= lang("JOIN_SUC"); ?> <?php echo $settings->site_name; ?></h1>
	<p align="center">
		<?php
		if ($user->isLoggedIn()) { ?>
			<a class="btn btn-primary" href="users/account.php" role="button"><?= lang("ACCT_HOME"); ?> &raquo;</a>
			<a href="excelanalyzer">
				<p>Excel Analyzer</p>
			</a>
		<?php } else { ?>
			<p align="center" class="text-muted">Please login so you can access your systems, or register for a new account:</p>
			<p align="center" class="text-muted"><a class="btn btn-warning" href="users/login.php" role="button"><?= lang("SIGNIN_TEXT"); ?> &raquo;</a>
				<a class="btn btn-info" href="users/join.php" role="button"><?= lang("SIGNUP_TEXT"); ?> &raquo;</a></p>
		<?php } ?>
	</p>
	<br>
	<!-- <p align="center"><?= lang("MAINT_PLEASE"); ?></p> -->

</div>
<?php languageSwitcher(); ?>


<!-- Place any per-page javascript here -->


<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>