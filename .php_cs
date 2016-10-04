<?php
$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__)
    ->exclude('vendor')
;

return Symfony\CS\Config\Config::create()
    ->fixers(array('-psr2'))
    ->finder($finder)
    ->setUsingCache(true)
;