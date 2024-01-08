#!/bin/bash

if systemctl is-active mariadb | grep inactive; then
        date >> /root/mysqlcheck.log; echo "status INACTIVE" | tee -a /root/mysqlcheck.log
        systemctl start mariadb
 
elif systemctl is-active mariadb | grep failed; then
        date >> /root/mysqlcheck.log; echo "status FAILED" | tee -a /root/mysqlcheck.log
        systemctl start mariadb
 
else
        echo "mysqld is running"
        exit 0
 
fi
