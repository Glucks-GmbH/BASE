############################################################################################
# Script has to be run in project root folder                                              #
# ./vendor/gluecks-gmbh/base/scripts/baseCreate.sh                                         #
############################################################################################

#!/bin/

# create folder

mkdir config
mkdir public
mkdir public/controller
mkdir public/views/
mkdir public/views/templates
mkdir public/views/templates/Website
mkdir public/views/configs
mkdir public/views/configs/de-de/
mkdir public/views/configs/de-de/Website

# copy files

cp ./vendor/gluecks-gmbh/base/scripts/baseCreate/Dockerfile ./Dockerfile
cp ./vendor/gluecks-gmbh/base/scripts/baseCreate/Docker-compose.yml ./Docker-compose.yml

cp ./vendor/gluecks-gmbh/base/scripts/baseCreate/config/base.xml ./config/base.xml
cp ./vendor/gluecks-gmbh/base/scripts/baseCreate/config/routes.xml ./config/routes.xml

cp ./vendor/gluecks-gmbh/base/scripts/baseCreate/public/.htaccess ./public/.htaccess
cp ./vendor/gluecks-gmbh/base/scripts/baseCreate/public/index.php ./public/index.php

cp ./vendor/gluecks-gmbh/base/scripts/baseCreate/public/controller/Website.php ./public/controller/Website.php

cp ./vendor/gluecks-gmbh/base/scripts/baseCreate/public/views/configs/de-de/Website/homepage.conf ./public/views/configs/de-de/Website/homepage.conf
cp ./vendor/gluecks-gmbh/base/scripts/baseCreate/public/views/templates/Website/homepage.tpl ./public/views/templates/Website/homepage.tpl