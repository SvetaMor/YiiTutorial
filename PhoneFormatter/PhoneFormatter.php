<?php
namespace app\components;

use yii\i18n\Formatter;

class PhoneFormatter extends Formatter {

    public function asPhone($value) {
        $value = trim($value);
        $len = strlen($value);
        if ($len == 10) {
           $mask = "+7 ($1) $2-$3-$4";
           $group ="/(\d{3})(\d{3})(\d{2})(\d{1,})$/";
        }
        else if ($len == 11) {
           if (preg_match('/^7/', $value)) 
              $mask = "+$1 ($2) $3-$4-$5";
           else 
              $mask = "$1 ($2) $3-$4-$5";
           $group ="/(\d{1})(\d{3})(\d{3})(\d{2})(\d{1,})$/";     
        } 
        else {
           $mask = "($1) $2-$3-$4";
           $group ="/(\d{1,3})(\d{0,3})(\d{0,3})(\d{0,})$/";
        }
        return preg_replace($group, $mask, $value);
    }
}