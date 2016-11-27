<?php

//Author: Mary Counts
//Mad Lib
//10/1/15
//displays menu to pick story, then displays story and story with substitue words noted. then displays a list of all subs\
//titue words needed for that story


require "classfun.php";
printDocHeading("layout.css", "Mad Lib");
print "<body>\n<div class='content'>\n";
print "<h2>Mad Lib Game</h2>\n";
if(empty ($_POST))
{
        ShowForm();

}
        if ($_POST[storyChoice])
        {
                subForm();
                
        }
	if ($_POST[submitSubs])
	{
		showSubs();
	}

//end of else

print "</div>\n";  // end of opening div
printDocFooter();

//FUNCTIONS


function showForm()
{

        $self = $SERVER ['PHP_SELF'];
        print "<h4> Choose a story and press submit.</h4>";
        print "<form method = 'post' action = '$self'>\n";
        print "<select name = 'storyChoice'>\n";
        print "<option value = '1'>silly story</option>\n";
        print "<option value = '2'>news story</option>\n";
        print "<option value = '3'>song</option>\n";
        print"</select>\n";
        print "<input type = 'submit' value = 'submit story'\><br/>\n";
        print "</form>\n";
}


function subForm()

{
$self = $_SERVER ['PHP_SELF'];
print "<form method = 'post' action = '$self'>\n";
$num = $_POST['storyChoice'];
$file = "storysub$num.txt";
$contents = file_get_contents($file); //gets contents of substituted file
print "<input type = 'hidden' name= 'storyChoice' value = '$num'/>\n";
$pattern = "/\[(.+?)\]/"; //gets the substitutions contained in brackets
$text = file_get_contents($file);

$result=preg_match_all($pattern, $text, $matches);
print "<h3>Please enter substitutions:</h3>\n";
for($i=0; $i<count($matches[0]); $i++)
{
$subs=$value[$i];
$matched=$matches[1][$i];
print"$matched<input type='text' name='value[]' value='$subs' />\n";
}
print "<h3> <input type='submit' name='submitSubs' value='submit' /> </h3>\n";
print "</form>\n";

}

//Displays story with subsituted words
function showSubs()
{
$self = $_SERVER ['PHP_SELF'];
$value=$_POST['value'];
$error = 0;
foreach($value as $subs)
	       {
	       if($subs=='')
	       $error= "<h4>Please fill boxes</h4>";
	       }
if($error)
	{
	print $error;
	displayForm($value);
	}
else
	{
$num = $_POST['storyChoice'];
$file = "storysub$num.txt";
$contents = file_get_contents($file);
$pattern= "/\[(.*?)\]/";
$result=preg_match_all($pattern, $contents, $matches);
	for($i=0; $i<count($matches[0]); $i++)
	{	
	$replace =$matches[0][$i];
	$contents =str_replace($replace, $value[$i], $contents);//replaces [] with substitutions
	}
	print "$contents";
	}
print "<div></div>";
startOverLink();
}

?>