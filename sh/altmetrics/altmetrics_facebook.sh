#!/bin/bash

query_url_facebook() {
  url_facebook="https://graph.facebook.com/fql?q=SELECT%20like_count,%20total_count,%20share_count,%20click_count,%20comment_count%20FROM%20link_stat%20WHERE%20url%20=%20%22$1%22"
  result_facebook=$(curl -s -G -L $url_facebook)
  result_url_facebook_likes=$(echo $result_facebook | jq '.data[0].like_count')
  result_url_facebook_shares=$(echo $result_facebook | jq '.data[0].share_count')
  result_url_facebook_comments=$(echo $result_facebook | jq '.data[0].comment_count')
  result_url_facebook_click=$(echo $result_facebook | jq '.data[0].click_count')
  result_url_facebook_total=$(echo $result_facebook | jq '.data[0].total_count')

 echo $url
 echo $result_facebook
 echo share $result_url_facebook_shares
 echo comment $result_url_facebook_comments
 echo like $result_url_facebook_likes
 echo click $result_url_facebook_click
 echo total $result_url_facebook_total
 echo \n

}

IFS=$'\n'       # make newlines the only separator
for line in $(cat $1);
do

line=$(printf "%s\n" "$line" | sed "s/,\"\[/#/g" | sed 's/,$/#/g')
_id=$(printf "%s\n" "$line" | cut -d "#" -f 1 | sed 's/\"//g')
url=$(printf "%s\n" "$line" | cut -d "#" -f 2 | sed 's/\"//g' | sed 's/\]//g' )
query_url_facebook $url
hoje=$(date +'%Y%m%d')

echo "db.ci_altmetrics.update({\"_id\" : \""$_id"\"},{\$set: {facebook_url_likes: "$result_url_facebook_likes",facebook_url_shares: "$result_url_facebook_shares",facebook_url_comments: "$result_url_facebook_comments",facebook_url_clicks: "$result_url_facebook_click",facebook_url_total: "$result_url_facebook_total",facebook_atualizacao: "$hoje"}},{ upsert: true })" | mongo journals

sleep 7

done
