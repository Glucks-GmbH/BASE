[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gluecks-gmbh/base/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gluecks-gmbh/base/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/gluecks-gmbh/base/badges/build.png?b=master)](https://scrutinizer-ci.com/g/gluecks-gmbh/base/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/gluecks-gmbh/base/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

# BASE
Base is Framework and MVC

# Installation

## composer

## Create basic MVC installion

 Run the script "./vendor/gluecks-gmbh/base/scripts/baseCreate.sh" inside the project root folder.    

## MVC / Smarty 

Every Controller needs a
- PHP Controller class

- Smarty Template file

- Smarty Config file

### MVC / Smarty / Link-Plugin

You can use the link-plugin to generate uris out of a controller related to the routes.xml

The Syntax is:

 {Link->use controller="/About::overveiw"}

If the uri contains regular expression it is necessary to add the values of the regualr expression.
To do this you have to add a var named "values" to the plugin call. 
The variable have to be an numeric array with the syntax: first element belongs to the first regualar expression, 
the second element to the second regular expression and so on.
  
 {Link->use controller="/Stores::details" values=["london"]}
