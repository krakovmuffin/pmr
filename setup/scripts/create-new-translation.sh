#!/bin/bash

# Variables
dir="app/translations"
tmp=$(mktemp)
should_append_translation=false

# CTRL-C redirect
quit() {
    echo ""
    echo "--"
    echo "Exited."
    echo ""
    rm -f $tmp
    exit
}
trap quit SIGINT
trap quit SIGTERM

# Ask Y/N question
confirm() {
    read -p "$1" response
    case $response in
        [yY][eE][sS]|[yY])
            confirmed=true;;
        *)
            confirmed=false;;
    esac
    echo $confirmed
}

# Entrypoint
echo "--"

echo "Let's create a new translation"

echo "--"

echo "Gathering translation calls"

echo "--"

translations=$(find ./app/views/ -type f -exec grep -E "__\(.+\)" -o {} \;  | tr -d "_()'\"[]$"  | grep -E "[a-zA-Z %]+[^$]")
translations_count="$( echo "$translations" | wc -l | tr -d ' ')"

echo "$translations_count translations found"

echo "--"

read -p "What is the code for this new translation ? (xx-YY) " translation_code

if [[ -z $translation_code ]]; then
    exit
fi

output="$translation_code.php"

if [ -f "$dir/$output" ]; then
    echo "--"
    echo "This translation exists already"
    quit
fi

echo "--"

# TODO
while IFS= read -r line; do
    echo $line
    read -p "ok ? " x
done < "$translations"

# has_confirmed=$(confirm "Should we automatically add this translation to the loaded ones ? (Y/N) ")
# should_append_translation=$has_confirmed

# if [[ $should_append_translation = true ]]; then
# fi

# echo "--"

# echo "Alright, your new "

# echo "--"

