<?php
require_once __DIR__ . '/vendor/autoload.php';


define('APPLICATION_NAME', 'Google Slides API PHP Quickstart');
define('CREDENTIALS_PATH', '~/.credentials/slides.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
//var_dump(CLIENT_SECRET_PATH);
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/slides.googleapis.com-php-quickstart.json
define('SCOPES', implode(' ', array(
  Google_Service_Slides::PRESENTATIONS)
));

if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {

    // $client = new Google_Client();
    // $client->setAuthConfig(CLIENT_SECRET_PATH);
    // $client->setApplicationName(APPLICATION_NAME);
    // $client->setScopes(SCOPES);
    // return $client;


  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfig(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');

  // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
  if (file_exists($credentialsPath)) {
    $accessToken = json_decode(file_get_contents($credentialsPath), true);
    // var_dump($accessToken);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Slides($client);











$texto = '';
include "index.php";


$titulo = 'titulo';

$presentation = new Google_Service_Slides_Presentation(array(
  'title' => $titulo
));

//var_dump($service->presentations->create($presentation));

$presentation = $service->presentations->create($presentation);
printf("Created presentation with ID: %s\n", $presentation->presentationId);
// Prints the number of slides and elements in a sample presentation:
// https://docs.google.com/presentation/d/1EAYk18WDjIG-zp_0vLm3CsfQh_i8eXc67Jo2O9C6Vuc/edit


$presentationId = $presentation->presentationId;
$presentation = $service->presentations->get($presentationId);
$slides = $presentation->getSlides();

printf("The presentation contains %s slides:\n", count($slides));
foreach ($slides as $i => $slide) {
  // Print columns A and E, which correspond to indices 0 and 4.
  printf("- Slide #%s contains %s elements.\n", $i + 1,
      count($slide->getPageElements()));
}
