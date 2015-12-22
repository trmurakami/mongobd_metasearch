#!/bin/bash

rm export/*.*
sleep 2
./csv_export.sh
sleep 2
./transform.sh export/export.csv export/final.csv