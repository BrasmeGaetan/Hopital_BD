#!/bin/bash
user=$USER
pwd=$PASSWORD
db=$DB
var=$(date '+%m-%d-%Y_%H:%M:%S')
mysqldump --opt --host=localhost --user=$user --password=$pwd dblogin5468 > /var/www/html/Hopital_BD/autre/.backup/backup_$var.sql;
