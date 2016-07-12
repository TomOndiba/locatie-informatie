#!/usr/bin/env bash

sudo locale-gen nl_NL
sudo locale-gen nl_NL.utf8

sudo update-locale
sudo apt-get install language-pack-NL

sudo service php7.0-fpm restart

php /home/vagrant/locatie-informatie.nl/app/console doctrine:schema:update
#php /home/vagrant/dagvandeweek.nl/app/console fos:user:create admin admin@stefanius.nl 1234
