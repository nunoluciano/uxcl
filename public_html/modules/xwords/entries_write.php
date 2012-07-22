<?php
// xpwikiから　xwordへの自動リンクを貼るための、アドオン
// see http://xoops.hypweb.net/modules/forum/index.php?topic_id=2140
// ディレクトリをuploads以下に変更、タイトルファイル名を変更
// 小文字・大文字を区別しない？ (0 or 1)
define('PAGE_CASE_INSENSITIVE', 0);

if (!defined('XOOPS_ROOT_PATH') || !is_object($xoopsModule)) {
	exit();
}

$temp_txt = XOOPS_ROOT_PATH."/uploads/".$xoopsModule->dirname()."/entries_temp.php";
$entries_dat = XOOPS_ROOT_PATH."/uploads/".$xoopsModule->dirname()."/entries.php";
 
 
if ($fp1 = fopen($temp_txt, 'wb')) {
    $result_entries = $xoopsDB -> query( "SELECT term FROM $ent_table" );
    while ( list( $entry_term ) = $xoopsDB -> fetchrow( $result_entries ) ) {
        if(mb_strlen($entry_term)>2) {fwrite($fp1, $entry_term."\n");
        }
    }
    fclose($fp1);
}
 
$dats = file($temp_txt);
$dat = get_matcher_regex_safe($dats);
if ($fp2 = fopen($entries_dat, 'wb')) {
    fwrite($fp2, $dat);
    fclose($fp2);
}
 
function get_matcher_regex_safe ($pages, $spliter = "\t", $array_fix = true, $nest = 0) {
    if ($array_fix) {
        $pages = array_map('trim', $pages);
        if (PAGE_CASE_INSENSITIVE) $pages = array_map('strtolower', $pages);
        $pages = array_unique($pages);
        foreach(array_keys($pages, '') as $key) {
            unset($pages[$key]);
        }
        sort($pages, SORT_STRING);
    }
    
    ++$nest;
    $reg = get_matcher_regex_safe_sub($pages);
    $regs = preg_split("/(\d+)\x08/", $reg, -1, PREG_SPLIT_DELIM_CAPTURE);
    $pats = array();
    $index = 0;
    reset($regs);
    while (list($key, $pat) = each($regs)) {
        list($key, $val) = each($regs);
        if (!$val) $val = count($pages);
        if (@ preg_match('/' . $pat. '/', '') === false) {
            if ($nest <= 10) {
                $count = $val - $index;
                $split = floor(($val - $index) / 2);
                $pages1 = array_slice($pages, $index, $split);
                $pages2 = array_slice($pages, $split, $count - $split);
                $pats[] = get_matcher_regex_safe($pages1, $spliter, false, $nest);
                $pats[] = get_matcher_regex_safe($pages2, $spliter, false, $nest);
                $index = $val;
            }
        } else {
            $pats[] = $pat;
        }
    }
    return join($spliter, $pats);
}
 
function get_matcher_regex_safe_sub (& $array, $offset = 0, $sentry = NULL, $pos = 0, $nest = 0)
{
    static $g_count = 0;
    
    ++$nest;
    $limit = 1024 * 32 - 10;
    
    if (empty($array)) return '(?!)'; // Zero
    if ($sentry === NULL) $sentry = count($array);
    
    // Too short. Skip this
    $skip = ($pos >= mb_strlen($array[$offset]));
    if ($skip) ++$offset;
 
    // Generate regex for each value
    $regex = '';
    $index = $offset;
    $multi = FALSE;
    $reglen = 0;
    while ($index < $sentry) {
        if ($index != $offset) {
            $multi = TRUE;
            if ($nest === 1 && strlen($regex) - $reglen > $limit) {
                $reglen = strlen($regex);
                $regex .= ')'.($index)."\x08(?:";
                $g_count = 1;
            } else {
                $regex .= '|'; // OR
            }
        }
 
        // Get one character from left side of the value
        $char = mb_substr($array[$index], $pos, 1);
 
        // How many continuous keys have the same letter
        // at the same position?
        for ($i = $index; $i < $sentry; $i++)
            if (mb_substr($array[$i], $pos, 1) != $char) break;
        
        if ($index < ($i - 1)) {
            // Some more keys found
            // Recurse
            $regex .= str_replace(' ', '\\ ', preg_quote($char, '/')) .
            get_matcher_regex_safe_sub($array, $index, $i, $pos + 1, $nest);
        } else {
            // Not found
            $regex .= str_replace(' ', '\\ ',
            preg_quote(mb_substr($array[$index], $pos), '/'));
        }
        $index = $i;
    }
    
    if ($skip || $multi){
        $g_count++;
        $regex = '(?:' . $regex . ')';
    }
    if ($skip) $regex .= '?'; // Match for $pages[$offset - 1]
    return $regex;
}
 
?>
