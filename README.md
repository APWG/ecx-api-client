# ecx-api-client
*A PHP library for interacting with the APWG eCX API*

Fully supports all features of the eCX API.

See the [/docs](/docs) directory for HTML documentation. 

Example script to write a time ranged and confidence filtered list to a file in csv (uses nategood/commando for cli options):
```php
#!/usr/bin/env php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$command = new \Commando\Command();
$command->option('token')->aka('t')->required(TRUE)->description('Your eCX API token');
$command->option('dd_date_start')->aka('s')->required(TRUE)->description('The starting epoch timestamp');
$command->option('dd_date_end')->aka('e')->required(TRUE)->description('The ending epoch timestamp');
$command->option('confidence_level')->aka('c')->required(TRUE)->description('The confidence level');
$command->option('base_uri')->aka('b')->required(TRUE)->description('The base APWG API uri');
$command->option('out')->aka('o')->required(TRUE)->description('The path to the output file to write the csv data to');

$client = new \APWG\API\Phish\PhishClient($command['base_uri'], $command['token']);

$headers = [
	'url',
	'brand',
	'confidence_level',
	'date_discovered',
];

println(implode(',', $headers), $command['out']);

$i = 0;
$toBreak = FALSE;
while ($toBreak == FALSE) {
	echo "[*] pulling page " . $i . PHP_EOL;
	$data = json_decode($client->search([
		'dd_date_start'    => $command['dd_date_start'],
		'dd_date_end'      => $command['dd_date_end'],
		'confidence_level' => $command['confidence_level'],
		'page'             => $i,
	])->getBody()->getContents(), TRUE);
	if ($data['current_count'] < 500) {
		$toBreak = TRUE;
		if ($data['current_count'] == 0) {
			continue;
		}
	}
	foreach ($data['_embedded']['phish'] as $phish) {
		println(implode(',', [
			'"' . $phish['url'] . '"',
			'"' . $phish['brand'] . '"',
			$phish['confidence_level'],
			gmdate(DATE_ATOM, $phish['date_discovered']),
		]), $command['out']);
	}
	$i++;
}


function println($string, $file) {
	file_put_contents($file, $string . PHP_EOL, FILE_APPEND);
}
```