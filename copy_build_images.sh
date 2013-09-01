#!/bin/bash  

rsync -avrzt --copy-links --delete-during --progress --exclude 'wbg/tmp' --exclude '__saved_data*' --exclude 'error_log' --exclude '.git' -e ssh /Users/andrey/Sites/hanna/images/skins/hanna/building/ andreybu@andreybuligin.com:public_html/hanna/images/skins/hanna/building/