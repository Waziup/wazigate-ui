#!/bin/bash

#By Moji
#This file updates the local copy of waziup.io

cd /app/public/
wget --mirror -p --convert-links -P ./ https://www.waziup.io  &> update_logs.txt