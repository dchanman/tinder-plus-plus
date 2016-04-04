#!/bin/bash

OUTPUTFILE='sqlplus.sql'

# Some defines
echo "set define off" > $OUTPUTFILE

cat schema.sql >> $OUTPUTFILE
cat sample.sql >> $OUTPUTFILE
#sed 's/&/\\&/g' sample.sql >> $OUTPUTFILE
chmod 755 $OUTPUTFILE
