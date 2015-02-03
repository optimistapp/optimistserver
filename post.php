<?
# Copyright Optimist 2015, posts a message to the database

# Gathers post data
$key = $_POST["key"];
$theuser = $_POST["user"];
$lat = $_POST["lat"];
$lon = $_POST["lon"];
$message = mysql_escape_string($_POST["message"]);
$angry = $_POST["angry"];
$anxious = $_POST["anxious"];
$annoyed = $_POST["annoyed"];
$depressed = $_POST["depressed"];
$down = $_POST["down"];
$heartbroken = $_POST["heartbroken"];
$hopeless = $_POST["hopeless"];
$hurting = $_POST["hurting"];
$irritable = $_POST["irritable"];
$mournful = $_POST["mournful"];
$nervous = $_POST["nervous"];
$pissed = $_POST["pissed"];
$regretful = $_POST["regretful"];
$resentful = $_POST["resentful"];
$sad = $_POST["sad"];
$scared = $_POST["scared"];
$sick = $_POST["sick"];
$stressed = $_POST["stressed"];
$sulky = $_POST["sulky"];
$worthless = $_POST["worthless"];


if ($key=="")
{
	#Valid key
}
else
{
	exit("IK");
}

# Connects to the database
$user="";
$password="";
$database="";
mysql_connect(localhost,$user,$password);
@mysql_select_db($database) or die( "Unable to select database");

#Inserts into database
#error_reporting(E_ALL);
$query="INSERT INTO `messages`(`id`, `time`, `user`, `lat`, `lon`, `message`, `angry`, `anxious`, `annoyed`, `depressed`, `down`, `heartbroken`, `hopeless`, `hurting`, `irritable`, `mournful`, `nervous`, `pissed`, `regretful`, `resentful`, `sad`, `scared`, `sick`, `stressed`, `sulky`, `worthless`) VALUES (DEFAULT, now(), '$theuser', '$lat', '$lon', '$message', '$angry', '$anxious', '$annoyed', '$depressed', '$down', '$heartbroken', '$hopeless', '$hurting', '$irritable', '$mournful', '$nervous', '$pissed', '$regretful', '$resentful', '$sad', '$scared', '$sick', '$stressed','$sulky', '$worthless')";


if (mysql_query($query))
{
	echo "SC";
}
else
{
	echo "QF";
}

mysql_close();
?>
