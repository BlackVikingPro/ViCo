<?php
/**
* !- Realtime-Viewers ~ Count website viewers in real time! | By: Willy Fox ~ @BlackVikingPro -!
*/
class ViCo
{
	function ViewCounter($server, $port)
	{
		/* Get the IP address for the client host */
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ipaddress = htmlspecialchars($_SERVER['HTTP_X_FORWARDED_FOR']);
		} else {
			$ipaddress = htmlspecialchars($_SERVER['REMOTE_ADDR']);
		}

		/* Create a TCP/IP socket. */
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket === false) {
			echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
		}

		// echo "Attempting to connect to '$server' on port '$port'...";
		$result = socket_connect($socket, $server, $port);
		if ($result === false) {
				echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
		}

		$in = $ipaddress;
		$out = '';

		socket_write($socket, $in, strlen($in));
		// echo "OK.\n";

		socket_close($socket);
	}
}

?>