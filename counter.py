#!/usr/bin/env python
""" !- Counter.py ~ Count website viewers in real time! | By: Willy Fox ~ @BlackVikingPro -! """

import os, sys, socket, time
from datetime import date

# creating a socket object
conn = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# get local Host machine name
host = '' # or just use (host == '')
port = 9000

# bind to pot
conn.bind((host, port))

# Que up to 1 requests
conn.listen(1)

x = 0
while True:
	# establish connection
	clientSocket, addr = conn.accept()
	while clientSocket:	
		data = clientSocket.recv(4096)
		if not data: break
		x += 1
		sys.stdout.write('\r Total Viewers: ' + str(x) + ' | IP: ' + data + '                              '); sys.stdout.flush()
		with open("realtime-viewers.{}.log".format(str(date.today().month) + "-" + str(date.today().day) + "-" + str(date.today().year)), "a") as logfile:
			logfile.write(data + "\n")
			pass
		# print("got a connection from %s" % str(addr))