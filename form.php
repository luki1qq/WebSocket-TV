<?php 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="fancywebsocket.js"></script>
    <script>
		var Server;

        function log( text ) {
            $log = $('#log');
            //Add text to log
            $log.append(($log.val()?"\n":'')+text);
            //Autoscroll
            // $log[0].scrollTop = $log[0].scrollHeight - $log[0].clientHeight;
        }
        function change_command(text){
            $command = $('#primero');
            $commando = $('#primero').html();
            $command.append(($command.val()?"\n":'')+text);
			$("#primero").html('<br>'+text+'<br>'+'jejejeje');
        }

        function send( text ) {
            Server.send( 'message', text );
        }

        $(document).ready(function() {
            log('Connecting...');
            Server = new FancyWebSocket('ws://192.168.100.100:1234');
            $('Enviar').keypress(function(e){
                if ( e.keyCode == 13 && this.value ) {
                    log( 'You: ' + this.value );
                    change_command( this.value );
                    send( this.value );

                    $(this).val('');
                }
            });


            $('#mensaje').keypress(function(e) {
                if ( e.keyCode == 13 && this.value ) {
                    log( 'You: ' + this.value );
                    change_command( this.value );
                    send( this.value );

                    $(this).val('');
                }
            });

            //Let the user know we're connected
            Server.bind('open', function() {
                log( "Connected." );
            });

            //OH NOES! Disconnection occurred.
            Server.bind('close', function( data ) {
                log( "Disconnected." );
            });

            //Log any messages sent from server
            Server.bind('message', function( payload ) {
                log( payload );
                change_command(payload);
            });

            Server.connect();
        });
        function insertar(){
            var mensaje = document.getElementById("mensaje").value;
            var tipo = document.getElementById("tipo").value;
            $.ajax({
                url: "insertar.php",
                type: "POST",
                data: "mensaje="+mensaje+"&tipo="+tipo,
                dataType: "html",
                success: function(data){
                    send(data);
                    console.log(data);
                }
            });
        }
    </script>
    <title>Document</title>
</head>
<body>
    <div id='body'>
		<textarea id='log' name='log' readonly='readonly'></textarea><br/>
		<!-- <input type='text' id='message' name='message' /> -->
	</div>
    <input type="text" name="mensaje" id="mensaje"> <br>
    <select name="tipo" id="tipo">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>
    <input type="submit" value="Enviar" onclick="insertar()">

    <div style="width:300px; height: 200px; border: solid 1px #999999; float: left;">
        <div id='primero' name='primero'></div>
    </div>
</body>
</html>