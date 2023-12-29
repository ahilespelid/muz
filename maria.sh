#!/bin/bash

clear;

status=$(systemctl status mariadb.service | grep inactive)

if [[ -n "$status" ]]; then
    systemctl start mariadb.service;
fi

echo 0;
