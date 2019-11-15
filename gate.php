<?php

session_start();
$nim = $_SESSION['nim'];

$curl = curl_init();

  curl_setopt_array($curl, array(
//    CURLOPT_PORT => "5005",
    CURLOPT_URL => "http://52.148.88.134/api/auth",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => '{"username": "me","password": "12345678"}',
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    return "cURL Error #:" . $err;
  } else {
    $resp = json_decode($response);
    $token = $resp->access_token;
  }

/////////////////////////////////////////////////////////

  $q = $_POST['q'];
  $sender = $_POST['sender'];
  $query = $q;
  $curl = curl_init();

  curl_setopt_array($curl, array(
//    CURLOPT_PORT => "5005",
    CURLOPT_URL => "http://52.148.88.134/api/conversations/".$nim."/messages",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => '{"sender":"'.$sender.'","message":"'.$query.'"}',
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Bearer ".$token
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    return "cURL Error #:" . $err;
  } else {
    $resp = json_decode($response);

    $data = array();

    $i = 0;

    foreach($resp as $resp) {
      if(isset($resp->buttons)) {
        $data[$i] = array(
        'text' => nl2br($resp->text),
        'buttons' => $resp->buttons
      );
      } else {
        $data[$i] = array(
        'text' => nl2br($resp->text)
       );
      }

      $i++;
    }


    echo json_encode($data);

  }

?>

