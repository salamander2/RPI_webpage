## This project is to demonstrate how Raspberry Pis can transmit/read information to/from the internet (a webpage).

The intent is to use the internet to control the RPI and also for the RPI to send data to the webpage.  This is really just a proof of concept so far: 
* commands can be typed in on the webpage. This will turn LEDs on/off on the raspberry pi and can also be used for shutdown or reboot.
* switches can be turned on or off on the Raspberry Pi. This sends data to the webpage which then shows graphically the status of the switches on the Raspberry pi.

If the Raspberry Pi were connected to sensors or a robot and a camera, then it would be useful to be able to control things remotely, or sense the temperature at home ...

There is no security to this yet. The webpage would need a password (the simplest is using .htaccess) or anyone could control the Raspberry Pi.
