<?php

require "config.php";

// returns a API call with CURL
function callAPI($url)
{
	$client = curl_init();
	
	curl_setopt($client, CURLOPT_URL, $url);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	
	$response = curl_exec($client);

	if($e = curl_error($client)) { $response = NULL; }

	curl_close($client);

	return $response;
}

// returns the steam ID from a given steam username
function getSteamIDFromUsername($username)
{
	global $STEAM_KEY;

	$url = "http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=$STEAM_KEY&vanityurl=$username";
    
    $result = callAPI($url);

    if($result != NULL)
    {
        $result = json_decode($result, true)["response"]["steamid"];;
    }

	return $result;
}

// returns the steam ID from a given URL
// example: "https://steamcommunity.com/id/ubaldocs"
function getSteamIDFromURL($url)
{
	if(str_contains($url, "https://steamcommunity.com/id/"))
	{
		$username = str_replace("https://steamcommunity.com/id/", "", $url);

        return getSteamIDFromUsername($username);
	}
	else { return NULL; }
}


// returns data (JSON) from the getPlayerSummaries API call
// we really only use it to get data for one user
function getPlayerSummary($steamID)
{
    global $STEAM_KEY;

	$url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$STEAM_KEY&steamids=$steamID";

    $result = callAPI($url);

    if($result != NULL)
    {
        $result = json_decode($result, true)["response"]["players"][0];
    }

    return $result;
}

// returns data (JSON) from the getUserStatsForGame API call
function getUserStatsForGame($steamID)
{
	global $STEAM_KEY;

	$url = "https://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid=730&key=$STEAM_KEY&steamid=$steamID";

    $result = callAPI($url);

    if($result != NULL)
    {
	    $result = json_decode($result, true);
    }

    return $result;
}

// returns the actual stats from getUserStatsForGame
function getUserStats($steamID)
{
	$rawData = getUserStatsForGame($steamID);

	if($rawData == NULL) { return NULL; }

	return $rawData["playerstats"]["stats"];
}

// returns requested stat using given data
function getStatFromValue($data, $name)
{
	for($i = 0; $i < count($data); $i++)
	{
		if($data[$i]["name"] == $name)
		{
			return $data[$i]["value"];
		}
	}

	return NULL;
}

// returns the weapon with the most amount of kills using given data
function getUserMostUsedWeapon($data)
{
    // import variables from config.php
    global $BANNED_STATS;
    global $GUN_NAMES;

    // used to remember the gun with the most kills
	$bestGun    = NULL;
	$killCount  = 0;

    // go through all the data
	for($i = 0; $i < count($data); $i++)
	{
        $stat = $data[$i]["name"];      // data retrieved
        $value = $data[$i]["value"];

		if(str_contains($stat ,"total_kills_"))
		{
			$isBanned = false;

            // go through the black list and make sure we are not in it
			for($j = 0; $j < count($BANNED_STATS); $j++)
			{
                $isBanned = ($stat == $BANNED_STATS[$j]);
				
                if($isBanned) { break; }
			}

			if(!$isBanned)
			{
                // check if this gun beats the current record
                if($value >= $killCount)
                {
                    $bestGun    = $GUN_NAMES[$stat];
                    $killCount  = $value;
                }
			}
		}
	}

	return $bestGun;
}

function getUserKDR($data) {}
function getUserADR($data) {}
function getUser($data) {}
// TODO add get headshot % function // maybe replace ADR with this
// TODO make profile picture hyperlink to their steam profile
// TODO display account create date
?>