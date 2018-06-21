#!/usr/bin/env bash

if [[ -f deploy.env.sh ]]; then
    echo "Missing deploy.env.sh file."
    exit 1
fi

source deploy.env.sh

git pull

if ! [[ -f $sql_filename ]]; then
    echo "No sql file after pull."
    exit 1
fi

mysql -u root -p -e "DROP DATABASE $dbname;"
mysql -u root -p -e "CREATE DATABASE $dbname;"
mysql -u root -p $dbname < $sql_filename
