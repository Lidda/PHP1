<?php
  //Access token & access token secret
  define("TOKEN", '1155343201-u0spdDPb96HynenmKhapoPawDehXkQKEgnHMWmv'); //Access token
  define("TOKEN_SECRET", 'ipUB4yDqpEW65WKvJZYjzUg6udhyfxbv1TPIJnnFCpioT'); //Access token secret
  //Consumer API keys
  define("CONSUMER_KEY", 'FAeOrLJfx6SxCIGcVh3753f4X'); //API key
  define("CONSUMER_SECRET", 'I2OHtDEMPtjqFAywUB3QaiEhfWEVhRZVMxMw83WQ6oS3xIpi7I'); //API secret key

  class TwitterAPI {


    //Putting everything in format that twitter requires
    function twitter_search($query, $oauth, $url){
        $method = "GET";

        $arr=array_merge($oauth, $query); //Combine the values THEN sort
        asort($arr); //Secondary sort (value)
        ksort($arr); //Primary sort (key)
        $querystring=http_build_query($arr,'','&');
        //Create one long encrypted string with query
        $base_string=$method."&".rawurlencode($url)."&".rawurlencode($querystring);
        //Create one long encrypted string with login
        $key=rawurlencode(CONSUMER_SECRET)."&".rawurlencode(TOKEN_SECRET);
        //Generate the hash
        $signature=rawurlencode(base64_encode(hash_hmac('sha1', $base_string, $key, true)));
        //This time we're using a normal GET query, and we're only encoding the query params (without the oauth params)
        $url=str_replace("&amp;","&",$url."?".http_build_query($query));
        $oauth['oauth_signature'] = $signature; //Don't want to abandon all that work!
        $auth="OAuth ".urldecode(http_build_query($oauth, '', ', '));
        //Webrequest info
        $options=array( CURLOPT_HTTPHEADER => array("Authorization: $auth"),
                          //CURLOPT_POSTFIELDS => $postfields,
                          CURLOPT_HEADER => false,
                          CURLOPT_URL => $url,
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_SSL_VERIFYPEER => false);
        //Query Twitter API
        $feed=curl_init();
        curl_setopt_array($feed, $options);
        $json=curl_exec($feed);
        curl_close($feed);
        //return json code as php array
        $array = json_decode($json, true);
        return $array['statuses'];
    }

    function GetTweets(){
      $host='api.twitter.com';
      $path='/1.1/search/tweets.json'; //API call path
      $url="https://$host$path";
      //Query parameters
      $query = array(
          'q' => 'AnimalCrossingNewLeaf', // search tweets tagged 'ACNL'
          'count' => '10',               // only 10 tweets at a time
          'result_type' => 'recent',     // Return only the most recent results in the response
          'include_entities' => 'false'  // Saving unnecessary data
      );

      //Login details
      $oauth = array(
          'oauth_consumer_key' => CONSUMER_KEY,
          'oauth_token' => TOKEN,
          'oauth_nonce' => (string)mt_rand(),
          'oauth_timestamp' => time(),
          'oauth_signature_method' => 'HMAC-SHA1',
          'oauth_version' => '1.0'
      );

      return $this->twitter_search($query,$oauth,$url);
    }

  }
?>
