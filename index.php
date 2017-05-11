<!DOCTYPE html>
<!--
Copyright (C) 2017 Pierre F

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
-->
<?php
    $path='langManagementSystem/';
    require_once "$path"."lang_responsive.php";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Exemple Page</title>
        <link rel="stylesheet" href="ress/css/style.css" />
        <?php include_style(); ?>
    </head>
    <body>
        <header>
            <ul>
                <li>
                    Exemple Page
                </li>
                <li><?php lang_textarea("dl"); ?></li>
                <li><?php lang_textarea("mod"); ?></li>
                <li>
                    <?php
                        $langs=array(
                            "en"=>"English",
                            "fr"=>"Français",
                            "de"=>"Deutsch"
                        );
                        create_SelectLanguage($langs);
                    ?>
                </li>
            </ul>
        </header>
        <aside></aside>
        <section></section>
        <footer></footer>
        <?php lang_endFile();?>
    </body>
</html>