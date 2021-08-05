#!/bin/bash

_HOST="http://communemesure.fr"
_WORKINGDIR="$(dirname "$0")"
_SECTIONS=("header" "footer")

# Sections

for section in "${_SECTIONS[@]}"; do
    tempfile=`mktemp`

    curl "${_HOST}/blog/export/" | tr -d '\n' | tr -d '\t' | sed "s#</${section}>.*#</${section}>#" | sed "s#.*<${section}#<${section}#" > "$tempfile"

    sed -i 's/<header id="main-header"/<header id="main-header" class="navbar is-fixed-top"/' "$tempfile"
    sed -i 's/et-waypoint //' "$tempfile"
    sed -i 's/et-l et-l--footer/footer/' "$tempfile"

    mv "$tempfile" "$_WORKINGDIR/../resources/views/generate/"${section}".blade.php"
    chmod g+rw "$_WORKINGDIR/../resources/views/generate/"${section}".blade.php"
    chmod o+r "$_WORKINGDIR/../resources/views/generate/"${section}".blade.php"
done

# Fonts

wget 'http://communemesure.fr/wp-content/themes/Divi/core/admin/fonts/modules.ttf' -O "$_WORKINGDIR/../public/fonts/modules.ttf"
wget 'http://communemesure.fr/wp-content/themes/Divi/core/admin/fonts/modules.woff' -O "$_WORKINGDIR/../public/fonts/modules.woff"
