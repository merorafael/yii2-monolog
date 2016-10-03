<?php
$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__)
    ->exclude('vendor')
;

return Symfony\CS\Config\Config::create()
    ->fixers(array('-symfony'))
    ->finder($finder)
    ->setUsingCache(true)
;