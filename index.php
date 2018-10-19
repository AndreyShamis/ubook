<?php
/**
 * User: Andrey lolnik@gmail.com
 * Date: 10/13/2018
 * Time: 16:53
 */

require_once "bootstrap.php";
require __DIR__ . '/vendor/autoload.php';

for ($x=1; $x<20;$x++){
    $file = './data/'.$x.'.html';
    $myfile = fopen($file, 'rb') or die('Unable to open file!');
    echo 'File size is ' . filesize($file);
    $text_data = fread($myfile, filesize($file));
    fclose($myfile);
    $pattern = '/<div class\=\"rt-tr-group\">.*\d+\">(.*)<\/div><\/div>.*\d+\">(.*)<\/div><\/div>.*\">(\d+)<\/div>.*>(.*)<\/div>.*<div.*\">.*<div.*\">(.*)<\/div>(.*)<\/div>.*<div.*\">(.*)<\/div>.*<div.*\">.*class=\"voter\-(.*)\"><select.*<\/div>(.*)<\/div>.*(\d+)<\/div>.*voter-details\/(\d++).*<\/a><\/div><\/div><\/div\>/U';
    $text = 'He was eating cake in the cafe.';
    $matches = preg_match_all($pattern, $text_data, $array, PREG_SET_ORDER);
    echo "\n". $matches . " matches were found.\n";

    foreach ($array as $key => $value) {
        //print_r($key);
        //print_r($value);
        $fname = $value[1];
        $lname = $value[2];
        $tz = $value[3];
        $addr = $value[4];
        $phone = $value[5];
        //$unknown_1 = $value[6];
        $birthdate = $value[7];
        $support = $value[8];
        //$unknown_3 = $value[9];
        $responsiveWorkers = $value[10];
        $site_id = $value[11];

        $user = new User();
        $user->setFirstName($fname);
        $user->setLastName($lname);
        $user->setSpecialId((int)$tz);
        $user->setAddress($addr);
        $user->setPhone($phone);
        $support = str_replace(array('unknown-supporting', 'unverified-supporting'), array('unknown', 'unverified'), $support);
        $user->setSupport($support);
        $user->setSiteId((int)$site_id);
        $user->setBirthdate($birthdate);
        $user->setResponsiveWorkers((int)$responsiveWorkers);

        $entityManager->persist($user);
        //echo "Created User with ID " . $user->getId() . "\n";
    }
    echo "Flushing $x\n";
    $entityManager->flush();
    $entityManager->clear();
    echo "Finish\n";
}
