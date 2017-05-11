<?php

/* 
 * Copyright (C) 2017 Pierre F
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

session_start();
$new_text=  filter_input(INPUT_POST, "new_text",FILTER_SANITIZE_STRIPPED);
$id=  filter_input(INPUT_POST, "id",FILTER_SANITIZE_STRIPPED);
$lang=$_SESSION['lang_currentToUpdate']; 
if(file_exists("lang_files/".$lang.".json")){
	$lang_content=json_decode(file_get_contents("lang_files/".$lang.".json"),true);
}else{
	$lang_content=array();
}
$lang_content[$id]=$new_text;
file_put_contents("lang_files/".$lang.".json", json_encode($lang_content,128));