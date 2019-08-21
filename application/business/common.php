<?php

/**
 * 专门用于business的session
 * @param $key
 * @param string $value
 * @return mixed
 */
function session_business($key, $value = ''){
    if(is_null($key)){
        session(null, 'business');
    }else{
        return session($key, $value, 'business');
    }
}