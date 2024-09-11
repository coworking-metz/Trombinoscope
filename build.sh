#!/bin/bash

base=$(dirname "$(readlink -f "$0")")
echo $base
# Function to concatenate JS files
concatenate_js() {
    > trombi.js  # Clear or create trombi.js
    cd $base
    for file in js/*.js; do
        echo "// $file" >> trombi.js
        cat "$file" >> trombi.js
        echo "" >> trombi.js  # Add a newline between files to avoid issues
    done

    echo "Concatenation complete. Check trombi.js."
}

# Check if the --watch argument is given
if [[ "$1" == "--watch" ]]; then
    echo "Watching js directory for changes..."
    while true; do
        inotifywait -e close_write,moved_to,create $base/js
        echo "Changes detected, rebuilding at $(date +"%Y-%m-%d %H:%M:%S")..."
        concatenate_js
    done
else
    concatenate_js
fi
