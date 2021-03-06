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


function lang_textContentUpdate(id){
    var xhr =  new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200 ) {}
    };
    fd = new FormData();
    fd.append( 'id', id );
    fd.append( 'new_text', document.getElementById(id).innerHTML );
    xhr.open("POST", "<?php echo filter_input(INPUT_GET, 'path',FILTER_SANITIZE_STRING);?>update_lang_content.php", true);
    xhr.send(fd);
}

document.addEventListener('DOMContentLoaded', function () {
<?php
$ids=unserialize(filter_input(INPUT_GET, 'ids'));
foreach ($ids as $id) {
echo "document.querySelector('#$id').addEventListener('blur', function() {lang_textContentUpdate('$id');});";
}
?>
});

