<?php
include("conect.php");
$res1 = $conex->query("SELECT * FROM mensajes where tipo = '1'");
// $res2 = mysqli_query("SELECT * FROM mensajes where tipo = '2'");
// $res3 = mysqli_query("SELECT * FROM mensajes where tipo = '3'");
// $res4 = mysqli_query("SELECT * FROM mensajes where tipo = '4'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="fancywebsocket.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>

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
    console.log(text);
    // Aca se puede enviar comandos al cliente que está conectado.
    if(text == 'alerta'){
        alert('hola'); 
    }
    // $commando = $('#primero').html();
    $command.append(($command.val()?"\n":'')+text);
    $("#primero").html('<br>'+text+'<br>'+'jejejeje');
}

function send( text ) {
    Server.send( 'message', text );
}

$(document).ready(function() {
    log('Connecting...');
    Server = new FancyWebSocket('ws://192.168.100.151:1234');

    $('#message').keypress(function(e) {
        if ( e.keyCode == 13 && this.value ) {
            log( 'You: ' + this.value );
            // change_command( this.value );
            send( this.value );
            console.log(this.value);

            $(this).val('');

        }
    });

    //Let the user know we're connected
    Server.bind('open', function() {
        log( "Connected." );
        <?php
        $texto = $_GET['texto'];?>
        var texto = '<?php echo json_encode($texto); ?>';
        console.log(texto);
        if(texto.length != 0){
            log( 'You: ' + texto);
            // change_command(texto);
            send(texto );
        }
        
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

<body>
    <div id='body'>
            <textarea id='log' name='log' readonly='readonly'></textarea><br/>
            <input type='text' id='message' name='message' />
    </div>
    <div style="width:300px; height: 200px; border: solid 1px #999999; float: left;">
        <div id='primero' name='primero'></div>
    </div>
    <!-- <?php while($arr = mysqli_fetch_array($res1)){ echo $arr['timestamp']." : ".$arr['mensaje']. "<br>" ;}?> -->
</body>
</html>