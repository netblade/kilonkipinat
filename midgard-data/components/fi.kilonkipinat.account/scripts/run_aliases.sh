#!/bin/bash
FILE1="aliases"
FILE2="aliases.db"
 
which stat > /dev/null
 
# make sure stat command is installed
if [ $? -eq 1 ]
then
	echo "stat command not found!"
	exit 1
fi
 
# make sure file exists
if [ ! -e $FILE1 ]
then
	echo "$FILE1 not a file"
	exit 2
fi

# make sure file exists
if [ ! -e $FILE2 ]
then
	echo "$FILE2 not a file"
	exit 2
fi

LAST_MOD_FILE1="$(stat -c %Y $FILE1)"
LAST_MOD_FILE2="$(stat -c %Y $FILE2)"

if [ $LAST_MOD_FILE1 -gt $LAST_MOD_FILE2 ]
then
    newaliases
fi