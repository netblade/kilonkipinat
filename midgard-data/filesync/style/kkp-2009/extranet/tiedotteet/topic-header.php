<?php
/*
*  Available request keys:
*  $data['topic']; (the topic from where the content is fetched)
*  $data['feedtopic']; (the feedcollector topic object)
*  $data['counters']; (array of counters to help you order your results)
*    topic        - count the topic we are on
*    topics       - overall count of topics to show
*    items        - overall count of items
*    topic_items  - count of items to show in this topic
* 
*/  
$url = $data['permalinks']->create_permalink($data['topic_data']['target_topic_object']->guid);
// counter for topic
$topic_counter = $data['counters']['topic'];
?>
<div class="net_nemein_feedcollector_topic topic_counter_&(topic_counter);">
<h2><a href="&(url);"><?php echo $data['feedtopic']->title; ?></a></h2>