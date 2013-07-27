<?php

include $_SERVER['DOCUMENT_ROOT']."/ldap-api/ldap-auth.php";
    // indenting JSON
    //
    function indent($json) {

    $result      = '';
    $pos         = 0;
    $strLen      = strlen($json);
    $indentStr   = '  ';
    $newLine     = "\n";
    $prevChar    = '';
    $outOfQuotes = true;

    for ($i=0; $i<=$strLen; $i++) {

        // Grab the next character in the string.
        $char = substr($json, $i, 1);

        // Are we inside a quoted string?
        if ($char == '"' && $prevChar != '\\') {
            $outOfQuotes = !$outOfQuotes;

        // If this character is the end of an element,
        // output a new line and indent the next line.
        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }

        // Add the character to the result string.
        $result .= $char;

        // If the last character was the beginning of an element,
        // output a new line and indent the next line.
        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }

            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }

        $prevChar = $char;
    }

    return $result;
}
if(isset($_SERVER['PATH_INFO']))
{
	$id = $_SERVER['PATH_INFO'];
	$id = substr($id, 1);
}
if(isset($_GET["user"]))
{
	$id = $_GET["user"];
}

if(isset($_GET["user"]) || isset($_SERVER['PATH_INFO']))
{
	$enti = new ldapAuth($id);
	$res = $enti->getInfo();
	$fname = $enti->getFirstName();
	$lname = $enti->getLastName();
	$rollno = $enti->getRollNo();
	$mail = $enti->getMail();
	$dept = $enti->getDept();
	if($fname != null)
	{
		$named_array = array(
			"ldapid" => $id,
			"fname" => $fname,
			"lname" => $lname,
			"rollno" => $rollno,
			"mail" => $mail,
			"dept" => $dept,
	    );
		header('Content-type: text/json');
	    echo indent(json_encode($named_array));
	}
	else
	{
		$named_array = array(
			"error" => "user doesn't exist", );
		header('Content-type: text/json');
		echo indent(json_encode($named_array));
	}
}
else
{
		$named_array = array(
		"error" => "Incorrect Usage", );
		header('Content-type: text/json');
		echo indent(json_encode($named_array));

}
?>