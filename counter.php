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
			if (filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
				$ipaddress = htmlspecialchars($_SERVER['HTTP_X_FORWARDED_FOR']);
			else
				$ipaddress = htmlspecialchars($_SERVER['REMOTE_ADDR']);
		} else {
			$ipaddress = htmlspecialchars($_SERVER['REMOTE_ADDR']);
		}

		/* Create a TCP/IP socket. */
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket === false)
			throw new Exception("[! ViCo !] - socket_create() failed: reason: " . socket_strerror(socket_last_error()), 1);

		// echo "Attempting to connect to '$server' on port '$port'...";
		$result = socket_connect($socket, $server, $port);
		if ($result === false)
			throw new Exception("[! ViCo !] - socket_connect() failed.", 1);

		$outData = array(
			'clientIP'		=> $ipaddress,
			'requestURL'	=> $_SERVER['REQUEST_URI'],
			'userAgent' 	=> $_SERVER['HTTP_USER_AGENT'],
			'hostName' 		=> gethostbyaddr($ipaddress)
		);

		$payload = json_encode($outData);

		if ($socket && $result)
			socket_write($socket, $payload, strlen($payload));
		
		socket_close($socket);
	}
}

?>