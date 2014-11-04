# FortyTwo Theme for Developers

Forty Two is the smartest Genesis Child theme possible with full integration of Twitter Bootstrap, Grunt, Bower and a bunch of custom widgets to boot.

## Install

Like you would with any other theme. Obviously this theme requires the presence of at least the 2.0.0 version of Genesis.

## Developing off of FortyTwo

FortyTwo is built with the developer in mind. As much of the process of building / compiling a theme has been automated via Grunt. The goal is to use the file structure FortyTwo provides and build on top of that. By either amending current functions or adding functions to it.

### CSS

FortyTwo is built on top off of Genesis and Twitter Bootstrap. This marriage has mostly been solved by using bestoke LESS files that generate Genesis favoured CSS. Changing the CSS requires you to alter the LESS files. By using the ```grunt watch``` command every change saved in the LESS files will automagically regenerate the stylesheet.

## Getting Started

* Copy the FortyTwo folder to your development site (you're free to change the name to something more suiting)
* Install Grunt with the following steps:
	* Navigate to the theme folder first
	* ```npm install -g grunt-cli```
	* ```npm install```
	* Change the project specific parts in package.json to make this project unique. This will also feed back into the style.css header.
	* ```grunt watch``` will activate the autocompiling task configured in Grunt.js.
*

## Dependencies

* [Font Awesome](https://github.com/FortAwesome/Font-Awesome/releases)
* [Bootstrap](https://github.com/twbs/bootstrap/releases)
* [Respond.js](https://github.com/scottjehl/Respond/releases)
* [Holder](https://github.com/imsky/holder/releases) (not currently used)
* [Grunt](http://gruntjs.com/)

## Contributors

* Ryan Holder @ryanholder
* Remkus de Vries @defries
* David Laing @mrdavidlaing
* Daan Kortenbach @daankortenbach
* Gary Jones @garyjones

