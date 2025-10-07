#!/bin/bash
for file in $(find database/migrations -name "*.php" -exec grep -l "Setting::create" {} \;); do
    echo "Fixing $file"
    sed -i "s/Setting::create(\[/Setting::create([\n            'value' => '',/g" "$file"
    sed -i "s/'key' => '\([^']*\)',/'key' => '\1',\n            'value' => '',/g" "$file"
done
