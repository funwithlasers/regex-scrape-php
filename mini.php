<?php
//Array to extact => [name, education, research interests, email, webpage]

$url = 'https://cs.txstate.edu/accounts/profiles/hs15/';
$html = file_get_contents($url);

//Capture name
preg_match_all('#<h3 class="heading-title pull-left">(.*?)</h3>#s', $html, $arr);
//Save name to array after turning newlines to single whitespace
$info = array("name" => trim(preg_replace('#\s+#', ' ', $arr[1][0])));

//Rinse and repeat for education
preg_match_all('#<h3 class="panel-title">Education.*?/p>#s', $html, $arr);
preg_match_all('#<p>.*</p>#', $arr[0][0], $arr);
$info["education"] = trim(preg_replace('#<p>|</p>#', '', $arr[0][0]));

//Rinse and repeat for research interests
preg_match_all('#<h3 class="panel-title">Research Interests.*?/p>#s', $html, $arr);
preg_match_all('#<p>.*</p>#', $arr[0][0], $arr);
$info["interests"] = trim(preg_replace('#<p>|</p>#', '', $arr[0][0]));

//Rinse and repeat for email address
preg_match_all('#.*class="email-image".*>#', $html, $arr);
$info["email"] = (trim(preg_replace('#.*user=|&.*#', '', $arr[0][0])) . '@txstate.edu');

//Rinse and repeat for website
preg_match_all('#href=.*?Homepage#', $html, $arr);
$info["website"] = trim(preg_replace('#href=\"|\">Homepage#', '', $arr[0][0]));

//Convert all html special characters back to symbols
foreach($info as &$elem)  $elem = htmlspecialchars_decode($elem);
print_r($info);
