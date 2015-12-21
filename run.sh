#!/bin/bash

./csv_export.sh
sleep 2
./transform.sh export/export.csv export/final.csv