<?php
//Array to extact => [name, education, research interests, email, webpage]

$url = 'https://cs.txstate.edu/accounts/profiles/hs15/';
$html = file_get_contents($url);
$html = file_get_contents('/Users/mjlarson13/Documents/test-html-parse.html');

preg_match_all('#<h3 class="heading-title pull-left">(.*?)</h3>#s', $html, $arr);

$arr[1][0];

$info = array("name" => trim(preg_replace('#\s+#', ' ', $arr[1][0])));

preg_match_all('#<h3 class="panel-title">Education.*?/p>#s', $html, $arr);
preg_match_all('#<p>.*</p>#', $arr[0][0], $arr);

$info["education"] = trim(preg_replace('#<p>|</p>#', '', $arr[0][0]));

preg_match_all('#<h3 class="panel-title">Research Interests.*?/p>#s', $html, $arr);
preg_match_all('#<p>.*</p>#', $arr[0][0], $arr);
$info["interests"] = trim(preg_replace('#<p>|</p>#', '', $arr[0][0]));

preg_match_all('#.*class="email-image".*>#', $html, $arr);
print_r($arr);

//preg_match_all('#<li.*href="/accounts/login/?next=/accounts/profiles/.*?/.*#s', $html, $arr);

$info["email"] = (trim(preg_replace('#.*user=|&.*#', '', $arr[0][0])) . '@txstate.edu');

preg_match_all('#href=.*?Homepage#', $html, $arr);
$info["website"] = trim(preg_replace('#href=\"|\">Homepage#', '', $arr[0][0]));

foreach($info as &$elem)  $elem = htmlspecialchars_decode($elem);
print_r($info);
//print_r($arr);
