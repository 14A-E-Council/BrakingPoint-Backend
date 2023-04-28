@echo off
title Migrate BrakingPoint Database
rem Installing node packages
echo Installing node packages
start cmd /k npm i
pause
rem Migrating database
echo Migrating database
start cmd /k php artisan migrate
rem Create vendor folder
echo Creating vendor folder
start cmd /k composer install
pause
