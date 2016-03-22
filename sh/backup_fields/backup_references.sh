#!/bin/bash
rm ../../export/references.json
mongoexport --db journals --collection ci --fields references --out ../../export/references.json
