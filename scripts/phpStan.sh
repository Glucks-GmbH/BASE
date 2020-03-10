#!/bin/sh
docker run --rm -v $(pwd):/app phpstan/phpstan analyse ./libs/ ./public/controller/  --error-format=checkstyle > ./documentation/phpstan/checkstyle.xml