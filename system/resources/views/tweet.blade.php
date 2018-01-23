<?php
Twitter::reconfig(['token' => '', 'secret' => '']);
$token = Twitter::getRequestToken(url('twitter/callback'));
$tweets = Twitter::getUserTimeline(['screen_name' => 'thujohn', 'count' => 20, 'format' => 'json']);
$tweets = json_decode($tweets, true);
foreach ($tweets as $key => $value) {
  echo $value['text'].'<br>';
}
?>