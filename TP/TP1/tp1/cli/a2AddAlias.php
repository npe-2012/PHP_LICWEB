#!/usr/bin/env php
<?php

function usage($exitCode = 1)
{
	echo <<<EOF
		Usage:

		sudo a2AddAlias tp1 /var/www/tp1/public

		EOF;
	exit($exitCode);
}

// retrieve arguments and validate
if ($argc !== 3) {
	usage();
}

$alias = $argv[1];
$dir = $argv[2];

// check file exists
if (!file_exists($dir)) {
	printf("Directory %s does not exist", $dir);
	usage(0);
}

// only characters are allowed in alias name
if (!preg_match('#^\w+$#', $alias)) {
	printf("Alias %s contains illegal characters", $alias);
	usage();
}

// generate alias template
$template = <<<EOF
# Generated on %date%
Alias /%alias% %dir%
EOF;

$content = strtr($template, array(
			'%date%'    => date('l jS \of F Y h:i:s A'),
			'%dir%'     => $dir,
			'%alias%'   => $alias
			));

$filename = sprintf('/etc/apache2/sites-available/%s', $alias);
file_put_contents($filename, $content);
system(sprintf('a2ensite %s', $alias));
system('apache2ctl restart');
