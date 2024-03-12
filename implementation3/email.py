#!/usr/bin/python3
# print('Content-type: text/html')

import random
import psycopg2
import sys
import urllib.parse

def connect():
    """Connect to the PostgreSQL database server"""
    try:
        # connecting to the PostgreSQL server
        conn = psycopg2.connect(
            
        )
        return conn
    except (psycopg2.DatabaseError, Exception) as error:
        # print(error)
        return

def generate_6_digit_OTP(cur):
    unique = False
    OTP = ""
    while unique != True:
        OTP = ""
        for i in range(1, 7):
            OTPint = random.randrange(10)
            OTPstr = str(OTPint)
            OTP += OTPstr
        # verifies if OTP has already been used
        result = cur.execute("SELECT * FROM otp WHERE code = %s", [OTP])
        rows = len(cur.fetchall())
        if rows == 0:
            unique = True
    return int(OTP)

if __name__== "__main__":
    POST={}
    args=str(sys.argv[1]).split('&')

    for arg in args:
        t=arg.split('=')
        if len(t)>1 and t[0] not in POST: 
            POST[t[0]] = t[1]

    email = POST["email"]

    email = urllib.parse.unquote(email)

    conn = connect()
    cur = conn.cursor()

    #make sure there's an account for this email
    validate_acct = cur.execute("SELECT * FROM credentials WHERE email = %s", [email])
    acct_rows = cur.fetchall()
    acct_rows_num = len(acct_rows)

    if acct_rows_num > 0:
        OTP = generate_6_digit_OTP(cur)

        #if there are already an OTPs for this account, delete them
        cur.execute("DELETE FROM otp WHERE account=%s", [email])

        #insert the OTP and email into the database
        cur.execute("INSERT INTO otp (code, account) VALUES (%s, %s)", [OTP, email])
    conn.commit()
    if cur:
        cur.close()
    if conn:
        conn.close()
    print(email,end='')
