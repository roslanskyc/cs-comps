<?php
if(isset($_SERVER['HTTP_USER_AGENT'])) {
	$all_headers = getallheaders();
   echo "Headers " . $all_headers;
} else {
   echo "User-Agent header is not set.";
}
?>