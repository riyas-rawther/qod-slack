<?php
        $service_url     = 'http://quotes.rest/qod.json?category=management';
        $curl            = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $curl_response   = curl_exec($curl);
        curl_close($curl);
        $json_objekat    = json_decode($curl_response);
        $quotes          = $json_objekat->contents->quotes;

        foreach($quotes as $intKey=>$objQuote){
           // echo $objQuote->title       . '<br>';
           // echo $objQuote->author      . '<br>';
           // echo $objQuote->quote       . '<br>';
           // echo $objQuote->background  . '<br>';
        }
// echo $objQuote->quote;

$data = array (
'text' => "Quote of ".date("d/m/Y"),
  'blocks' =>
  array (
    0 =>
    array (
      'type' => 'header',
      'text' =>
      array (
        'type' => 'plain_text',
        'text' => 'Quote of the day - '.date("d/m/Y"),
        'emoji' => true,
      ),
    ),
    1 =>
    array (
      'type' => 'section',
      'text' =>
      array (
        'type' => 'mrkdwn',
        'text' => $objQuote->quote,
      ),
    ),
    2 =>
    array (
      'type' => 'context',
      'elements' =>
      array (
        0 =>
        array (
          'type' => 'plain_text',
          'text' => 'Author: '.$objQuote->author,
          'emoji' => true,
        ),
      ),
    ),
    3 =>
    array (
      'type' => 'divider',
    ),
  ),
);
$data = json_encode($data);

$url ='https://hooks.slack.com/services/xxxxxx/yyyyyyy/zzzzzz';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);

if($result === false)
{
    echo 'Curl error: ' . curl_error($ch);
}

curl_close($ch);

// echo $data;
