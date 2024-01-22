<?php
if(isset($_COOKIE['Account-Type'])) {
	$cookie = gethtmlspecialchars();
   echo "Headers " . $all_headers;
} else {
   echo "User-Agent header is not set.";
}
?>