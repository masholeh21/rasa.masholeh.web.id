<?php

$url = 'http://api.masholeh.web.id/login';
$data = array(
	'nim' => $_POST['nim'],
	'password' => $_POST['password']
);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$data = json_decode($result,true);

if($data['success']){
	session_start();
	$_SESSION['status']='login';
	$_SESSION['nama'] = $data['message']['nama'];
	$_SESSION['nim'] = $data['message']['nim'];

	echo '<script type="text/javascript">alert("Login success!");</script>';
	echo '<script>location.href="chat.php"</script>';
}else{
	echo '<script type="text/javascript">alert("Password Salah !");</script>';
	echo '<script>location.href="index.php"</script>';
}

?>
