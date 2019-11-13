<?php
session_start();

if($_SESSION['status'] !="login"){
	header("location:index.php");
}

// $url = 'http://localhost:8000/user';
// $data = array(
// 	'nim' => $_SESSION['nim']
// );

// $options = array(
//     'http' => array(
//         'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
//         'method'  => 'POST',
//         'content' => http_build_query($data)
//     )
// );

// $context  = stream_context_create($options);
// $result = file_get_contents($url, false, $context);
// $data = json_decode($result,true);

?>
<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

	<script src="jquery-2.2.4.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.css">
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="style-chat.css">
	<!-- custom scrollbar plugin -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

	<script type="text/javascript">

	function scrolltodown() {
		$(".message").mCustomScrollbar({
		    //your options...
		}).mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
	}

	scrolltodown();

	</script>
</head>
	<script type="text/javascript">
    	$(document).ready(function() {
			$("#input").keypress(function(event) {
				if (event.which == 13) {
					$('.chatBox').append('<li class="msg-right"><div class="msg-right-sub"><img src="user.png"><div class="msg-desc">' + $('#input').val() + '</div><small>05:25 am</small></div></li>')
					event.preventDefault();
					let query  = $('#input').val()
					$('#input').val('')
					send(query);
				}
			});
		});

		function send(query) {
			sender = '<?php echo $_SESSION["nim"]; ?>';
			var text = query;
			console.log(query);
			$.ajax({
				type: "POST",
				url: "gate.php",
				data: {q:text, sender:sender},
				success: function(data) {
					console.log(data);
					console.log( jQuery.parseJSON (data));
					setResponse(jQuery.parseJSON (data));
				}
			});

		}

		 function terserah(item) {

	 	 $('input').val(item);
		 $('.chatBox').append('<li class="msg-right"><div class="msg-right-sub"><img src="user.png"><div class="msg-desc">' + $('input').val() + '</div><small>05:25 am</small></div></li>');
					let query  = $('input').val()
					$('input').val('')
					send(query);
					scrolltodown();
		}

		function setResponse(val) {

			val.forEach(function(item, index) {
			    var button = '';
				if(val[index].buttons) {
					val[index].buttons.forEach(myFunction);

						function myFunction(item, index) {
							button += `<a class="btn btn-info" onclick="terserah('`+item.payload+`')">`+item.title+`</a> &nbsp;`;
						}
				}

				$('.chatBox').append('<li class="msg-left"><div class="msg-left-sub"><img src="bot.png"><div class="msg-desc">' + val[index].text + '<br>'+ button +'</div><small>05:25 am</small></div></li>');

				scrolltodown();
			});

			// var button = '';
			// if(val.buttons) {

			// 	val.buttons.forEach(myFunction);

			// 		function myFunction(item, index) {
			// 			button += `<a class="btn btn-info" onclick="terserah('`+item.payload+`')">`+item.title+`</a> &nbsp;`;
			// 		  console.log(index);
			// 		}
			// }



		}
	</script>
<body>
	<div class="main-section">
		<div class="head-section">
			<div class="headRight-section">
				<div class="headRight-sub">
					<h4><?php echo $_SESSION['nama']; ?></h4>
					<span><?php echo $_SESSION['nim']; ?></span>
				</div>
			</div>
		</div>
		<div class="body-section">
			<div class="right-section">
				<div class="message" data-mcs-theme="minimal-dark">
					<ul>
						<div class="chatBox"></div>
					</ul>
				</div>
				<div class="right-section-bottom">
					<div class="upload-btn">
					<label for="input-file" class="upload-btn">
					    <i class="fa fa-photo btn"></i>
					</label>
					<input id="input-file" type="file" name="" />
					</div>
					<input id="input" type="text" name="" placeholder="type here...">
					<button id="rec" class="btn-send"><i class="fa fa-send"></i></button>
				</div>
			</div>
		</div>
	</div>
	<br>
	<center>
		<a href="logout.php" class="btn btn-danger login">Logout</a>
	</center>


</body>
</html>
