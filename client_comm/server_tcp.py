import SocketServer
import MySQLdb

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
        self.data = self.request.recv().strip()
        print "{} wrote:".format(self.client_address[0])
        print self.data

        # Data received was not a float
        num = parseFloat(self.data)
        if (num == -999):
            return

        db = MySQLdb.connect(   host="localhost",
                                user="XXX",
                                passwd="XXX",
                                db="acessoufpr")
        cur = db.cursor()
        cur.execute("SELECT * FROM Users WHERE name='Pedro'")

        for row in cur.fetchall():
            print row
            self.name = row[0]
            self.email = row[1]
            self.balance = row[2]

        # Not enough balance
        if (self.balance < 1.30):
            cur.close()
            db.close()
            return

        self.msg_back = "name: " + self.name + " email: " + self.email + "balance: " + str(self.balance)
        self.request.sendall(self.msg_back)

        self.data = self.request.recv().strip()
        print "{} confirmation:".format(self.client_address[0])
        print self.data

        if (self.data == "OK"):

            self.balance -= 1.30

            cur.execute("UPDATE Users SET balance=%s WHERE name=%s",(self.balance,self.name))
            cur.close()
            db.commit()
            db.close()
        else:
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