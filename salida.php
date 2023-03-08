<!doctype html>
<html>

<head>
	<meta charset='UTF-8' />
	<style>
		input,
		textarea {
			border: 1px solid #CCC;
			margin: 0px;
			padding: 0px
		}

		#body {
			max-width: 800px;
			margin: auto
		}

		#log {
			width: 100%;
			height: 400px
		}

		#message {
			width: 100%;
			line-height: 20px
		}
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="fancywebsocket.js"></script>

</head>

<body>
	<div id='body'>
		<textarea id='log' name='log' readonly='readonly'></textarea><br />
		<input type='text' id='message' name='message' />
	</div>

	<body>

		<div> <canvas width="1920" height="1080">
				<div id="qrcode"></div>
			</canvas> </div>
		<script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script>
			// Seccion reloj
			function drawText() {
				// Borrar el canvas

				pincel.clearRect(950, 0, 1200, 75); // Limpiamos el canvas
				pincel.fillStyle = "rgb(33,37,41)";
				pincel.fillRect(600, 0, 1200, 75); // Corregimos el canvas con el color de fondo
				// Obtener la hora actual
				const now = new Date();
				// const time = now.toLocaleTimeString();
				// obtener la fecha y la hora
				const time = now.toLocaleString();
				// Dibujar el texto
				pincel.font = '70px Arial';
				pincel.fillStyle = 'rgb(25,135,84)';
				pincel.textAlign = 'center';
				pincel.textBaseline = 'middle';
				pincel.fillText("fecha : " + time, 1050, 50);
			}
			// Seccion Lineas
			function lineaVertical(posicionIzquierda, posicionDerecha) {
				pincel.beginPath();
				pincel.moveTo(posicionIzquierda, 0);
				pincel.lineTo(posicionIzquierda, 1080);
				pincel.lineTo(posicionDerecha, 1080);
				pincel.lineTo(posicionDerecha, 0);
				pincel.fill();
			}

			function lineaHorizontal(posicionArriba, posicionAbajo) {
				pincel.beginPath();
				pincel.moveTo(0, posicionArriba);
				pincel.lineTo(600, posicionArriba);
				pincel.lineTo(600, posicionAbajo);
				pincel.lineTo(0, posicionAbajo);
				pincel.fill();
			}
			// crea un nuevo objeto `Date`
			var today = new Date();

			// obtener la fecha y la hora
			var now = today.toLocaleString();
			console.log(now);

			var pantalla = document.querySelector("canvas");
			var pincel = pantalla.getContext("2d");
			pincel.fillStyle = "rgb(33,37,41)";
			pincel.fillRect(0, 0, 1680, 1080); // Setear acorde a la resolucion.
			pincel.fillStyle = "black";
			var personasTotal = 200;
			var personasIngresadas = 50;
			/* Linea Horizontal */
			pincel.fillStyle = "white";
			lineaHorizontal(100, 102);
			// Linea Vertical
			pincel.fillStyle = "black";
			pincel.font = '50px Arial';
			pincel.textAlign = 'center';
			pincel.textBaseline = 'middle';
			pincel.fillStyle = "white";
			lineaVertical(298, 300);
			lineaVertical(598, 600);
			// 
			pincel.fillStyle = "rgb(25,135,84)";
			pincel.fillText("Pendientes", 450, 45);
			pincel.fillStyle = "rgb(25,135,84)"; // color para servidas
			pincel.fillText("Servidas", 150, 45);
			pincel.fillText("Personas", 750, 150);
			setInterval(drawText, 1000)
			pincel.fillText(personasIngresadas + "/" + personasTotal, 1050, 150);
			pincel.fillText("20%", 1250, 150);


			// Seccion mesa
			var cantidadMesaServida = 50;
			pincel.fillText("Mesas", 720, 250);
			var cantidadMesaTotal = 100;
			pincel.fillText(cantidadMesaServida + "/" + cantidadMesaTotal, 1050, 250);
			// Seccion Cajita
			pincel.fillText("Cajitas", 720, 350);
			pincel.fillText('10' + "/" + '10', 1050, 350);
			// Seccion Menores
			pincel.fillText("Menores", 740, 450);
			pincel.fillText('10' + "/" + '10', 1050, 450);


			// Seccion Adulto
			pincel.fillText("Adultos", 730, 550);
			pincel.fillText("50/50", 1050, 550);

			// secccion Adolescente
			pincel.fillText("Adolescentes", 780, 650);
			pincel.fillText(" " + '10' + "/" + '10', 1050, 650);
		</script>
		<script>
			var Server;

			function log(text) {
				$log = $('#log');
				$log.append(($log.val() ? "\n" : '') + text);
				$log[0].scrollTop = $log[0].scrollHeight - $log[0].clientHeight;
			}

			function change_command(text) {
				$command = $('#primero');
				console.log(text);
				if (text == "exit") {
					alert("exit");
					pincel.fillText("i need help !", 1050, 800);
				}
				$command.append(($command.val() ? "\n" : '') + text);
				$("#primero").html('<br>' + text + '<br>' + 'jejejeje');
			}

			function send(text) {
				Server.send('message', text);
			}

			$(document).ready(function() {
				log('Connecting...');
				Server = new FancyWebSocket('ws://192.168.100.151:1234');

				$('#message').keypress(function(e) {
					if (e.keyCode == 13 && this.value) {
						log('You: ' + this.value);
						send(this.value);

						$(this).val('');
					}
				});
				Server.bind('open', function() {
					log("Connected.");
				});
				Server.bind('close', function(data) {
					log("Disconnected.");
				});
				Server.bind('message', function(payload) {
					log(payload);
					change_command(payload);
				});
				Server.connect();
			});
		</script>
	</body>

</html>
</body>

</html>