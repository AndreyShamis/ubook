<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 10/13/2018
 * Time: 16:53
 */

$file = './data/1.html';
$myfile = fopen($file, "r") or die("Unable to open file!");
echo "File size is " . filesize($file);
$text_data = fread($myfile, filesize($file));
fclose($myfile);
$pattern = '/<div class\=\"rt-tr-group\">.*\d+\">(.*)<\/div><\/div>.*\d+\">(.*)<\/div><\/div>.*\">(\d+)<\/div>.*>(.*)<\/div>.*<div.*\">.*<div.*\">(.*)<\/div>(.*)<\/div>.*<div.*\">(.*)<\/div>.*<div.*\">.*class=\"voter\-(.*)\"><select.*<\/div>(.*)<\/div>.*(\d+)<\/div>.*voter-details\/(\d++).*<\/a><\/div><\/div><\/div\>/U';
$text = "He was eating cake in the cafe.";
$matches = preg_match_all($pattern, $text_data, $array, PREG_SET_ORDER);
echo "\n". $matches . " matches were found.\n";
foreach ($array as $key => $value) {
    //print_r($key);
    //print_r($value);
    $lname = $value[1];
    $fname = $value[2];
    $tz = $value[3];
    $addr = $value[4];
    $phone = $value[5];
    $unknown_1 = $value[6];
    $unknown_2 = $value[7];
    $support = $value[8];
    $unknown_3 = $value[9];
    $unknown_4 = $value[10];
    $site_id = $value[11];
    echo "$lname\t\t$fname\t\t$tz\t$addr\t\tPhone: $phone ||| \t\tU1:$unknown_1\tU2:$unknown_2\t$support\t\tU3:$unknown_3\tU4:$unknown_4\t$site_id\n";
    //print_r($key);

}
//print_r($array);
