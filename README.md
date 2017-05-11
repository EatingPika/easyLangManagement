# easyLangManagement

easy and lightweight system for language management and update, usefull during as site devellopement to collaborate on the translation
-> not the most secured system, remove it once the site have been translated
-> switch from consultation to admin mode with a code in the url (get variable) 
-> switch from a language to another with the select area, or in the url (get), defaut display language is your system language
-> in admin mode, change content, it will automaticly be updated

# exemple of url to access the option

myPage2Translate?admin=authentification_code&lang=en

# remarks

index.php is an exemple file to show how to call the system

please respect the architecture of langManagementSystem folder (to avaoid file missing problemes)

# functions to call to include the system

first of all include the functions file, the path variable define the path from the containing file to the language system root
<?php
    $path='langManagementSystem/';
    require_once "$path"."lang_responsive.php";
?>

inclusion of the stylesheet if you want the red border to know which text are editable and if you want to include images
<?php include_style(); ?>
==> recommended (if you create the automaticly generated language select), i haven't test if the images in the select area are not too big else

create some text editable areas
<?php lang_textarea("dl"); ?> for each area

add the language select area
<?php
    $langs=array(
        "en"=>"English",
        "fr"=>"Français",
        "de"=>"Deutsch"
    );
    create_SelectLanguage($langs);
?>

end the file (include the code to take care about the text updates) --> to include at file end (or at least after each editable areas)
<?php lang_endFile();?>

# configuration

array in the lang_responsive.php file to configure options
$configuration=array(
    "defautLanguageCode"=>"en",
    "maxLanguageCodeLength"=>4,
    "defaultPath"=>"langManagementSystem/",
    "secretAdminKey"=>"2",
    "psswdForeachLang"=>FALSE //if set to false -> secret key will be psswd for admin, if true --> password will be intval(language code concatened with admin key,36)%1000;
);
-> defautLanguageCode => the language that will be displayed if for the demanded language (select or user browser language) no language file exists
-> maxLanguageCodeLength => to take care about language code length (usually 2: en, fr, de, but sometimes more)
-> default path => path to root, or if you have all page in same folder with this var you will not need to define path before the require_once
-> secretAdminKey => has an influence on your psswd
-> psswdForeachLang => has an influence to, used to define if their should be differents code for each language (each translator can only change his language)

more infos to the authentification
-> if psswdForeachLang=false, all the labnguage have same psswd, and its secretAdminKey
-> if its set to true, all language have differents psswd generated from secretAdminKey and from language (lightweight method instead of DB with psswd definition)
