<?php 
function strip_slashes($str)
{
    if ( ! is_array($str))
    {
        return stripslashes($str);
    }

    foreach ($str as $key => $val)
    {
        $str[$key] = strip_slashes($val);
    }

    return $str;
}
function strip_quotes($str)
{
    return str_replace(array('"', "'"), '', $str);
}
function quotes_to_entities($str)
{
    return str_replace(array("\'","\"","'",'"'), array("&#39;","&quot;","&#39;","&quot;"), $str);
}
function reduce_double_slashes($str)
{
    return preg_replace('#(^|[^:])//+#', '\\1/', $str);
}
function reduce_multiples($str, $character = ',', $trim = FALSE)
{
    $str = preg_replace('#'.preg_quote($character, '#').'{2,}#', $character, $str);
    return ($trim === TRUE) ? trim($str, $character) : $str;
}
function random_string($type = 'alnum', $len = 8)
{
    switch ($type)
    {
        case 'basic':
            return mt_rand();
        case 'alnum':
        case 'numeric':
        case 'nozero':
        case 'alpha':
            switch ($type)
            {
                case 'alpha':
                    $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;
                case 'alnum':
                    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;
                case 'numeric':
                    $pool = '0123456789';
                    break;
                case 'nozero':
                    $pool = '123456789';
                    break;
            }
            return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
        case 'unique': // todo: remove in 3.1+
        case 'md5':
            return md5(uniqid(mt_rand()));
        case 'encrypt': // todo: remove in 3.1+
        case 'sha1':
            return sha1(uniqid(mt_rand(), TRUE));
    }
}
function increment_string($str, $separator = '_', $first = 1)
{
    preg_match('/(.+)'.preg_quote($separator, '/').'([0-9]+)$/', $str, $match);
    return isset($match[2]) ? $match[1].$separator.($match[2] + 1) : $str.$separator.$first;
}
function alternator()
{
    static $i;

    if (func_num_args() === 0)
    {
        $i = 0;
        return '';
    }

    $args = func_get_args();
    return $args[($i++ % count($args))];
}