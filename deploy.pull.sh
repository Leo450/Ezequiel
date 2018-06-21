#!/usr/bin/env bash

if ! [[ -f deploy.env.sh ]]; then
    echo "Missing deploy.env.sh file."
    exit 1
fi

source deploy.env.sh

git pull

if ! [[ -f $sql_filename ]]; then
    echo "No sql file after pull."
    exit 1
fi

read -p "-> Mysql password" mysql_password

mysql -u root -p$mysql_password -e "DROP DATABASE $dbname;"
mysql -u root -p$mysql_password -e "CREATE DATABASE $dbname;"
mysql -u root -p$mysql_password $dbname < $sql_filename
