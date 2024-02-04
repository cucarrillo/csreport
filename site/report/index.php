<?php

require "steamlib.php";

$USER_KDR = NULL;
$USER_ACC = NULL;
$USER_ADR = NULL;
$USER_GUN = NULL;
$USER_PFP = NULL;
$USER_NME = NULL;

// get user stats!
function main()
{
	$userID = $_GET['userid'];

	if(!is_numeric($userID))
	{
		if(str_contains($userID, "https://steamcommunity.com/id/"))
		{
			$userID = getSteamIDFromURL($userID);
		}
		else
		{
			$userID = getSteamIDFromUsername($userID);
		}

		if($userID == NULL)
		{
			header("Location: /oops/"); // TODO: tell user it was an invalid username
			exit();
		}
	}

	$dataStats 		= getUserStats($userID);
	$dataProfile 	= getPlayerSummary($userID);

	if($dataStats == NULL || $dataProfile == NULL)
	{
		header("Location: /oops/"); // TODO: tell user that the stats failed to get pulled
		exit();
	}

	global $USER_ADR;
	global $USER_KDR;
	global $USER_ACC;
	global $USER_GUN;
	global $USER_PFP;
	global $USER_NME;

	$USER_PFP = $dataProfile["avatarfull"];
	$USER_NME = $dataProfile["personaname"];
	$USER_GUN = getUserMostUsedWeapon($dataStats);
	
	$kills = getStatFromValue($dataStats, "total_kills");
	$deaths = getStatFromValue($dataStats, "total_deaths");
	$USER_KDR = round($kills / $deaths, 2);

	$shots = getStatFromValue($dataStats, "total_shots_fired");
	$hits = getStatFromValue($dataStats, "total_shots_hit");
	$USER_ACC = round(($hits / $shots) * 100);

	$killsHS = getStatFromValue($dataStats, "total_kills_headshot");
	$USER_ADR = round(($killsHS / $kills) * 100);
}

main();
?>


<?php
?>

<!doctype html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/style.css">
	</head>
	<body>
		<div>
			<br>
			<div style="text-align: center;">
				<span class="title1"><i>Counter-Strike Report</i></span>
				<br>
				<span class="title2"><i>for</i></span>
				<br>
				<span class="title3">MAZDA-PEEK</span>
				<br><br>
			</div>

			<div class="content">
				<div>
					<div class="bub">
						<span class="bubtext"><?php echo "$USER_ADR";?>%</span><br>
						<span class="bubsub">HSP</span>
					</div>
				</div>

				<div style="width: 15%;"></div>
				<div>
					<div class="bub">
						<span class="bubtext"><?php echo "$USER_KDR";?></span><br>
						<span class="bubsub">KDR</span>
					</div>
				</div>
			</div>

			<div class="content">
				<a class="apfp" href="https://steamcommunity.com/id/ubaldocs">
					<img class="pfp" src="<?php echo "$USER_PFP"?>"></img>
				</a>
			</div>
			
			<div class="content">
				<div class="bub">
					<span class="bubtext"><?php echo "$USER_ACC";?>%</span><br>
					<span class="bubsub">Accuracy</span>
				</div>
				<div style="width: 15%;"></div>
				<div class="bub">
					<span class="bubtext"><?php echo "$USER_GUN";?></span><br>
					<span class="bubsub">Best Gun</span>
				</div>
			</div>

			<br><br>

			<div class="content">
				<a style="font-size: small" href="/">generate another report</a>
			</div>
		</div>
	</body>
</html>