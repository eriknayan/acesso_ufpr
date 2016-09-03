import socket
import sys

# Create TCP socket
sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# Server addr
server_address = ('192.168.25.77', 6066)

while True:
    # Get number from keyboard
    num = raw_input('Type your carteirinha number: ')

    print 'Connecting...'
    sock.connect(server_address)
    try:
        # Send data
        message = num
        print 'Sending "%s" to server ("%s")' % (message, server_address)
        sock.send(message)

        # Get response
        print 'Waiting for response...'
        data = sock.recv(1024)
        print 'Data received: "%s"' % data
        if (data == "SUCCESS"):
            pass # open the gate
            # Tell server we're done
            sock.send("OK")
        elif (data == "NO FUNDS"):
            pass # error, no funds
        elif (data == "NO USER"):
            pass # error, user not found


    finally:
        print 'Closing socket'
        sock.close()