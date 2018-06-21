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

echo "1"
mysql -u root -p -e "DROP DATABASE $dbname;"
echo "2"
mysql -u root -p -e "CREATE DATABASE $dbname;"
echo "3"
mysql -u root -p $dbname < $sql_filename
