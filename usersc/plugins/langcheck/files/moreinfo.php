<?php
require_once '../../../../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (isset($user) && $user->isLoggedIn()) { }
?>

<h1 align="center"><?php echo $settings->site_name; ?></h1>
<?php
echo htmlspecialchars_decode($last->detail);
?>


<!-- Place any per-page javascript here -->


<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>