<?php

abstract class Config {

	const SITENAME = "";
	const SECRET = "DGLJDG5";
	const ADDRESS = "http://mysite.local";
	const ADM_NAME = "Давид";
	const ADM_EMAIL = "admin@";
	
	const API_KEY = "DKEL39DL";
	
	const DB_HOST = "localhost";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_NAME = "coach";
	const DB_PREFIX = "";
	const DB_SYM_QUERY = "?";
	const DB_MAIN_TABLE_NAME = "mycoach_main";
	const DB_MAIN_TABLE_STRUCTURE = array( "class", "predicate", "value" );
	
	const DIR_IMG = "/images/";
	const DIR_IMG_ARTICLES = "/images/articles/";
	const DIR_AVATAR = "/images/avatars/";
	const DIR_EMAILS = "";
	
	const LAYOUT = "main";
	const FILE_MESSAGES = "/home/mysite.local/www/txt/messages.ini";
	
	const FORMAT_DATE = "%d.%m.%Y %H:%M:%S";
	
	const COUNT_ARTICLES_ON_PAGE = 3;
	const COUNT_SHOW_PAGES = 10;
	
	const MIN_SEARCH_LEN = 3;
	const LEN_SEARCH_RES = 255;
	
	const SEF_SUFFIX = ".html";
	
	const DEFAULT_AVATAR = "default.png";
	const MAX_SIZE_AVATAR = 51200;
}

?>
