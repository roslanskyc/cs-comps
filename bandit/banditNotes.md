# OTW Bandit

## bandit0
Logged in, opened the readme to get the password for bandit1. Good start!

## bandit1
Oh no! The command ```cat -``` just reads in the standard input. The simplest workaround is probably to use a more complete filename. In this case, ```cat ./-``` worked just fine to get the password and move on.

## bandit2
Arguably worse file naming here... this time the file is named *spaces in this filename*, which will be interpreted as separate arguments if left as is. There are two good workarounds for this one:
- Wrap the whole thing in quotation marks: ```cat "spaces in this filename"```
- Escape the space characters: ```cat spaces\ in\ this\ filename```

## bandit3
This is our first encounter with a directory! ```ls``` shows a directory called *inhere* - my unix shell shows the text in blue to signify it as a directory instead of a file. Here we can use the change directory command, as ```cd inhere``` brings us inside. Another ```ls``` comes up empty, but ```ls -a``` did the trick, showing the file *.hidden*, along with . and .. to represent the current and parent directories. Sure enough, opening *.hidden* gives us the next flag.

## bandit4
Here's an interesting one - there's an *inhere* directory to move to, like last time, but now there are ten files inside, ranging from *-file00* to *-file09*. According to the website, the flag is stored in the only human-readable file. And sure, we could try opening each file in turn until we get one that looks like a flag, but how can we make it easier on ourselves?

The command ```file [FILENAME]``` gives us file types. So maybe ```file *```? Turns out this gives an error, that we can't open "ile00" as it does not exist. As before, the dashed start gives us problems, so ```file ./*``` should (and does) work. It lists out all the files and their types, showing that *-file07* is ASCII text and everything else is data. Sure enough, opening *-file07* gives us the flag.

## bandit5
The ```find``` command comes to mind as a good candidate for this. I tried ```find . -size 1033c```, which looked throughout everything in *inhere* for a file that is 1033 bytes in size. Turns out, this was all I needed to get the right file, in *maybehere07*. As an extra check, I used ```ls -l``` to make sure that the right file was not executable.

## bandit6
Again, ```find``` will save us here. There's nothing in the home directory, so we will need to look further, starting from root. ```find / -user bandit7 -group bandit6 -size 33c``` searches from the root directory for files that match the given properties. Unfortunately, it also tries to see into a tons of files and gets permission denied errors for almost all of them. We can ignore the error messages by adding ```2>/dev/null```, so ```find / -user bandit7 -group bandit6 -size 33c 2>/dev/null``` gives the filepath to the flag we want.

## bandit7
*data.txt* is right there, and the flag is next to the word "millionth". I guess you could open the file in notepad and CTRL+F to find it, but we use ```grep``` instead. ```grep "millionth" data.txt``` prints out the line with "millionth" on it, which includes the flag.

## bandit8
Here, we need to find the only unique line in *data.txt*. I was tempted to use ```uniq``` here, but it only removes duplicate lines that are next to each other - then we just need to sort first. ```sort data.txt | uniq -u``` does the trick here.

## bandit9
I got this, but I'm not proud of it...
I just searched for several word characters in a row with ```grep "\w\w\w\w\w\w\w" data.txt```. I first tried to match "====", then I used the regex ```\w{5,}``` to be a little more efficient, but neither worked. This gave me a whole mess but highlighted the human-readable chunks, including one that followed a bunch of equals signs and happened to look like a flag.

## bandit10
```base64``` is a pretty handy command here, as ```base64 -d data.txt``` decodes the file and gets the flag.

## bandit11
```tr``` is great too - ```tr '[A-Z]' '[N-ZA-M]'``` shifts each character by 13 position. Unfortunately, it's case sensitive, so we need to chain - ```cat data.txt | tr '[A-Z]' '[N-ZA-M]' | tr '[a-z]' '[n-za-m]'``` decodes the file for us.

