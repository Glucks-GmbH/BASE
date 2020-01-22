[![Codacy Badge](https://api.codacy.com/project/badge/Grade/a14f71f0f0594c8a9713e707db77648b)](https://www.codacy.com/gh/gluecks-gmbh/base?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=gluecks-gmbh/base&amp;utm_campaign=Badge_Grade)

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
