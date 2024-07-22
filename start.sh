#!/bin/bash

service php8.1-fpm start > /dev/null

service mysql start > /dev/null

mysql -u root <<MY_QUERY
drop user root@localhost;
flush privileges;
create user root@localhost;
GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost';
flush privileges;
MY_QUERY

service mysql restart > /dev/null

mysql -u root < ./flight.sql

service nginx start > /dev/null

# php spark serve
#tail -f /dev/null