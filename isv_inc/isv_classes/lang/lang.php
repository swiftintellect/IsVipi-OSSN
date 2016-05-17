<?php
class language {
    var $translation;

    function language($lang) {
        if (file_exists(ISVIPI_ROOT . 'isv_lang/' . $lang . '.php')) {
            include(ISVIPI_ROOT . 'isv_lang/' . $lang . '.php');
            $this->translation = $lang;
        }
    }

    function translate($str, $tokens = array()) {
        if (array_key_exists($str, $this->translation)){
            $str = $this->translation[$str];
            if (is_array($tokens) && sizeof($tokens) > 0){
                $str = vsprintf($str, $tokens);
            }
        } else {
            $str = '[' . $str . ']';
        }
        return $str;
    }
}
?>