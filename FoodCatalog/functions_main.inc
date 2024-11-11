<?php
function Connect_to_db($filename)
{
    include($filename);
    $cxn = mysqli_connect($host, $user, $passwd)
        or die ("Couldn't connect to server.");
    $db = mysqli_select_db($cxn, $database)
        or die ("Couldn't select database.");
    return $cxn;
}
?>