#!/usr/bin/env bash

read -p "Db name ?" dbname
sql_filename="$dbname.sql"

if [[ -f $sql_filename ]]; then
    rm $sql_filename
fi
mysqldump -u root -p $dbname > $sql_filename

read -p "Local domain ?" local
read -p "Remote domain ?" remote
sed -i -e "s/$local/$remote/g" $sql_filename

git add *