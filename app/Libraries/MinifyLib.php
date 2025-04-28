<?php

namespace App\Libraries;

use MatthiasMullie\Minify;

class MinifyLib
{
    public function css(string $filePath, string $comment = '')
    {
        if (!is_file($filePath)) {
            return ''; // Handle missing file gracefully
        }

        $minifier = new Minify\CSS($filePath);

        $output = '';

        if (!empty($comment)) {
            $output .= "\n<!-- {$comment} -->\n";
        }

        $output .= '<style>' . $minifier->minify() . '</style>' . "\n";

        return $output;
    }

    public function js(string $filePath, string $comment = '')
    {
        if (!is_file($filePath)) {
            return ''; // Handle missing file gracefully
        }

        $minifier = new Minify\JS($filePath);

        $output = '';

        if (!empty($comment)) {
            $output .= "\n<!-- {$comment} -->\n";
        }

        $output .= '<script>' . $minifier->minify() . '</script>' . "\n";

        return $output;
    }
}
