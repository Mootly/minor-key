<?php

use atoum\atoum;

$stdout = new atoum\writers\std\out;
$report = new atoum\reports\realtime\nyancat;
$script->addReport(
    $report->addWriter($stdout)
);

/// directions https://www.sitepoint.com/testing-php-code-with-atoum-an-alternative-to-phpunit/
/// https://keepachangelog.com/en/1.0.0/
/// https://docs.phpdoc.org/latest/references/phpdoc/index.html
/// http://phppackagechecklist.com/#1,2,3,4,5,6,7,8,9,10,11,12,13,14
///
