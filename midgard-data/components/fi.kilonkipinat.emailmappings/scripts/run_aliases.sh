#!/bin/bash
ALIASES_LIST="aliases"
ALIASES_DB="aliases.db"
ALIASES_OLD="aliases_old"
ALIASES_AUTOMATIC="aliases_automatic"
ALIASES_MAPPINGS="aliases_mappings"
 
which stat > /dev/null
 
# make sure stat command is installed
if [ $? -eq 1 ]
then
	echo "stat command not found!"
	exit 1
fi
 
# make sure file exists
if [ ! -e $ALIASES_LIST ]
then
	echo "$ALIASES_LIST not a file"
	exit 2
fi

# make sure file exists
if [ ! -e $ALIASES_DB ]
then
	echo "$ALIASES_DB not a file"
	exit 3
fi

# make sure file exists
if [ ! -e $ALIASES_AUTOMATIC ]
then
	echo "$ALIASES_AUTOMATIC not a file"
	exit 4
fi

# make sure file exists
if [ ! -e $ALIASES_MAPPINGS ]
then
	echo "$ALIASES_MAPPINGS not a file"
	exit 4
fi

# make sure file exists
if [ ! -e $ALIASES_OLD ]
then
    $(touch $ALIASES_OLD)
fi

LAST_MOD_ALIASES_LIST="$(stat -c %Y $ALIASES_LIST)"
LAST_MOD_ALIASES_DB="$(stat -c %Y $ALIASES_DB)"
LAST_MOD_ALIASES_AUTOMATIC="$(stat -c %Y $ALIASES_AUTOMATIC)"
LAST_MOD_ALIASES_MAPPINGS="$(stat -c %Y $ALIASES_MAPPINGS)"

if [ $LAST_MOD_ALIASES_AUTOMATIC -gt $LAST_MOD_ALIASES_LIST ]
then
    cat $ALIASES_AUTOMATIC $ALIASES_MAPPINGS > $ALIASES_LIST
fi

if [ $LAST_MOD_ALIASES_MAPPINGS -gt $LAST_MOD_ALIASES_LIST ]
then
    cat $ALIASES_AUTOMATIC $ALIASES_MAPPINGS > $ALIASES_LIST
fi

if [ $LAST_MOD_ALIASES_LIST -gt $LAST_MOD_ALIASES_DB ]
then

    if [ '' != "$(diff -q $ALIASES_LIST $ALIASES_OLD)" ]
    then
        newaliases
        cp $ALIASES_LIST $ALIASES_OLD
    fi
fi