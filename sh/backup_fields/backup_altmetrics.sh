#!/bin/bash
rm ../../export/altmetrics.json
mongoexport --db journals --collection ci --fields facebook_atualizacao,facebook_url_likes,facebook_url_shares,facebook_url_comments,facebook_url_clicks,facebook_url_total --out ../../export/altmetrics.json
