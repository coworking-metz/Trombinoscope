<?php

/**
 * Calculate the optimal number of rows and columns for a grid with an aspect ratio of 4/3.
 *
 * @param int $totalUsers Total number of users to display in the grid.
 * @return array Returns an array with the number of rows and columns.
 */

//  function calculateGridDimensions($total) {
//     $colonnes = ceil(sqrt($total));
//     $lignes = ceil($total / $colonnes);

//     return ['colonnes' => $colonnes, 'lignes' => $lignes];
// }

function calculateGridDimensions($total)
{

    if ($total <= 4) {
        return ['colonnes' => 4, 'lignes' => 2];
    }

    if ($total <= 8) {
        return ['colonnes' => 4, 'lignes' => 2];
    }

    if ($total <= 15) {
        return ['colonnes' => 5, 'lignes' => 3];
    }

    if ($total <= 18) {
        return ['colonnes' => 6, 'lignes' => 3];
    }

    if ($total <= 20) {
        return ['colonnes' => 5, 'lignes' => 4];
    }
    if ($total <= 24) {
        return ['colonnes' => 6, 'lignes' => 4];
    }

    if ($total <= 28) {
        return ['colonnes' => 7, 'lignes' => 4];
    }

    if ($total <= 32) {
        return ['colonnes' => 8, 'lignes' => 4];
    }

    if ($total <= 36) {
        return ['colonnes' => 6, 'lignes' => 6];
    }

    if ($total <= 40) {
        return ['colonnes' => 8, 'lignes' => 5];
    }
    return ['colonnes' => 9, 'lignes' => 6];
}


function obtenirDateActuelle()
{
    $date = new DateTime();
    $formatter = new IntlDateFormatter(
        'fr_FR',
        IntlDateFormatter::FULL,
        IntlDateFormatter::NONE,
        'Europe/Paris',
        IntlDateFormatter::GREGORIAN,
        'eeee dd MMMM'
    );
    return ucfirst($formatter->format($date));
}


/**
 * retourne une phrase indiquant une quantité accompagnée d'un libellé texte mis au pluriel
 *
 * @param  mixed $qte La quantité déterminant le pluriel ou nom
 * @param  mixed $lib Le ou les mots suivants à mettre au pluriel (séparés par des espaces)
 * @param  mixed $pluriel La marque du pluriel à appliquer au libellé (défaut: s)
 * @return void
 */
function pluriel($qte, $lib, $pluriel = 's', $separateur = ' ')
{
    if ($qte > 1) {
        $lib = explode($separateur, $lib);
        foreach ($lib as $a => $b) {
            $lib[$a] = $b . $pluriel;
        }
        return $qte . ' ' . implode($separateur, $lib);
    } else {
        return $qte . ' ' . $lib;
    }
}

function url_to_file($url)
{
    if (!$url) return;
    $content = get_content($url);
    if (!$content) return;

    return to_temp_file($content);
}

$GLOBALS['to_temp_file'] = [];
function to_temp_file($data)
{
    $tmpfile = tempnam(sys_get_temp_dir(), 'tmp');
    file_put_contents($tmpfile, $data);
    $GLOBALS['to_temp_file'][] = $tmpfile;
    return $tmpfile;
}

function purge_temp_files()
{
    foreach ($GLOBALS['to_temp_file'] as $file) {
        unlink($file);
    }
}
function get_content($url, $expire = null)
{
    return file_get_contents($url);
}
/**
 * Récupère le contenu d'une image et le met en cache dans un fichier temporaire.
 *
 * @param string $url URL de l'image.
 * @param int|null $expire Durée d'expiration du cache en secondes (null pour pas d'expiration).
 * @return string Contenu de l'image encodé en base64 avec son type MIME.
 */
function get_image_content($url, $expire = null)
{
    $hash = sha1($url);
    $cacheFile = sys_get_temp_dir() . '/local-image-' . $hash;

    // Vérifie si le fichier de cache existe et n'est pas expiré
    if (file_exists($cacheFile)) {
        if ($expire === null || (time() - filemtime($cacheFile)) < $expire) {
            return file_get_contents($cacheFile);
        }
    }

    // Télécharge l'image et encode son contenu
    $content = file_get_contents($url);
    $mimeType = get_mime_type_from_extension($url);
    $base64 = base64_encode($content);
    $content = "data:" . $mimeType . ";base64," . $base64;

    // Sauvegarde le contenu dans le fichier de cache
    file_put_contents($cacheFile, $content);

    return $content;
}


function erreur($code)
{
    noCacheHeaders();
    http_response_code($code);
    die;
}

function get_mime_type_from_extension($url)
{
    $extension = strtolower(pathinfo($url, PATHINFO_EXTENSION));
    $mime_types = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'svg' => 'image/svg+xml'
        // Add more mappings as needed
    ];
    return $mime_types[$extension] ?? 'application/octet-stream'; // Default to binary type if unknown
}
