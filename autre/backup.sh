#!/bin/bash
var=$(date '+%-%m-%d')
mysqldump --opt --host=localhost --user=login5468 --password=bxNRsHuRkepahth dblogin > /var/www/html/Hopital_BD/autre/backup_$var.sql;