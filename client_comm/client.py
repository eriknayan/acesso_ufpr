import SocketServer
import MySQLdb

PRICE = 1.30
HOST_DB = "acessoufpr.ddns.net"
USER_DB = "XXX"
PASSWD_DB = "XXX"
NAME_DB = "acessoufpr"

if __name__ == "__main__":

    while True:
        try:
            num = raw_input('Type your carteirinha number: ')
        except SyntaxError: # Case input was left blank
            continue

        try:
            str_num = long(num) # Tries and converts input to long
        except ValueError: # User probably typed a string, reiterate
            print 'Invalid query format'
            continue

        db = MySQLdb.connect(   host=HOST_DB,
                                user=USER_DB,
                                passwd=PASSWD_DB,
                                db=NAME_DB)
        cur = db.cursor()

        # Query the db
        cur.execute("SELECT * FROM Users WHERE id=%s", (str_num,))

        rows = cur.fetchall()
        # Check if found any match in the query
        if (len(rows) != 0):
            for row in rows:
                print row
                # Extract fields from db
                my_id = row[0]
                name = row[1]
                email = row[2]
                balance = row[3]

            # Check if there is enough balance
            if (balance > PRICE):
                # Transaction successful
                msg = "Hi "+ name + ". Your new balance is : " + str(balance-PRICE)

                balance -= PRICE # Update balance
                cur.execute("UPDATE Users SET balance=%s WHERE name=%s",(balance,name))
                db.commit() # Commit changes to db
                print "Transaction Complete"
            else:
                # User has no balance available
                msg = "NO BALANCE"
                print "No balance on account"
                pass
        else:
            # No such user found on db
            msg = "NO USER"
            print "No user found"
            pass