@echo off
title Run BrakingPoint Server
rem Starting server
echo Starting server
start cmd /k php artisan serve
start cmd /k npm run dev
pause
