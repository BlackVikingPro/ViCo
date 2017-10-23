/* counter.cpp ~ Count website viewers in real time!
   Created by: Willy Fox ~ @BlackVikingPro */

// Compile with: gcc -o counter.exe counter.cpp -lstdc++

#include <iostream>
#include <fstream>
#include <sstream>
#include <string.h>	//strlen
#include <sys/socket.h>
#include <arpa/inet.h> //inet_addr
#include <unistd.h>	//write

// Config
#define port 9000

int main()
{
	int socket_desc , client_sock , c , read_size;
	struct sockaddr_in server , client;
	char client_message[4096];

	// Create socket
	socket_desc = socket(AF_INET , SOCK_STREAM , 0);
	if (socket_desc == -1)
		printf("Could not create socket");

	// Prepare the sockaddr_in structure
	server.sin_family = AF_INET;
	server.sin_addr.s_addr = INADDR_ANY;
	server.sin_port = htons( port );

	// Bind
	if (bind(socket_desc,(struct sockaddr *)&server , sizeof(server)) < 0)
	{
		//print the error message
		perror("Bind failed. Error");
		return 1;
	}

	// Listen
	listen(socket_desc , 10); // 10 max connections

	// Accept and incoming connection
	std::cout << "Listening on " << ":" << port << "..." << std::endl;
	c = sizeof(struct sockaddr_in);

	while (true) {
		// Accept connection from an incoming client
		client_sock = accept(socket_desc, (struct sockaddr *)&client, (socklen_t*)&c);
		if (client_sock < 0)
		{
			perror("accept failed");
			return 1;
		}

		//Receive a message from client
		while ((read_size = recv(client_sock , client_message , 4096 , 0)) > 0 ) {
			std::cout << client_message << std::endl;
			std::ofstream logfile;
			time_t now = time(0); struct tm tstruct; char date[80]; tstruct = *localtime(&now);
			strftime(date, sizeof(date), "%m-%d-%Y", &tstruct);
			std::stringstream ss; ss << "realtime-viewers." << date << ".log"; std::string logfile_name = ss.str();
			logfile.open(logfile_name, std::ios_base::app); logfile << client_message << "\n"; logfile.close();
		}
			// write(client_sock , client_message , strlen(client_message)); //Send the message back to client
	}
	if (read_size == 0)
	{
		fflush(stdout);
	} else if (read_size == -1)
		perror("recv failed");

	return 0;
}