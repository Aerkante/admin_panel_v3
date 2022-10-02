#! /bin/sh
quasar build -m pwa 
cp .htaccess dist/pwa/
cd dist/pwa
zip -r build.zip *