
<?php

define('BOT_TOKEN', '361639795:AAFh4cfx0XFeNgGk7JbDZwi_0p-Hkc9selY');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');



function apiRequestWebhook($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  header("Content-Type: application/json");
  echo json_encode($parameters);
  return true;
}

function exec_curl_request($handle) {
  $response = curl_exec($handle);

  if ($response === false) {
    $errno = curl_errno($handle);
    $error = curl_error($handle);
    error_log("Curl returned error $errno: $error\n");
    curl_close($handle);
    return false;
  }

  $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
  curl_close($handle);

  if ($http_code >= 500) {
    // do not wat to DDOS server if something goes wrong
    sleep(10);
    return false;
  } else if ($http_code != 200) {
    $response = json_decode($response, true);
    error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
    if ($http_code == 401) {
      throw new Exception('Invalid access token provided');
    }
    return false;
  } else {
    $response = json_decode($response, true);
    if (isset($response['description'])) {
      error_log("Request was successfull: {$response['description']}\n");
    }
    $response = $response['result'];
  }

  return $response;
}

function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = API_URL.$method.'?'.http_build_query($parameters);

  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);

  return exec_curl_request($handle);
}

function apiRequestJson($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  $handle = curl_init(API_URL);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
  curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

  return exec_curl_request($handle);
}

function processMessage($message) {
  // process incoming message
  $message_id = $message['message_id'];
  $chat_id = $message['chat']['id'];

  $user_replay_message = $message['reply_to_message']['forward_from']['id'];
  
  $servername = "localhost";
$username = "ggmarket_b";
$password = "amir8520";
$dbname = "ggmarket_b";



 
    // incoming text message
    $text = $message['text'];

    if (strpos($text, "/start") === 0) {
        




    //   apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => 'سلام.خوش اومدی.', 'reply_markup' => array(
    //     'keyboard' => array(array('Hello', 'سلام')),
    //     'one_time_keyboard' => true,
    //     'resize_keyboard' => true)));
              apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => '
              سلام.خوش آمدید.
 ' ));
         apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => 'کانال سازنده [TELE TOBOT](http://t.me/teleroobot)', 'parse_mode' => 'Markdown'));
        


    }else if($text == "/help") {
      
      
      
      apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => '*bold* درشت نویسی
      
_کج نویسی_

[متن جهت لینک دار کردن](http://www.example.com/)

`inline fixed-width code یک خط کد`

```
چند خط کد
pre-formatted fixed-width code block
```'));

apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => '', 'parse_mode' => 'Markdown'));

         
    }else{
        
       
        if(isset($message['photo'])){
            // image 1
            
        apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => "
file size : ".$message['photo']['0']['file_size']."
-----
".$message['photo']['0']['width']."X".$message['photo']['0']['height']."
-----
File Id : 👇👇", 'parse_mode' => 'Markdown'));

apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => $message['photo']['0']['file_id'], 'parse_mode' => 'Markdown'));

            //image 2
            
        apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => "

file size : ".$message['photo']['1']['file_size']."
-----
".$message['photo']['1']['width']."X".$message['photo']['1']['height']."
-----
File Id : 👇👇", 'parse_mode' => 'Markdown'));

     apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => $message['photo']['1']['file_id'], 'parse_mode' => 'Markdown'));
            //image 3

apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => "

file size : ".$message['photo']['2']['file_size']."
-----
".$message['photo']['2']['width']."X".$message['photo']['2']['height']."
-----
File Id : 👇👇", 'parse_mode' => 'Markdown'));

apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => $message['photo']['2']['file_id'], 'parse_mode' => 'Markdown'));

        }else if(isset($message['audio'])){
            apiRequestJson("sendMessage", array('chat_id' => $chat_id, 'text' => "title : ".$message['audio']['title']."
performer :".$message['audio']['performer']."
file size : ".$message['audio']['file_size']."
File Id : 👇👇"));
apiRequestJson("sendMessage", array('chat_id' => $chat_id, 'text' => $message['audio']['file_id']));
            
            }else{
            apiRequestJson("sendAudio", array('chat_id' => $chat_id, 'audio' => $text));
           apiRequestJson("sendPhoto", array('chat_id' => $chat_id, 'photo' => $text));
           
        }
    }
    
    
  
}


define('WEBHOOK_URL', 'https://my-site.example.com/secret-path-for-webhooks/');

if (php_sapi_name() == 'cli') {
  // if run from console, set or delete webhook
  apiRequest('setWebhook', array('url' => isset($argv[1]) && $argv[1] == 'delete' ? '' : WEBHOOK_URL));
  exit;
}


$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
  // receive wrong update, must not happen
  exit;
}

if (isset($update["message"])) {
  processMessage($update["message"] );
}
