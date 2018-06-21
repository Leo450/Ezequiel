#!/usr/bin/env bash

if [[ -f deploy.env.sh ]]; then
    echo "Missing deploy.env.sh file."
    exit 1
fi

source deploy.env.sh

if [[ -z $dbname ]]; then
    read -p "-> Db name\n" dbname
fi
if [[ -z $sql_filename ]]; then
    read -p "-> Sql filename\n" sql_filename
fi
if [[ -z $local_domain ]]; then
    read -p "-> Local domain\n" local_domain
fi
if [[ -z $remote_domain ]]; then
    read -p "-> Remote domain\n" remote_domain
fi



if [[ -f $sql_filename ]]; then
    rm $sql_filename
fi
mysqldump -u root -p $dbname > $sql_filename
sed -i -e "s/$local_domain/$remote_domain/g" $sql_filename



read -p "Commit message ? (Automatic deploy commit message.)\n" commit_message
if [[ -z $commit_message ]]; then
    commit_message="Automatic deploy commit message."
fi
git add *
git commit -m $commit_message
git push



read -p "Do remote pull ? (Yy/Nn)\n" -n 1
if ! [[ $REPLY =~ ^[Yy]$ ]]; then
    exit 0
fi

if [[ -z $remote_user ]]; then
    read -p "-> Remote user\n" remote_user
fi
if [[ -z $remote_host ]]; then
    read -p "-> Remote host\n" remote_host
fi
if [[ -z $remote_project_dir ]]; then
    read -p "-> Remote project dir\n" remote_project_dir
fi

read -p "Replace remote db ? (Yy/Nn)\n" -n 1
if [[ $REPLY =~ ^[Yy]$ ]]; then
    ssh -t "$remote_user@$remote_host" cd $remote_project_dir; bash deploy.pull.sh;
else
    ssh -t "$remote_user@$remote_host" cd $remote_project_dir; git pull;
fi
