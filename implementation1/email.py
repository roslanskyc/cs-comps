#!/usr/bin/python3
# print('Content-type: text/html')

import random
import psycopg2

def connect():
    """Connect to the PostgreSQL database server"""
    try:
        # connecting to the PostgreSQL server
        conn = psycopg2.connect(
            host="localhost", database="auth", user="postgres", password="postgres"
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
            OTP = OTPstr
        # verifies if OTP has already been used
        result = cur.execute("SELECT * FROM otp WHERE code = $1", (OTP))
        rows = len(cur.fetchall(result))
        if rows == 0:
            unique = True
    return int(OTP)

if __name__== "__main__":
    # form = cgi.FieldStorage()
    # email = form.getvalue("email")

    # conn = connect()
    # cur = conn.cursor()

    # OTP = generate_6_digit_OTP(cur)

    # cur.execute("INSERT INTO otp (code, account) VALUES ($1, $2)", (OTP, email))
    # if cur:
    #     cur.close()
    # if conn:
    #     conn.close()
    # print(OTP)
    print("hi")