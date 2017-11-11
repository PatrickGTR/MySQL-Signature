<?php

/*
	define #0 -> MySQL Username
	define #1 -> MySQL Password
	define #2 -> MySQL Host
	define #3 -> MySQL Database

	define #4 -> Table Name
	
*/
define("sqlUsername", 	"root"); 
define("sqlPassword", 	"");
define("sqlHost", 		"localhost");
define("sqlDatabase", 	"cnr");

define("tableName", 	"accounts");

/*
	[ filter_input ]
	- Gets an external variable and optionally filters it.
	- It is used to validate variables from insecure sources, such as user input.
*/

$player_name = filter_input(INPUT_GET, "player_name", FILTER_SANITIZE_STRING);

/*
	[ mysqli_connect ]
	- Opens a new connection to the MySQL server.
*/
$sqlHandle = mysqli_connect(sqlHost, sqlUsername, sqlPassword, sqlDatabase);

/*
	[ mysqli_connect_error ]
	- Returns the error code from the last connection error, if there is any.

	[ mysql_connect_error ] 
	- Returns the error description from the last connection error, if there is any.

	[ die ]
	- Function prints a message and terminates the current script.
*/
if(mysqli_connect_errno())
{
    echo mysql_connect_error();
    die('ERROR: Sorry, We can not connect on your database, please check if you entered the right information');
} 
?>
