#!/bin/bash

./altmetrics.sh export/identifier.csv
sleep 2
./altmetrics_facebook_relation.sh export/relation.csv
