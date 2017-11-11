<?php
require_once('connection.php');

/*
    [ empty ] 
    Function is used to check whether a variable is empty or not.
*/

if(!empty($player_name))
{
    // [ mysqli_real_escape_string ] 
    // Function escapes special characters in a string for use in an SQL statement.
    $player_name = mysqli_real_escape_string($sqlHandle, $player_name);
    $query = "SELECT * FROM " . tableName . " WHERE playername = '$player_name' LIMIT 1"; 
    // [ mysqli_query ] 
    // Function performs a query against the database.
    $result = mysqli_query($sqlHandle, $query);
    // [ mysqli_query ]
    // Function returns the total rows that is currently in the database.
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck) 
    {   
        // [ mysqli_fetch_assoc ]
        // Function returns an associative array that corresponds to the fetched row or NULL if there are no more rows.
        while($row = mysqli_fetch_assoc($result))
        {
            //Here we are retrieving the result and storing it to a variable.
            $acc_id         = $row['accountID'];
            $acc_name       = $row['playername'];
            $acc_adminlvl   = $row['adminlvl'];
            $acc_kills      = $row['kills'];
            $acc_deaths     = $row['deaths'];
            $acc_lastlog    = $row['last_login'];
        }
        
        // Converting timestamp to seconds, minutes, hours days
        // Self Explanatory
        $timestamp_to_sec = round((time() - $acc_lastlog));
        $timestamp_to_min = round(($timestamp_to_sec / 60));
        $timestamp_to_hours = round(($timestamp_to_min / 60));
        $timestamp_to_days = round(($timestamp_to_hours / 24));

        // Converting the converted timestamp according to 'Day(s)', 'Hour(s)', 'Minute(s)', Second(s)'
        // Self Explanatory
        // Supports Singular & Plural
        $last_log_string = '';
        if($timestamp_to_days > 0)
        { 
             $last_log_string = $timestamp_to_days     . " day" . ($timestamp_to_days > 0 ? 's' : ''); 
        }
        else if($timestamp_to_hours > 0)
        { 
             $last_log_string = $timestamp_to_hours    . " hour" . ($timestamp_to_hours > 0 ? 's' : ''); 
        }
        else if($timestamp_to_min > 0)
        { 
            $last_log_string = $timestamp_to_min      . " minute" . ($timestamp_to_min > 0 ? 's' : ''); 
        }
        else if($timestamp_to_sec > 0)
        { 
            $last_log_string = $timestamp_to_sec      . " seconds" . ($timestamp_to_sec > 0 ? 's' : ''); 
        }
        $last_log_string = $last_log_string . ' ' . 'ago';

        // [ header ]
        // Function sends a raw HTTP header to a client.
        // In this case we set the content type to an image and in png file format.
        header('Content-Type: image/png;');
        $source = "sig.png";
        $font = 'font.ttf';

        // [ imagecreatefrompng ]
        // Create a new image from file or URL
        $img = @imagecreatefrompng($source) or die('ERROR: Unable to create image.');
        // [ imagecolorallocate ]
        // Allocate a color for an image -> Right not we've got 255, 255, 255 which is white
        /*
            Parameters:
            (#0) resource $image
            (#1) int $red 
            (#2) int $green
            (#3) int $blue 
        */
        $text_color = imagecolorallocate($img, 255, 255, 255);

        // [ imagettftext ]
        // Write text to the image using TrueType fonts

        /*
            Parameters:
            (#0) resource $image
            (#1) float $size 
            (#2) float $angle 
            (#3) int $x 
            (#4) int $y 
            (#5) int $color 
            (#6) string $fontfile 
            (#7) string $text
        */
        imagettftext($img, 9, 0, 30, 30,    $text_color, $font, "Username: " . $acc_name); 
        imagettftext($img, 9, 0, 30, 50,    $text_color, $font, "Admin Level: " . $acc_adminlvl);  
        imagettftext($img, 9, 0, 30, 70,    $text_color, $font, "Kills: " . $acc_kills);
        imagettftext($img, 9, 0, 30, 90,    $text_color, $font, "Deaths: " . $acc_deaths);
        imagettftext($img, 9, 0, 30, 110,   $text_color, $font, "Last Login: " . $last_log_string);
        
        // [ imagepng ]
        //  Output a PNG image to either the browser or a file
        imagepng($img);

        // [ imagedestroy ]
        // Destroy an image
        imagedestroy($img);
    }
    else 
    {   // [ die ]
        // Function prints a message and terminates the current script.
        die('ERROR: Sorry, We can not find your account in our database.');
    }
    // [ mysql_close ]
    // Closes a previously opened database connection.
    mysqli_close($sqlHandle);
}
else 
{
    // If the user did not input any username 
    // We re-direct him/her back to index.html
    header('Location: index.html');
}
?>



