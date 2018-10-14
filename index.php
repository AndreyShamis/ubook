<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 10/13/2018
 * Time: 16:53
 */

require __DIR__ . '/vendor/autoload.php';
//
//define('APPLICATION_NAME', 'spreadform');
//define('CREDENTIALS_PATH', './token.json');
//define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
define('SCOPES', implode(' ', array(
        Google_Service_Sheets::SPREADSHEETS)
));
//require_once './vendor/autoload.php';
if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}


/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 * @throws Google_Exception
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('ubook');
    //$client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
    $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}


// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
$spreadsheetId = '1bPaNJKQiWHmimRCeYFplh0JDpFAyHHrBNeh6pR6U-Jg';
$range = 'Users!A2:L';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

if (empty($values)) {
    print "No data found.\n";
} else {
    print "Name, Major:\n";
    foreach ($values as $row) {
        // Print columns A and E, which correspond to indices 0 and 4.
        printf("%s, %s\n", $row[0], $row[1]);
    }
}

$file = './data/1.html';
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
    $unknown_1 = $value[6];
    $unknown_2 = $value[7];
    $support = $value[8];
    $unknown_3 = $value[9];
    $unknown_4 = $value[10];
    $site_id = $value[11];

    //$updateRange = 'I'.$currentRow;
    $values = [
        'first_name'         => $fname,
        'LastName'          => $lname,
        'ID'                => $tz,
        'Address'           => $addr,
        'Phone'             => $phone,
        'unknown_1'         => $unknown_1,
        'unknown_2'         => $unknown_2,
        'support'           => $support,
        'unknown_3'         => $unknown_3,
        'unknown_4'         => $unknown_4,
        'src_id'            => $site_id
    ];
    $values_keys = [
        'first_name',
        'LastName',
        'ID',
        'Address',
        'Phone',
        'unknown_1',
        'unknown_2',
        'support',
        'unknown_3',
        'unknown_4',
        'src_id'];
    $values2 = [$fname, $lname, $tz, $addr, $phone, $unknown_1, $unknown_2, $support, $unknown_3, $unknown_4, $site_id];
    //$requestBody = new Google_Service_Sheets_BatchUpdateValuesRequest([
    $arr = [$values2];
    $requestBody = new Google_Service_Sheets_ValueRange([
        'values' => $arr
    ]);
    $response = null;
    $params = [
        'valueInputOption' => 'RAW'
    ];
    try {
        $response = $service->spreadsheets_values->append($spreadsheetId, $range, $requestBody, $params);
        //echo '<pre>', var_export($response, true), '</pre>', "\n";

    } catch (Exception $ex) {
        print_r($ex);
    }
    //$response = $service->spreadsheets_values->batchUpdate($spreadsheetId, $range, $requestBody, $params);

    echo "$lname\t\t$fname\t\t$tz\t$addr\t\tPhone: $phone ||| \t\tU1:$unknown_1\tU2:$unknown_2\t$support\t\tU3:$unknown_3\tU4:$unknown_4\t$site_id\n";
    //print_r($key);

    //exit();

}
//print_r($array);
