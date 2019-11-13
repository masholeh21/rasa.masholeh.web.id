<?php

$url = 'http://localhost:8000/logout';

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'GET'
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$data = json_decode($result,true);

if($data['success']==false){
	session_start();
	session_destroy();

	echo '<script type="text/javascript">alert("Logout success!");</script>';
	echo '<script>location.href="index.php"</script>';
}else{

}

?>
