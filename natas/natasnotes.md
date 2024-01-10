# OTW Natas

## natas0
Looking at the raw html, there is a comment in "content" that contains the password

## natas1
The same thing worked here - oops, I was supposed to right click on natas0 to view the source, instead of Ctrl+Shift+i.

## natas2
There wasn't much in this page - but there was an image in /files/pixel.png. I went to it - again, there wasn't much here, the image was a pixel - but from there I went to /files, where I found a file called users.txt, containing the password for natas3 (a terrible way to store passwords!)

## natas3
I had to get a little help for this one - apparently ```robots.txt``` is a commonly used file that disallows certain directories from search engines. I went to this file, where I found the directory ```/s3cr3t``` - sure enough, this linked to a file that stored the next password.

## natas4
Got lucky here! When first logging in, I get the hint that I need to be coming from natas5 - the problem being that I can't get into natas5 in the first place. I tried using the burp suite proxy tool for this - after forwarding everything up to refreshing the page, I looked at the proxy, and saw the "Referer" header. It was natas4, and I figured it was worth a shot, so I changed it to natas5. This worked!

## natas5
Similar story for this one! When refreshing the page, I spotted a header in the proxy that was ```loggedin: 0```. I just set it to 1 and passed it along, and it got me the next password.

## natas6
On this one, I went to see the sourcecode - it was a pretty basic form that compared the input to ...something. Putting in ```/includes/secret.inc``` got me something that was labeled 'secret', and sure enough, submitting that to the form got the password.

## natas7
Clicking on the home button led me to ```index.php?page=home```, and the source code had a hint to the password, so I switched the URL to ```index.php?page=/etc/natas_webpass/natas8```. This actually gave me a lot of grief because I forgot the first slash :(

## natas8
The sourcecode for this one gave some hints in PHP - when the site gets an input, it encodes it into base64, then reverses the string, and calls ```bin2hex()``` on it (which just converts a string into hexadecimal). The resulting string is compared against the encoded secret, which is stored in plaintext. After wrangling with a PHP installation for a bit, I was able to run a script that takes the encoded secret and decodes it - this can be seen in ```natasScripts/natas8.php```. The output for this can be submitted to get the password.

## natas9
We start with an input form to find words in a dictionary - a look at the source code shows that it takes in user input and sticks it in an executed command. This is a prime situation for a command-injection attack! 

After a little digging into formats, I came up with ```none; ls -la #``` as an input, just to get a bearing on where I am. After peeking through the directory I'm in, it's parent, and /etc, I found the passwords and used ```none; cd /etc/natas_webpass; cat natas10; #``` to get the next one.

## natas10 
After some time trying to figure out how to do a command injection by executing multiple commands without ;, &, or |, I got a hint to think of other ways to modify ```grep```. Sure enough, ```. /etc/natas_webpass/natas11 #``` worked to search the natas11 file for any character.