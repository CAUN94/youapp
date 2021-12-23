import time
import sys
from datetime import date, timedelta, datetime
from fintoc import Client
import mysql.connector

def fintoc_account(client,link,account):
    client = Client(client)
    link = client.get_link(link)
    account = link.find(id_=account)
    return account

def write_csv(type,movements,balance):
    file_name = 'youbank_'+type+".csv"
    import csv
    with open(file_name, 'w', newline='') as file:
        writer = csv.writer(file, delimiter=';')
        writer.writerow(["Balance Corriente",balance])
        writer.writerow(["Monto", "Fecha","Titular","Number","Banco","Comentario"])
        for movement in movements:
            amount = movement.amount
            date = movement.transaction_date
            comment = movement.comment
            sender = movement.sender_account
            holder = str(movement).split(" (")[1].split(" @ ")[0]


            if (sender is not None):
                sender_number = sender.number
                if (sender.institution is not None):
                    sender_bank = sender.institution.name
                else:
                    sender_bank = 'None'
            else:
                sender_number = 'None'
                sender_bank = 'None'

            writer.writerow([amount,date,holder,sender_number,sender_bank,comment])

def sql_connector():
    mydb = mysql.connector.connect(
      host="131.72.236.48",
      user="justbett",
      password="1O5i1C4sdh",
      database="justbett_bank"
      # host="localhost",
      # user="root",
      # password="",
      # database="youjustbetter"
    )
    return mydb

def sql_insert(movements,mydb,type_):
    for movement in movements:
        id_ = movement.id_
        amount = movement.amount
        date = movement.transaction_date
        comment = movement.comment
        sender = movement.sender_account
        holder = str(movement).split(" (")[1].split(" @ ")[0]
        now = datetime.now()
        current_time = now.strftime("%H:%M:%S")

        print("Current Time =", current_time,"Titular:", holder)

        if (sender is not None):
            sender_number = sender.number
            if (sender.institution is not None):
                sender_bank = sender.institution.name
            else:
                sender_bank = 'None'
        else:
            sender_number = 'None'
            sender_bank = 'None'

        mycursor = mydb.cursor()
        sql = "INSERT INTO `transfers`  VALUES (null, %s, %s, %s, %s, %s, %s, %s,%s, NOW())";

        val = (id_, amount, date, holder,sender_number,sender_bank,type_,comment)

        mycursor.execute(sql, val)

        mydb.commit()

        sql = "DELETE t1 FROM transfers t1 INNER JOIN transfers t2  WHERE t1.account_id > t2.account_id AND BINARY t1.movemente_id = t2.movemente_id"
        mycursor.execute(sql)

        mydb.commit()


mydb = sql_connector()
today = date.today()
client = "sk_live_MHJx2wuSA2gpzv-wBSxrhpJHZtGnCM_3"
link = "link_V2byLzvivAVL0Wnw_token_wys-rVko1A1UNaxvrJFUm3NW"
yesterday = date.today() - timedelta(days=1)
date_since = '2021-02-01'

account_id = "XqNDRKQeTzVKvpnW"
account = fintoc_account(client,link,account_id)
movements = account.get_movements(since=date_since)

# account.update_balance()
balance = account.balance.available
# write_csv('credito',movements,balance)
movements = account.get_movements(since=date_since)
# sql_insert(movements,mydb,"credito")

account_id = "b8XkZle9TdZlVQ6z"
account = fintoc_account(client,link,account_id)
# movements = account.get_movements(since=date)
# account.update_balance()
balance = account.balance.available
# write_csv('corriente',movements,balance)
movements = account.get_movements(since=date_since)
# for i in movements:

#     if i.sender_account is not None:
#         print(i.description, end=" ")
#         print(i.sender_account.holder_id, end=" ")
#         print(i.sender_account.holder_name, end=" ")
#         print(i.sender_account.number)
# sys.exit()

# sql_insert(movements,mydb,"corriente")

now = datetime.now()
current_time = now.strftime("%H:%M:%S")
future_time = datetime.now() + timedelta(days=30)

print()
print("-----------------")
print("Last Update =", current_time)
print("-----------------")
print("Next Update =", future_time)
print("-----------------")
