<?
# Copyright Optimist 2015, generates a plist file containing relevant messages
#error_reporting(E_ALL);

#Get the POST vars
$key = $_POST["key"];
$user = $_POST["user"];
$lat = $_POST["lat"];
$lon = $_POST["lon"];
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

# Generates the plist header
echo "<?xml version='1.0' encoding='UTF-8'?>
<!DOCTYPE plist PUBLIC '-//Apple//DTD PLIST 1.0//EN' 'http://www.apple.com/DTDs/PropertyList-1.0.dtd'>
<plist version='1.0'>
<dict>\n";

#Sets the date retrieved to current time
echo"<key>DateRetrieved</key>\n<string>";
echo date('Y-m-d H:i:s');
echo "</string>\n";

if ($key=="")
{
	#Valid key
}
else
{
	exit("<key>Verify</key>
	<string>BADKEY</string>\n");
}

# Connects to the database
$user="";
$password="";
$database="";
mysql_connect(localhost,$user,$password);
@mysql_select_db($database) or die( "Unable to select database");

#Determines what needs to be retrieved
$tags = 0;
$theTags = array();

#Get download radius
$latmin = floatval($lat)-0.01;
$latmax = floatval($lat)+0.01;
$lonmin = floatval($lon)-0.01;
$lonmax = floatval($lon)+0.01;

$query="SELECT * 
FROM  `messages` 
WHERE ((";

#Determine which tags we are interested in
if ($angry=="1")
{
	$query=$query."angry = '1' OR ";
	$tags++;
	$theTags[] = "angry";
}
if($anxious=="1")
{
	$query=$query."anxious = '1' OR ";
	$tags++;
	$theTags[] = "anxious";
}
if($annoyed=="1")
{
	$query=$query."annoyed = '1' OR ";
	$tags++;
	$theTags[] = "annoyed";
}
if($depressed=="1")
{
	$query=$query."depressed = '1' OR ";
	$tags++;
	$theTags[] = "depressed";
}
if($down=="1")
{
	$query=$query."down = '1' OR ";
	$tags++;
	$theTags[] = "down";
}
if($heartbroken=="1")
{
	$query=$query."heartbroken = '1' OR ";
	$tags++;
	$theTags[] = "heartbroken";
}
if($hopeless=="1")
{
	$query=$query."hopeless = '1' OR ";
	$tags++;
	$theTags[] = "hopeless";
}
if($hurting=="1")
{
	$query=$query."hurting = '1' OR ";
	$tags++;
	$theTags[] = "hurting";
}
if($irritable=="1")
{
	$query=$query."irritable = '1' OR ";
	$tags++;
	$theTags[] = "irritable";
}
if($mournful=="1")
{
	$query=$query."mournful = '1' OR ";
	$tags++;
	$theTags[] = "mournful";
}
if($nervous=="1")
{
	$query=$query."nervous = '1' OR ";
	$tags++;
	$theTags[] = "nervous";
}
if($pissed=="1")
{
	$query=$query."pissed = '1' OR ";
	$tags++;
	$theTags[] = "pissed";
}
if($regretful=="1")
{
	$query=$query."regretful = '1' OR ";
	$tags++;
	$theTags[] = "regretful";
}
if($resentful=="1")
{
	$query=$query."resentful = '1' OR ";
	$tags++;
	$theTags[] = "resentful";
}
if($sad=="1")
{
	$query=$query."sad = '1' OR ";
	$tags++;
	$theTags[] = "sad";
}
if($scared=="1")
{
	$query=$query."scared = '1' OR ";
	$tags++;
	$theTags[] = "scared";
}
if($sick=="1")
{
	$query=$query."sick = '1' OR ";
	$tags++;
	$theTags[] = "sick";
}
if($stressed=="1")
{
	$query=$query."stressed = '1' OR ";
	$tags++;
	$theTags[] = "stressed";
}
if($sulky=="1")
{
	$query=$query."sulky = '1' OR ";
	$tags++;
	$theTags[] = "sulky";
}
if($worthless=="1")
{
	$query=$query."worthless = '1' OR ";
	$tags++;
	$theTags[] = "worthless";
}

#Get rid of the extra OR
$query=substr($query,0,strlen($query)-4);
#echo "The query is: ".$query."\n";
#print_r($theTags);

$query=$query.") AND (opened = '0') ) LIMIT 0 , 30";


$result = mysql_query($query);

if ($result)
{
	#Valid key!
	echo "<key>Verify</key>
	<string>VALID</string>\n";
	
	#Get results from DB
	$num=mysql_numrows($result);
	
	#Prints number of pins
	echo "<key>numberOfPins</key>\n";
	echo "<string>".$num."</string>\n";
	
	#The loop to print each pin
	$numberOfTags = count ($theTags);
	$i=0;
	while ($i < $num) {
		$id=mysql_result($result,$i,"id");
		$time=mysql_result($result,$i,"time");
		$lat=mysql_result($result,$i,"lat");
		$lon=mysql_result($result,$i,"lon");
		$message=mysql_result($result,$i,"message");
		$match="0";
		#Check how many tags are in this one
		for ($j=0; $j<$numberOfTags; $j++)
		{
			if (mysql_result($result, $i, $theTags[$j])=="1")
			{
				$match++;
			}
		}
		

		#Print results to xml
		echo "<key>".$i."</key>";
		echo "<dict>\n";
		echo "\t<key>id</key>\n";
		echo "\t<string>".$id."</string>\n";
		echo "\t<key>time</key>\n";
		echo "\t<string>".$time."</string>\n";
		echo "\t<key>match</key>\n";
		echo "\t<string>".$match."</string>\n";
		echo "\t<key>lat</key>\n";
		echo "\t<string>".$lat."</string>\n";
		echo "\t<key>lon</key>\n";
		echo "\t<string>".$lon."</string>\n";
		echo "\t<key>message</key>\n";
		echo "\t<string>".$message."</string>\n";
		echo "</dict>\n";

		$i++;
	}

}
else
{
	echo "<key>Verify</key>
	<string>FAIL</string>\n";
}


mysql_close();


# Generates plist footer
echo "</dict>
</plist>"

?>
