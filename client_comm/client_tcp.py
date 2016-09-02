import socket
import sys

# Create TCP socket
sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# Server addr
server_address = ('localhost', 6066)

# Get number from keyboard
num = raw_input('Type your carteirinha number: ')

print 'Connecting...'
sock.connect(server_address)
try:
    # Send data
    message = num
    print 'Sending "%s" to server' % message
    sock.send(message)

    # Get response
    print 'Waiting for response...'
    SIZE = 1024;
    data = sock.recv(SIZE)
    print 'Teste'
    # SUCCESS: Number is on db
    if (data == "100"):
        print 'Success!'
    elif (data == "200"):
        print 'Failed!'
    else:
        print 'Unknown data received: "%s"' % data
    
finally:
    print 'Closing socket'
    sock.close()