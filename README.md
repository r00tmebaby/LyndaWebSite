# LyndaWebSite
Lynda Web is built to support Lynda Downloader and all videos to be displayed properly in a private library 

This small web was especially created to support my <a href="https://github.com/r00tmebaby/Lynda_Downloader">Lynda Downloader python script</a> and all downloaded videos to be properly displayed on it.

<image src="https://i.gyazo.com/9c01bc69a8d90dcba2b0d6064b32230f.png"/>

<image src="https://i.ibb.co/d2x95Y9/1.png"/>

# Functionalities
Built with bootstrap framework, Ajax and PHP back-end the website is very responsive and fast. It will display your favourite and freshly downloaded courses for a private offline study with the excercise files and the their information.
All the links are very well secured with key and 256sha encyption so there is no posibility to brake the code easily. 

In addition to this instead of using a plane video url I have used a php to generate the video file, so the actual video destination to remain unknown.
A quick tip if you use Apache and want to secure all videos from direct access is to include <b>.htaccess file with "Deny from All"</b> text in the <b>courses folder</b>. This will prevent any direct access but will not affect the video files.
So if you do not have any folders you wont see any items on the web menu, keep that in mind.

# Installation
1. Open functions.php and at the very bottom of the file change your mysql login credentials => database, username, password and host
2. Create some folders in course directory and start downloading your videos. All downloaded courses will pop in the menu automatically.

