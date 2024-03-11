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
        print(result)
        rows = len(cur.fetchall())
        if rows == 0:
            unique = True
    return int(OTP)

if __name__== "__main__":
    POST={}
    args=sys.argv[1].split('&')

    for arg in args:
        t=arg.split('=')
        if len(t)>1 and t[0] not in POST: 
            POST[t[0]] = t[1]
            k, v=arg.split('='); POST[k]=v

    email = POST.get('email')

    email = urllib.parse.unquote(email)

    print(email)

    conn = connect()
    cur = conn.cursor()

    OTP = generate_6_digit_OTP(cur)

    cur.execute("DELETE FROM otp WHERE account=%s", [email])

    cur.execute("INSERT INTO otp (code, account) VALUES (%s, %s)", [OTP, email])
    conn.commit()
    if cur:
        cur.close()
    if conn:
        conn.close()
    print(OTP)
    print("hi")
