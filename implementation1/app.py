#!/usr/lib/cgi-bin/env/bin/python3
from wsgiref.handlers import CGIHandler

import os
import random
import psycopg2

# import sys

from flask import Flask, request
# import subprocess
import signal

print("Content-Type: text/html", end="\r\n\r\n", flush=True)

app = Flask(__name__)


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

def shutdown(self):
    # process = subprocess.Popen()
    # process.send_signal(signal.SIGINT)
    # raise KeyboardInterrupt
    signal.SIGINT


@app.route("/reset", methods=["POST"])
def handle_form():
    print(request.form.get("email"))


if __name__ == "__main__":
    try:
        # app.run() #maybe change to port=8080?
        CGIHandler().run(app)
        conn = connect()
        cur = conn.cursor()

        OTP = generate_6_digit_OTP(cur)
        print(OTP)

        # email = request.form.get("email")
        email = request.form["email"]
        print(type(email))
        print(email)

        # NEED TO CHECK IF EMAIL IS ALREADY IN DATABASE, IF IT IS DELETE IT

        cur.execute("INSERT INTO otp (code, account) VALUES (%s, %s)", [OTP, email])
        conn.commit()
        if cur:
            cur.close()
        if conn:
            conn.close()
        print(OTP)
        shutdown()
    except KeyboardInterrupt as e:
        os._exit(0)
