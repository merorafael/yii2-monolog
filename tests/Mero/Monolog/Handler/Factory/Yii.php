<?php

namespace Mero\Monolog\Handler\Factory;

if (!class_exists('\Yii') && !class_exists(__NAMESPACE__.'\Yii')) {
    class Yii
    {
        public static function getAlias($alias)
        {
            return $alias;
        }
    }
}
