#!/bin/bash

# Navigate to the project directory
cd /home/ubuntu/CryptChat

# Pull the latest code from the repository
git pull

sudo systemctl restart php-localhost

