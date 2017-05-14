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

$configuration=array(
    "defautLanguageCode"=>"en",
    "maxLanguageCodeLength"=>4,
    "defaultPath"=>"langManagementSystem/",
    "secretAdminKey"=>"2",
    "psswdForeachLang"=>FALSE //if set to false -> secret key will be psswd for admin, if true --> password will be intval(language code concatened with admin key,36)%1000;
);

if(!isset($path)){
    $path=$configuration['defaultPath'];
}

/**
 * Get the language to display (default is server if nothing have been passed as parameter GET.
 * If no server defined language or incorrect submitted option set en as default language
 */
if(!empty($_GET['lang'])){
    $lang=filter_input(INPUT_GET, 'lang',FILTER_SANITIZE_STRING);
}else{
    $lang=preg_split("/[^A-Za-z]/", filter_input(INPUT_SERVER,'HTTP_ACCEPT_LANGUAGE', FILTER_SANITIZE_STRING))[0];
}
if(empty($lang)||mb_strlen($lang)>$configuration['maxLanguageCodeLength']||!file_exists($path."lang_files/".$lang.".json")){
    $lang=$configuration['defautLanguageCode'];
    $def_lang_content=array();
}else{
    $def_lang_content=json_decode(file_get_contents($path."lang_files/".$configuration['defautLanguageCode'].".json"),true);
}

/**
 * Get the language content to display
 */
$lang_content=json_decode(file_get_contents($path."lang_files/".$lang.".json"),true);


/**
 * recognize if admin is logged
 */
$psswd=filter_input(INPUT_GET, 'admin',FILTER_SANITIZE_NUMBER_INT);
if($configuration['psswdForeachLang']){
    $langPsswd=intval($lang.$configuration['secretAdminKey'],36)%1000;
}else{
    $langPsswd=$configuration['secretAdminKey'];
}
if($psswd==$langPsswd){
    $admin=true;
    /**
     * we save the user language for the form treatment script
     */
    session_start();
    $_SESSION['admin']=true;
    $_SESSION['lang_currentToUpdate']=$lang; 
    $lang_textareaIds=array();
}else{
	session_unset();
    $admin=false;
}

/**
 * Textareas (editable if admin = true)
 */
/**
 * show the text content and edit it if admin
 * @param type $id the id of the textarea (the key to store content in the lan json file)
 */
function lang_textarea($id) {
    global $lang_content;
    global $def_lang_content;
    global $admin;
    global $lang_textareaIds;
	if(isset($lang_content[$id])){
		$text_content=$lang_content[$id];
                $warin_if_undefined="";
	}else if(!isset($def_lang_content[$id])){
		$text_content="";
                $warin_if_undefined="<SUP>undefined</SUP>";
	}else{
		$text_content=$def_lang_content[$id];
                $warin_if_undefined="<SUP>undefined->defaut language</SUP>";
	}
    if(!$admin){
        echo "<span id='$id'>$text_content</span>";
    }else{
        echo "$warin_if_undefined<span id='$id' contenteditable='true' class='adminEditableDiv'>$text_content</span>";
        $lang_textareaIds[]=$id;
    }
}

/**
 * end the file and set listener on contenteditable div
 */
function lang_endFile(){
    global $admin;
    global $lang_textareaIds;
    global $configuration;
    global $path;
    $datas= serialize($lang_textareaIds);
    if($admin){
        echo "<script src='".$path."langManagSyst_Setup.js.php?ids=$datas&path=$path'></script>";
    }
}

/**
 * to create a select field for the language in input (if it exists for each of the language a flag image it will include it in the select
 * @param mixed $langs array containig the language to ad: key language code and value text to display
 */
function create_SelectLanguage($langs) {
    global $lang;
    global $path;
    if(file_exists($path."lang_files/".$lang.".png")){
        $style=" style='background-image: url($path"."lang_files/$lang.png)'";
    }else{$style="";}
    echo "<select id='chooseLanguage'$style onchange='window.location.href+=\"&lang=\"+this.value;'>";
    foreach ($langs as $langCode => $langName) {
        if($langCode==$lang){
            echo "<option value='$langCode' selected>$langName</option>";
        }else{
            echo "<option value='$langCode'>$langName</option>";
        }
    }            
    echo '</select>';            
}

/**
 * include the stylesheet
 */
function include_style() {
    global $path;
    echo "<link rel='stylesheet' href='$path"."style.css' />";
}