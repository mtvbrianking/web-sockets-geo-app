<?php

require __DIR__ . '/vendor/autoload.php';

require 'device-logs.php';

try {

  $redis = new Predis\Client([
    'scheme' => 'tcp',
    'host' => '127.0.0.1',
    'port' => 6379,
  ]);

  // print json_encode($deviceLogs);

  # -----------------------------------------------------------

  // Set counter.
  // When device started reporting...
  $start_at = strtotime($deviceLogs[0]['reported_at']);

  foreach($deviceLogs as &$deviceLog) {
    // Don't time out...
    set_time_limit(0);

    // Determine time elapsed since device started broadcasting...
    $reported_at = strtotime($deviceLog['reported_at']);
    // $offset = ($reported_at - $start_at); // realtime
    $offset = round(($reported_at - $start_at)/60); // 60X faster
    $deviceLog['offset'] = $offset;

    flush();

    print 'Sleep => '.$offset.'seconds'.PHP_EOL;

    sleep($offset);

    print date('Y-m-d H:i:s').' => '.$deviceLog['event'].PHP_EOL;

    // Send to NodeJS Socket.IO via 'device' channel
    $redis->publish('device', json_encode($deviceLog));

    // restart counter...
    $start_at = strtotime($deviceLog['reported_at']);
  }

  # -----------------------------------------------------------

} catch (Exception $e) {
  die($e->getMessage());
}
