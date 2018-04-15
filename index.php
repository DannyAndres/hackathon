<?php
require_once __DIR__ . '/vendor/autoload.php';


define('APPLICATION_NAME', 'script');
define('CREDENTIALS_PATH', '~/.credentials/slides.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

define('SCOPES', implode(' ', array(
  Google_Service_Slides::PRESENTATIONS)
));

// if (php_sapi_name() != 'cli') {
//   throw new Exception('This application must be run on the command line.');
// }

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {


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
    //echo '<a href="' . $authUrl . '">'$authUrl'</a>';
    //printf('<a href=" . %s . ">%s</a>\n%s\n', $authUrl);
    //print 'Enter verification code: ';
    include './view/verification.php';
    //$authCode = trim(fgets(STDIN));
    $authCode = trim(htmlspecialchars($_POST['code']));
    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    //printf("Credentials saved to %s\n", $credentialsPath);
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



// //printf("The presentation contains %s slides:\n", count($slides));
// foreach ($slides as $i => $slide) {
//   // Print columns A and E, which correspond to indices 0 and 4.
//   //printf("- Slide #%s contains %s elements.\n", $i + 1,
//       count($slide->getPageElements()));
// }





function getMainId($titulo,$service){
  $title = $titulo;

  $presentation = new Google_Service_Slides_Presentation(array(
    'title' => $title,
  ));

  $presentation = $service->presentations->create($presentation);
  //printf("Created presentation with ID: %s\n", $presentation->presentationId);

  $presentationId = $presentation->presentationId;
  return $presentationId;
}

function init($presentationId,$service){
  $presentation = $service->presentations->get($presentationId);
  $slides = $presentation->getSlides();
  return $slides;
}


function createSlide($layout,$slidesId,$slides,$presentationId,$service){
  $requests = [];
  if (!isset($layout)) {
    $requests[] = new Google_Service_Slides_Request(array(
      'createSlide' => array (
        'insertionIndex' => count($slides),
      )
    ));
  }
  else {
    $requests[] = new Google_Service_Slides_Request(array(
      'createSlide' => array (
        'insertionIndex' => count($slides),
        'slideLayoutReference' => array (
          'predefinedLayout' => 'TITLE_AND_BODY'
        )
      )
    ));
  }

  $batchUpdateRequest = new Google_Service_Slides_BatchUpdatePresentationRequest(array(
    'requests' => $requests
  ));
  $response = $service->presentations->batchUpdate($presentationId, $batchUpdateRequest);
  $createSlideResponse = $response->getReplies()[0]->getCreateSlide();
  ////printf("Created slide with ID: %s\n", $createSlideResponse->getObjectId());
  $ids = $slidesId;
  array_push($ids,$createSlideResponse->getObjectId());
  return $ids;
}



function getSlides($presentationId,$service){
  $response = $service->presentations->get($presentationId);
  $slides = $response->getSlides();
  return $slides;
}


function insertText($text,$size,$objectId,$numberSlide,$presentationId,$service){
  // Create a new square textbox, using the supplied element ID.
  $height = array('magnitude' => $size[0], 'unit' => 'PT');
  $width = array('magnitude' => $size[1], 'unit' => 'PT');
  $requests = array();
  $requests[] = new Google_Service_Slides_Request(array(
    'createShape' => array (
      'objectId' => $objectId,
      'shapeType' => 'TEXT_BOX',
      'elementProperties' => array(
        'pageObjectId' => $numberSlide,
        'size' => array(
          'height' => $height,
          'width' => $width
        ),
        'transform' => array(
          'scaleX' => 1,
          'scaleY' => 1,
          'translateX' => $size[2],
          'translateY' => $size[3],
          'unit' => 'PT'
        )
      )
    )
  ));

  // Insert text into the box, using the supplied element ID.
  $requests[] = new Google_Service_Slides_Request(array(
    'insertText' => array(
      'objectId' => $objectId,
      'insertionIndex' => 0,
      'text' => $text
    )
  ));
  // Execute the requests.
  $batchUpdateRequest = new Google_Service_Slides_BatchUpdatePresentationRequest(array(
    'requests' => $requests
  ));
  $response = $service->presentations->batchUpdate($presentationId, $batchUpdateRequest);
  $createShapeResponse = $response->getReplies()[0]->getCreateShape();
  //printf("Created textbox with ID: %s\n", $createShapeResponse->getObjectId());
}


// {
//   altura
//   anchura
//   translate x
//   translate y
// }




//entrada
// $texto = [
//   ['los patos','los patos no tienen eco'],
//   ['los gatos','los gatos son malevolos'],
// ];


$slidesId = [];
$idIncremental = 0;

$presentationId = getMainId('titulo',$service);
$slides = init($presentationId,$service);

insertText('titulo',[48,670,27,35],'textP','p',$presentationId,$service);
insertText('pararafo',[250,670,27,95],'textP2','p',$presentationId,$service);

$texto = '';
include './view/home.php';

$texto = [
  ['los patos','los patos no tienen eco'],
  ['los gatos','los gatos son malevolos'],
];


foreach ($texto as $element) {
  $slidesId = createSlide(null,$slidesId,$slides,$presentationId,$service);
  insertText($element[0],[48,670,27,35],'text'.strval($idIncremental),$slidesId[count($slidesId)-1],$presentationId,$service);
  $idIncremental++;
  insertText($element[1],[250,670,27,95],'text'.strval($idIncremental),$slidesId[count($slidesId)-1],$presentationId,$service);
  $idIncremental++;
}
//echo 'sdklgjhslkfjdgh';

//var_dump(count($slides));
$slides = getSlides($presentationId,$service);

