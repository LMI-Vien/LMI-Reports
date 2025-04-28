<?php

if (!function_exists('css')) {
    function css(string $file, string $title = null): void
    {
        echo PHP_EOL;
        if ($title !== null) {
            echo "<!-- {$title} -->" . PHP_EOL;
        }

        if (!file_exists($file)) {
            echo "<!-- CSS file not found: {$file} -->" . PHP_EOL;
            return;
        }

        echo '<style type="text/css">' . minify_css(file_get_contents($file)) . '</style>' . PHP_EOL . PHP_EOL;
    }
}

if (!function_exists('js')) {
    function js(string $file, string $title = null): void
    {
        echo PHP_EOL;
        if ($title !== null) {
            echo "<!-- {$title} -->" . PHP_EOL;
        }

        $path = realpath($file);
        if ($path && file_exists($path)) {
            echo '<script type="text/javascript">' . minify_js(file_get_contents($path)) . '</script>' . PHP_EOL . PHP_EOL;
        } else {
            echo "<!-- JS file not found: {$file} -->" . PHP_EOL;
        }
    }
}

if (!function_exists('minify_css')) {
    function minify_css(string $css): string
    {
        // Remove comments, tabs, spaces, newlines, etc.
        $pattern = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/';
        $css = preg_replace($pattern, '', $css);
        $css = preg_replace('/\s+/', ' ', $css);
        $css = preg_replace('/\s*([{}|:;,])\s+/', '$1', $css);
        $css = str_replace(';}', '}', $css);
        return trim($css);
    }
}

if (!function_exists('minify_js')) {
    function minify_js(string $js): string
    {
        // 1. Remove single-line comments, but only those not in strings
        $js = preg_replace('#(?<!:)//.*$#m', '', $js);

        // 2. Remove multi-line comments (/* ... */)
        $js = preg_replace('#/\*.*?\*/#s', '', $js);

        // 3. Remove unnecessary whitespace (but not inside strings)
        $tokens = preg_split('/("[^"]*"|\'[^\']*\')/', $js, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($tokens as $i => $token) {
            if ($i % 2 == 0) {
                // Outside of quotes: trim and normalize spaces
                $tokens[$i] = preg_replace('/\s+/', ' ', $token);
            }
        }

        return trim(implode('', $tokens));
    }
}

