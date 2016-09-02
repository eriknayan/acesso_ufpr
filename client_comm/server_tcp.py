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
        self.data = self.request.recv(1024).strip()
        print "{} wrote:".format(self.client_address[0])
        print self.data

        # Data received was not a float
        num = parseFloat(data)
        if (num == -999):
            return

        db = MySQLdb.connect(   host="localhost",
                                user="XXX",
                                passwd="XXX",
                                db="acessoufpr")
        cur = db.cursor()
        cur.execute("SELECT * FROM Users")

        for row in cur.fetchall():
            print row
            self.db_result = row

        cursor.close()
        db.close()

        # just send back the same data, but upper-cased
        self.request.sendall(self.db_result)

if __name__ == "__main__":
    HOST, PORT = "192.168.25.77", 6066

    # Create the server, binding to localhost on port 6066
    server = SocketServer.TCPServer((HOST, PORT), MyTCPHandler)

    # Activate the server; this will keep running until you
    # interrupt the program with Ctrl-C
    server.serve_forever()