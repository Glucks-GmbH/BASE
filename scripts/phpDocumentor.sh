#!/bin/sh
rm -Rf ../documentation/phpdocumentor
docker run --rm -v $(pwd):/data phpdoc/phpdoc run -d ./libs/ -d ./web/Controller/ -t ./documentation/phpdocumentor/
