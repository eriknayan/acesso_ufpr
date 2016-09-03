import socket
import sys

while True:
    # Create TCP socket
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

    # Server addr
    server_address = ('acessoufpr.ddns.net', 6066)

    # Get number from keyboard
    try:
        num = input('Type your carteirinha number: ')
    except SyntaxError: # Case input was left blank
        continue

    print 'Connecting...'
    sock.connect(server_address)
    try:
        # Send data
        message = str(num)
        print 'Sending "%s" to server ("%s")' % (message, server_address)
        sock.send(message)

        # Get response
        print 'Waiting for response...'
        data = sock.recv(1024)
        print 'Data received: "%s"' % data
        sock.send("OK")
        if (data == "SUCCESS"):
            pass # open the gate
            # Tell server we're done
            #sock.send("OK")
        elif (data == "NO FUNDS"):
            pass # error, no funds
        elif (data == "NO USER"):
            pass # error, user not found
        else:
            pass # unknown message
    finally:
        print 'Closing socket'
        sock.close()