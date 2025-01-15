<?php

    function css($file,$title =null) {
        echo "\n";
        if($title != null){
            echo "<!--" . $title . "-->" . "\n";
        }
        echo '<style type="text/css">';
        $Content = minify_css(file_get_contents($file)); 
        $Content = "?> ".$Content; 
        eval($Content);
        echo "</style>\n\n";
    }

    function js($file,$title =null) {
        echo "\n";
        if($title != null){
            echo "<!--" . $title . "-->" . "\n";
        }
        echo '<script type="text/javascript">';

        $Content = minify_css(file_get_contents($file)); 
        $Content = "?> ".$Content; 
        eval($Content);
        echo "</script>\n\n";
    }

    function minify_css($css) {
        $pattern = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/';
        $css = preg_replace($pattern, '', $css);
        preg_match_all('/(\'[^\']*?\'|"[^"]*?")/ims', $css, $hit, PREG_PATTERN_ORDER);
        for ($i=0; $i < count($hit[1]); $i++) {
            $css = str_replace($hit[1][$i], '##########' . $i . '##########', $css);
        }
        $css = preg_replace('/;[\s\r\n\t]*?}[\s\r\n\t]*/ims', "}\r\n", $css);
        $css = preg_replace('/;[\s\r\n\t]*?([\r\n]?[^\s\r\n\t])/ims', ';$1', $css);
        $css = preg_replace('/[\s\r\n\t]*:[\s\r\n\t]*?([^\s\r\n\t])/ims', ':$1', $css);
        $css = preg_replace('/[\s\r\n\t]*,[\s\r\n\t]*?([^\s\r\n\t])/ims', ',$1', $css);
        $css = preg_replace('/[\s\r\n\t]*{[\s\r\n\t]*?([^\s\r\n\t])/ims', '{$1', $css);
        $css = preg_replace('/([\d\.]+)[\s\r\n\t]+(px|em|pt|%)/ims', '$1$2', $css);
        $css = preg_replace('/([^\d\.]0)(px|em|pt|%)/ims', '$1', $css);
        $css = preg_replace('/\p{Zs}+/ims',' ', $css);
        $css = str_replace(array("\r\n", "\r", "\n"), '', $css);
        for ($i=0; $i < count($hit[1]); $i++) {
            $css = str_replace('##########' . $i . '##########', $hit[1][$i], $css);
        }
        return $css;
    }



