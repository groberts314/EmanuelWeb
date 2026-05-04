<?php
    /**
     * Adapted from: https://stackoverflow.com/a/67413624
     */
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    $channel_id = 'UC4Fu6qvPdYF2MM92JzoU9uA'; // Emanuel Lutheran Church YouTube Channel ID
    $liveStreamVideoId = 'C-2TNopHmEg'; // YouTube Video ID for the default Live Stream
  
    // Option 1 - Check if YouTube is streaming LIVE
    // Web scraping to check if we are LIVE on YouTube
    $contents = file_get_contents('https://www.youtube.com/channel/' . $channel_id);

    $searchfor = '{"text":" watching"}';
    $pattern = preg_quote($searchfor, '/');
    $pattern = "/^.*$pattern.*\$/m";
    if (preg_match_all($pattern, $contents, $matches)) {
      //truncate $contents so that the match can be found easily.
      $contents = substr($contents, strpos($contents, $searchfor));  

      // If the video is LIVE or Premiering, fetch the video id.
      $search_video_id = '{"url":"/watch?v=';
      $video_pattern = preg_quote($search_video_id, '/');
      $video_pattern = "~$video_pattern\K([A-Za-z0-9_\-]{11})~";
      preg_match($video_pattern, $contents, $video_ids);

      $data = [ 'status' => 200, 
                'isLive' => true, 
                'title' => 'Live Stream',
                'iframeUrl' => 'https://www.youtube-nocookie.com/embed/' . $video_ids[0],
                'watchUrl' => 'https://www.youtube.com/watch?v=' . $video_ids[0]
              ];
    } else {
        // Option 2 - Get the RSS YouTube Feed and the latest video from it
        $youtube = file_get_contents('https://www.youtube.com/feeds/videos.xml?channel_id=' . $channel_id . '&orderby=published');
        $xml = simplexml_load_string($youtube, "SimpleXMLElement", LIBXML_NOCDATA);

        $json = json_encode($xml);
        $youtube = json_decode($json, true);
        
        foreach ($youtube['entry'] as $k => $v) { // get the latest video id that's a worship video (e.g. not a special event like the Praise Symphany Orchestra concert)
            $link = $v['link']['@attributes']['href'];
            $pos = strrpos($link, '=');
            $id = substr($link, $pos + 1, strlen($link) - $pos);
            $title = $v['title'];

            if (/*$id != $liveStreamVideoId &&*/ strpos(strtolower($title), 'worship') !== false) {
                break;
            }
        }

        $data = [ 'status' => 200, 
                'isLive' => false,
                'title' => $title,
                'iframeUrl' => 'https://www.youtube-nocookie.com/embed/' . $id,
                'watchUrl' => 'https://www.youtube.com/watch?v=' . $id
              ];
    }

    echo json_encode( $data, JSON_UNESCAPED_SLASHES );
?>