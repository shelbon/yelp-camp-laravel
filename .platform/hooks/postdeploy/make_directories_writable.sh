#!/bin/sh

# Laravel requires some directories to be writable.
sudo chmod -R 777 storage;
sudo chmod -R 777 bootstrap/cache/;
sudo npm install;
sudo npm run build;
sudo chmod -R 777 public/build/;
