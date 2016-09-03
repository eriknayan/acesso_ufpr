import SocketServer
import MySQLdb

PRICE = 1.30

def parseFloat (data):
    """
    Converts string to float. Returns -999 if cannot convert
    """
    try:
        return float(data)
    except ValueError:
        return -999

class MyTCPHandler(SocketServer.BaseRequestHandler):
    """
    The request handler class for our server.

    It is instantiated once per connection to the server, and must
    override the handle() method to implement communication to the
    client.
    """

    def handle(self):
        # self.request is the TCP socket connected to the client
        self.data = self.request.recv(1024).strip()
        print "{} wrote:".format(self.client_address[0])
        print self.data

        # Data received was not a float
        if (self.data == None):
            return
        num = parseFloat(self.data)
        if (num == -999):
            return

        db = MySQLdb.connect(   host="localhost",
                                user="XXX",
                                passwd="XXX",
                                db="acessoufpr")
        cur = db.cursor()
        cur.execute("SELECT * FROM Users WHERE id=%s", (self.data,))

        rows = cur.fetchall()
        # Check if there is any match
        if (len(rows) != 0):
            for row in rows:
                print row
                # Extract fields from db
                self.my_id = row[0]
                self.name = row[1]
                self.email = row[2]
                self.balance = row[3]

            # Check if there is enough balance
            if (self.balance > PRICE):
                # Send SUCCESS to client
                self.msg_back = "Hi "+self.name + ". Your new balance is : " + str(self.balance-PRICE)
                self.request.send(self.msg_back)

                # Receive confirmation
                self.data = self.request.recv(1024).strip()
                print "{} confirmation:".format(self.client_address[0])
                print self.data

            if (self.data == "OK"):
                    self.balance -= PRICE # Update balance
                    cur.execute("UPDATE Users SET balance=%s WHERE name=%s",(self.balance,self.name))
                    db.commit() # Apply changes to db
                    print "Transaction Complete"
            else:
                # Send NO BALANCE to client
                self.msg_back = "NO BALANCE"
                self.request.send(self.msg_back)
        else:
            # No matching user found on db, reporting to client
            self.msg_back = "NO USER"
            self.request.send(self.msg_back)
        cur.close()
        db.close()
        return

if __name__ == "__main__":
    HOST, PORT = "192.168.25.77", 6066

    # Create the server, binding to localhost on port 6066
    SocketServer.TCPServer.allow_reuse_address = True
    server = SocketServer.TCPServer((HOST, PORT), MyTCPHandler)

    # Activate the server; this will keep running until you
    # interrupt the program with Ctrl-C
    server.serve_forever()