#!/usr/bin/env python
""" !- counter.py ~ Count website viewers in real time! | By: Willy Fox ~ @BlackVikingPro -! """

import os, sys, socket, time, json
from datetime import date

# creating a socket object
conn = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# get local Host machine name
host = '' # or just use (host == '')
port = 9000

# bind to pot
conn.bind((host, port))

# Que up to 10 requests
conn.listen(10)

x = 0
print "Listening on " + host + ":" + str(port) + "...\n"
try:
	while True: # establish connection
		clientSocket, addr = conn.accept()
		while clientSocket:
			data = clientSocket.recv(4096)
			if not data: break;
			x += 1
			payload = json.loads(data)
			print "Client IP Address: " + payload['clientIP']
			print "Requested URL: " + payload['requestURL']
			print "User Agent: " + payload["userAgent"]
			print "Host Name: " + payload["hostName"]
			print # extra whitespace
			with open("realtime-viewers.{}.log".format(str(date.today().month) + "-" + str(date.today().day) + "-" + str(date.today().year)), "a") as logfile:
				logfile.write(data + "\n")
				pass
except KeyboardInterrupt:
	print # extra whitespace
	conn.close() # close socket
	pass
