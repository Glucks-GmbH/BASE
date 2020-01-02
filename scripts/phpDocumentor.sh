#!/bin/sh
rm -Rf ../documentation/phpdocumentor
../vendor/phpdocumentor/phpdocumentor/bin/phpdoc -p -d ../libs -t ../documentation/phpdocumentor