var FancyWebSocket = function(url)
{
	var callbacks = {};
	var ws_url = url;
	var conn;

	this.bind = function(event_name, callback){
		callbacks[event_name] = callbacks[event_name] || [];
		callbacks[event_name].push(callback);
		return this;// chainable
	};

	this.send = function(event_name, event_data){
		this.conn.send( event_data );
		return this;
	};

	this.connect = function() {
		if ( typeof(MozWebSocket) == 'function' )
			this.conn = new MozWebSocket(url);
		else
			this.conn = new WebSocket(url);

		// dispatch to the right handlers
		this.conn.onmessage = function(evt){
			dispatch('message', evt.data);
		};

		this.conn.onclose = function(){dispatch('close',null)}
		this.conn.onopen = function(){dispatch('open',null)}
	};

	this.disconnect = function() {
		this.conn.close();
	};

	var dispatch = function(event_name, message){
		if(message == null || message == ""){
		}else{
			var JSONdata = JSON.parse(message);
			var tipo = JSONdata[0].tipo;
			var mensaje = JSONdata[0].mensaje;
			var fecha = JSONdata[0].fecha;
			var contenidoDiv = $("#"+tipo).html();
			var mensajehtml = fecha+' : '+mensaje;
			$("#"+tipo).html(contenidoDiv+'<br>'+mensajehtml);
		}
			
	}
};


var Server;

function log( text ) {
	$log = $('#log');
	//Add text to log
	$log.append(($log.val()?"\n":'')+text);
	//Autoscroll
	$log[0].scrollTop = $log[0].scrollHeight - $log[0].clientHeight;
}

function send( text ) {
	Server.send( 'message', text );
}

$(document).ready(function() {
	log('Connecting...');
	Server = new FancyWebSocket('ws://192.168.100.100:1234');

	$('#message').keypress(function(e) {
		if ( e.keyCode == 13 && this.value ) {
			log( 'You: ' + this.value );
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
	});

	Server.connect();
});