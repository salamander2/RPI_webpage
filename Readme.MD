## This project is to demonstrate how Raspberry Pis can transmit/read information to/from the internet (a webpage).

The intent is to use the internet to control the RPI and also for the RPI to send data to the webpage.  This is really just a proof of concept so far: 
* commands can be typed in on the webpage. This will turn LEDs on/off on the raspberry pi and can also be used for shutdown or reboot.
* switches can be turned on or off on the Raspberry Pi. This sends data to the webpage which then shows graphically the status of the switches on the Raspberry pi.

If the Raspberry Pi were connected to sensors or a robot and a camera, then it would be useful to be able to control things remotely, or sense the temperature at home ...

There is no security to this yet. The webpage would need a password (the simplest is using .htaccess) or anyone could control the Raspberry Pi.

--------
## Layout of this project
![Layout of this project](https://raw.githubusercontent.com/salamander2/RPI_webpage/master/images/PI_1.JPG)

## LEDs turned on by webpage
![LEDs turned on by webpage](https://raw.githubusercontent.com/salamander2/RPI_webpage/master/images/PI_2_LEDS.JPG)

## Switches
![Switches](https://raw.githubusercontent.com/salamander2/RPI_webpage/master/images/PI_3_switches.JPG)

The switches are just wires that connect to either ground or +3.3V. +3.3V is ON.    
All you have to do is move the end of the jumper wire from ground (-) or 0V, to +3.3V.

## Webpage controller
![webpage](https://raw.githubusercontent.com/salamander2/RPI_webpage/master/images/PI_4_webpage.JPG)

The command BR means turn on Blue and Red LEDs. It would still work if you typed BEAR or RUBE or ORBIT. The letters looked for are RGBY or the words SHUTDOWN or RESTART.    
The switches shown as ON are the two jumpers on the Raspberry Pi breadboard that have been connected to the 3.3V rail.
