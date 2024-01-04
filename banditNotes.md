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