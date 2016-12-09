# BeerList

A PHP and JScript Beer list web-app using [JQuery Mobile](http://www.jquerymobile.com) 

## Beer Site, files - directories


##apple-touch-icon.png  	- icon used for making a shortcut on iDevice
----------------------
NONE
----------------------

##index.php 		- main php file, checks for iDevice (currently iPhone & iPad) then calls index-iphone.php or does non iDevice site (currently broken)
----------------------
NONE
----------------------

##index-iphone.php  	- iUI iPhone & iPad Beer main php file
----------------------
NONE
----------------------
	Panels: Beer  - home
		Update - update
		Lists - list
		About - about

		Last 100 Beers - Last100
		All Beers - Beers
		Cellar - cellar
		Deep Cellar - deepcellar

		Theme Switcher - themes

	WANT to do   
		Delete - delete
		Options - options

		Add Location - AddLocal ?????? NOT SURE WE NEED THIS 


	Dlgs:	Addit - addit


##addit.php  		- called by "Addit"-Form in index-iphone.php to add a Beer to database and possibly add a serving at the same time, or add as a cellared beer
----------------------
$beername = $_POST['beer'];
$url = $_POST['url'];
$date = $_POST['date'];
$char = $_POST['char'];
$thoughts = $_POST['thoughts'];
$serving =  $_POST['serving'];
$location =  $_POST['location'];
$list =  $_POST['list'];
$cellar = $_POST['cellar'];
$deepcellar = $_POST['deepcellar'];
----------------------

##addserv.php		- Adds a beer serving to a Beer in the database, called from view.php either as a simple add serving via <AddServ> button or as a add cellar serving by clicking <cellar text>.
----------------------
$beerid = $_GET['beer'];
$cellar = $_GET['cellar'];
----------------------

##common.php  		- some common functions for colors and icons may be included in any files (index-iphone, view, etc)
----------------------
NONE
----------------------

##edit.php  		- called from view.php in order to edit Beer information and if viewing Serving, Beer Servings
----------------------
$beerid = $_GET['beer'];
$servingid = $_GET['serving'];
----------------------

##edititems.php  		- called from index-iphone.php in FORM update and allows adding and removing items in the BeerList, Location, and ServingType DB Tables
----------------------
$table = $_GET['table'];
----------------------

##gethint.php  		- code called from showhint.js and does the actual DB calls into the Beer Table in DB and then formats lines of each beer (including links to view.php, number cellared and photo_id))
----------------------
$q=$_GET["q"];
----------------------

##getphoto.php  		- actually gets photo data out of table in DB, then returns this to showphoto.php
----------------------
$id    = $_GET['id'];
----------------------

##lists.php  		- queries DB and creates a Panel that lists all Beer Lists with number of beers on each.
----------------------
NONE
----------------------

##manifest.php  		- manifest stuff, currently no offline stuff works, always reloads everything when web-app re-started
----------------------
NONE
----------------------

##modify.php  		- does actual modification of either Beer or Serving information into DB tables
----------------------
----------------------

##showhint.js  		- javascript file that pulls hints for search of Beers from Beer Table in DB, on first Panel of index-iphone.php
----------------------
----------------------

##showphoto.php  		- Pulls photos from beerimages table in DB and displays on it's own panel
----------------------
$id    = $_GET['id'];
----------------------

##view.php  		- Panel to display beer information and servings, will allow editing Beer-table, View serving information - allow editing of Serving-table
----------------------
$beerid = $_GET['beer'];
$servingid = $_GET['serving'];
----------------------


Used for uploading photos int DB for Beers and attaching to Beers-Table, NOT iDevice ready.

##upload.php  		- uses beers.php and showhint.js
----------------------
----------------------

##beers.php  		- populates the beers into textbox in Upload.php for completion.
----------------------
$_GET['term']
----------------------


Directories::

##css			- only style.css, used in Upload.php
----------------------
----------------------

##database		- files for database activities, maybe they should be protected????
----------------------
----------------------

##images			- bunch of graphic files for the web-app
----------------------
----------------------
