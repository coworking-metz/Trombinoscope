<?php 
class Svg {
/**
 * Output the symbol definitions from all SVG files in the specified folder.
 * Each symbol's ID will be set as the file's slug.
 */
public static function defs() {
    $directory = CHEMIN_SITE.'/images';
    $files = glob($directory . '/*.svg');
    $ret= '<svg style="display:none"><defs>';
    foreach ($files as $file) {
        $slug = basename($file, '.svg');
        $svgContent = file_get_contents($file);
        // Remove XML tags
        $svgContent = preg_replace('/<\?xml.*?\?>/', '', $svgContent);
        $svgContent = preg_replace('/<svg(.*?)>/', '<symbol id="' . $slug . '"$1>', $svgContent);
        $svgContent = str_replace('</svg>', '</symbol>', $svgContent);
        $ret .= $svgContent;
    }
    $ret.='</defs></svg>';

    return $ret;
}

    /**
     * Output the SVG code referencing the specific definition identified by the slug.
     * The SVG output will include the original viewBox.
     * 
     * @param string $slug The identifier for the specific SVG.
     */
    public static function get($slug) {
        $file = "./images/{$slug}.svg";
        if (file_exists($file)) {
            $svgContent = file_get_contents($file);
            $xml = new SimpleXMLElement($svgContent);
            $viewBox = $xml['viewBox'] ? 'viewBox="' . $xml['viewBox'] . '"' : '';
            echo "<svg id='svg-{$slug}' {$viewBox}><use xlink:href='#{$slug}'></use></svg>";
        } else {
            echo "SVG file not found.";
        }
    }
}

