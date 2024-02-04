<?php

// Stats that are banned from being considered in finding the most kills weapon
$BANNED_STATS = array(	"total_kills_headshot", 
                        "total_kills_enemy_weapon",
                        "total_kills_enemy_blinded", 
                        "total_kills_knife_fight", 
                        "total_kills_against_zoomed_sniper", 
                        "total_kills_hegrenade", 
                        "total_kills_molotov", 
                        "total_kills_knife", 
                        "total_kills_taser"                     );

// Get the real name of a gun stat name
$GUN_NAMES = array(	"total_kills_glock"     => "Glock",
                    "total_kills_deagle"    => "Deagle",
                    "total_kills_elite"     => "Duel Berrettas",
                    "total_kills_fiveseven" => "Five Seven",
                    "total_kills_xm1014"    => "XM1014",
                    "total_kills_mac10"     => "MAC10",
                    "total_kills_ump45"     => "UMP-45",
                    "total_kills_p90"       => "P-90",
                    "total_kills_awp"       => "AWP",
                    "total_kills_ak47"      => "AK-47",
                    "total_kills_aug"       => "AUG",
                    "total_kills_famas"     => "Famas",
                    "total_kills_g3sg1"     => "G3SG1",
                    "total_kills_m249"      => "M249",
                    "total_kills_hkp2000"   => "USP / P2K",
                    "total_kills_p250"      => "P250",
                    "total_kills_sg556"     => "SG556",
                    "total_kills_scar20"    => "SCAR20",
                    "total_kills_ssg08"     => "SSG08",
                    "total_kills_mp7"       => "MP7",
                    "total_kills_mp9"       => "MP9",
                    "total_kills_nova"      => "Nova",
                    "total_kills_negev"     => "Negev",
                    "total_kills_sawedoff"  => "Sawed Off",
                    "total_kills_bizon"     => "PP Bizon",
                    "total_kills_tec9"      => "TEC-9",
                    "total_kills_mag7"      => "MAG-7",
                    "total_kills_m4a1"      => "M4",
                    "total_kills_galilar"   => "Galil"            );
?>