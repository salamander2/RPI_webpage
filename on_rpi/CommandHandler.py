#!/usr/bin/env python

#----------------- IMPORTS -----------------
import RPi.GPIO as GPIO
#import time, thread, subprocess
from subprocess import *
from time import sleep, strftime
from datetime import datetime
#----------------- end imports -----------------

#----------------- SETUP -----------------
L1=25	#Yellow
L2=12	#Green
L3=16	#Blue
L4=21	#Red

SW1=22
SW2=10
SW3=4
SW4=17


GPIO.setmode(GPIO.BCM)
GPIO.setup(L1, GPIO.OUT)
GPIO.setup(L2, GPIO.OUT)
GPIO.setup(L3, GPIO.OUT)
GPIO.setup(L4, GPIO.OUT)
#all switches are pull down. connect to +5V to turn on.
GPIO.setup(SW1, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
GPIO.setup(SW2, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
GPIO.setup(SW3, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
GPIO.setup(SW4, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)

#GPIO.add_event_detect(SW1, GPIO.RISING, callback=changeMode, bouncetime=300)

#... global variables ...
IP="http://quarkphysics.ca/RPI/"
DATAURL=IP+"cmd.txt"
UPDATEURL=IP+"updateData.php"
DELAY=10	#in seconds
#------------------- end setup ----------------

#------------------ FUNCTIONS ------------------

# run a Linux command on the command line and get the output.
def runCmd(cmd):
    p = Popen(cmd, shell=True, stdout=PIPE)
    output = p.communicate()[0]
    return output
# subprocess.call('sudo shutdown -h now', shell=True)
# time = datetime.now().strftime('%b %d %H:%M:%S')

# turn all LEDs ON or OFF depending whether the boolean is true or false.
def allOnOff(b):
    if (b) :
        GPIO.output(L1,GPIO.HIGH)
        GPIO.output(L2,GPIO.HIGH)
        GPIO.output(L3,GPIO.HIGH)
        GPIO.output(L4,GPIO.HIGH)
    else:
        GPIO.output(L1,GPIO.LOW)
        GPIO.output(L2,GPIO.LOW)
        GPIO.output(L3,GPIO.LOW)
        GPIO.output(L4,GPIO.LOW)

def getData():
    FETCHCMD="wget -qO- --no-cache "+DATAURL
    result= runCmd(FETCHCMD).rstrip('\n')
    return result

# this parses the data and sets the LEDs ON or OFF
def parseData(text):
    allOnOff(False)
    if('Y' in text): GPIO.output(L1,GPIO.HIGH)
    if('G' in text): GPIO.output(L2,GPIO.HIGH)
    if('B' in text): GPIO.output(L3,GPIO.HIGH)
    if('R' in text): GPIO.output(L4,GPIO.HIGH)
    
def checkSwitches():
    n = 0
    if (GPIO.input(SW1) == 1): n+= 1
    if (GPIO.input(SW2) == 1): n+= 2
    if (GPIO.input(SW3) == 1): n+= 4
    if (GPIO.input(SW4) == 1): n+= 8

	#use SW1 to run the program faster - more responsive to checking webpage
    if (GPIO.input(SW1) == 1): DELAY=2
    else: DELAY=10

    return n

def sendData(data):
    #instead of sending the raw number, we're going to convert it to RGBY
    str = ""
    if (testBit(data,0)) : str = str + 'Y'
    if (testBit(data,1)) : str = str + 'G'
    if (testBit(data,2)) : str = str + 'B'
    if (testBit(data,3)) : str = str + 'R'
    #print str
    cmd = "wget -qO- " + UPDATEURL + "?DATA=" + str
    runCmd(cmd)
    return str

#returns True or False if that bit is set in a number x.
def testBit(x, bit):
    n = x & 1 << bit
    return(n != 0)


#------------------ end functions ------------------

#------------------ MAIN PROGRAM ---------------
def main():
    allOnOff(True)
    while 1:
        data=getData();

		# this part could be improved. Maybe some list of commands and what they do.
        # Python is good at lists
        if ("SHUTDOWN" in data): 
            cmd="sudo shutdown -h now"
            runCmd(cmd)
        if ("RESTART" in data): 
            cmd="sudo shutdown -h now"
            runCmd(cmd)

        parseData(data)
        n = checkSwitches()
        sendData(n)

        sleep(DELAY)

try:
    main()
except KeyboardInterrupt:   #^C to exit
    allOnOff(False)
    GPIO.cleanup()
    print("\b\b  \nBye")	# remove the ^C from the display.
