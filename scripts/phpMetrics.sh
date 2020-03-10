#!/bin/sh
rm -Rf ../documentation/phpmetrics
docker run --rm -w $(pwd) -v $(pwd):$(pwd) elnebuloso/php-phpmetrics  phpmetrics --report-html="./documentation/phpMetrics" ./libs/,./public/controller/
