#!/bin/bash
var=$(date '+%Y-%m-%d')
mysqldump --opt --host=localhost --user=login5261 --password=hvmFxYNbklFlglc dblogin5261 > /var/www/html/Hopital_BD/autre/backup_$var.sql;