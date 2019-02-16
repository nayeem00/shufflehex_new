<?php
// !!INSECURE!! In production, make sure to sanitize this input!
//$in_url = 'http://' . $_REQUEST['url'];
$in_url = 'http://google.com'; // !!INSECURE!! In production, make sure to sanitize this input!

// Will probably need to normalize filename too, this is just an illustration
$filename = '/var/cutycapt/images/google.com.png';

// First check the file does not exist, if it does exist skip generation and reuse the file
// This is a super simple caching system that will help to reduce the resource requirements
if(!file_exists($filename)) {
    exec('/usr/local/bin/CutyCapt --url="' . $_REQUEST['url'] . '" --out="' . $filename . '"');
//    exec('/usr/local/bin/CutyCapt --url="' . $_REQUEST['url'] . '" --out="' . $filename . '"');
}

// Second check if the file exists, either from a previous run or from the above generation routine
if(file_exists($filename)) {
    header('Content-type: image/png');
    print file_get_contents($filename);
} else {
    header('Status: 500 Internal Server Error');
}
?>