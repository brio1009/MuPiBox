<!DOCTYPE html>
<?php
	$string = file_get_contents('/etc/mupibox/mupiboxconfig.json', true);
	$data = json_decode($string, true);
	$change=0;
	$CHANGE_TXT="<div id='lbinfo'><ul id='lbinfo'>";
	$commandSSID="sudo iwgetid -r";
	$WIFI=exec($commandSSID);
	$commandLQ="sudo iwconfig wlan0 | awk '/Link Quality/{split($2,a,\"=|/\");print int((a[2]/a[3])*100)\"\"}' | tr -d '%'";
	$LINKQ=exec($commandLQ);
	
	if ($_GET['hshutdown']) {
		$shutdown = 1;
		$change=99;
		$CHANGE_TXT=$CHANGE_TXT."<li>Shutdown MuPiBox</li>";
		}
	if ($_GET['hreboot']) {
		$reboot = 1;
		$change=99;
		$CHANGE_TXT=$CHANGE_TXT."<li>Reboot MuPiBox</li>";
		}
	if ($_GET['hchromerestart']) {
		exec("sudo -i -u dietpi /usr/local/bin/mupibox/./restart_kiosk.sh");
		$change=99;
		$CHANGE_TXT=$CHANGE_TXT."<li>Restart Chrome kiosk</li>";
		}
	if ($_GET['hrefreshdatabase']) {
		exec("sudo /usr/local/bin/mupibox/./m3u_generator.sh");
		$change=99;
		$CHANGE_TXT=$CHANGE_TXT."<li>Update media database finished</li>";
		}
		
	$mupihat_file = '/tmp/mupihat.json';
	$mupihat_state = false;
	if (file_exists($mupihat_file)) {
		$mupihat_state = true;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
		<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>MuPiBox Admin-Interface</title>
		<link rel="stylesheet" type="text/css" href="view.css?v=7.1.12" media="all">
		<script src="https://code.iconify.design/iconify-icon/2.0.0/iconify-icon.min.js"></script>
		<script type="text/javascript" src="view.js?v=6.0.6"></script>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<link rel="icon" type="image/x-icon" href="/images/favicon.ico">

	</head>
	<body id="main_body" >
		<img id="top" src="images/top.png" alt="">	
		<div id="container">
			<div class="controlnav" id="controlnav">
				<div id="Wifi_Icon"> </div>
				<div id="Battery_Icon"> </div>
				<div id="Fan_Icon"> </div>
				<a href="?hshutdown=1" onclick="confirm('Do really want to shutdown?') || stopEvent(event)" ><iconify-icon icon="ic:outline-power-settings-new" title="Shutdown" ></iconify-icon></a>
				<a href="?hreboot=1" onclick="confirm('Do really want to reboot?') || stopEvent(event)" ><iconify-icon icon="ic:outline-restart-alt" title="Reboot" ></iconify-icon></a>
				<a href="?hchromerestart=1" onclick="confirm('Do really want to restart chrome kiosk?') || stopEvent(event)" ><iconify-icon icon="tabler:brand-chrome"  title="Restart chrome browser" ></iconify-icon></a>
				<a href="?hrefreshdatabase=1" onclick="confirm('Do really want to reload media database?') || stopEvent(event)" ><iconify-icon icon="mdi:database-refresh-outline"  title="Reload media database" ></iconify-icon></a>
			</div>
			<div class="topnav" id="myTopnav">
				<a href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
				<a href="content.php"><i class="fa-solid fa-music"></i> MuPiBox</a>				
<?php
	$command = "ps -ef | grep websockify | grep -v grep";
	exec($command, $vncoutput, $vncresult );
	if( $vncoutput[0] )
	{
		echo '<a href="vnc.php"><i class="fa-solid fa-display"></i> VNC</a>';
	}
?>
				<a href="mupi.php"><i class="fa-solid fa-headphones"></i> MuPi-Conf</a>
				<a href="mupihat.php"><i class="fa-solid fa-hat-wizard"></i> MuPiHAT</a>
				<a href="media.php"><i class="fa-solid fa-list"></i> Media</a>
				<a href="cover.php"><i class="fa-regular fa-image"></i> Cover</a>
				<a href="bluetooth.php"><i class="fa-brands fa-bluetooth"></i> Bluetooth</a>
				<a href="spotify.php"><i class="fa-brands fa-spotify"></i> Spotify</a>
				<a href="network.php"><i class="fa-solid fa-wifi"></i> Network</a>
				<a href="smart.php"><i class="fa-solid fa-share-nodes"></i> Smart</a>
				<?php /*<a href="service.php"><i class="fa-solid fa-gear"></i> Services</a>
				<a href="tweaks.php"><i class="fa-solid fa-rocket"></i> Performance</a>*/ ?>
				<a href="/" onmouseover="javascript:event.target.port=5252" target="_blank"><i class="fa-brands fa-raspberry-pi"></i> DietPi-Dash</a>
				<?php /*<a href="/" onmouseover="javascript:event.target.port=8081" target="_blank"><i class="fa-brands fa-youtube"></i> Youtube</a>*/ ?>
				<a href="admin.php"><i class="fa-solid fa-screwdriver-wrench"></i> Admin</a>
				<a href="javascript:void(0);" class="icon" onclick="myFunction()"><i class="fa fa-bars"></i></a>
			</div>
