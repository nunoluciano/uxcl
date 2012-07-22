<?php

eval('

    function ' . $mydirname . '_global_search($keywords, $andor, $limit, $offset, $userid)
    {
        return none_global_search_base("' . $mydirname . '", $keywords, $andor, $limit, $offset, $userid);
    }

');


if (!function_exists('none_global_search_base')) {

    require_once XOOPS_ROOT_PATH . '/class/template.php';

    function none_global_search_base($mydirname, $keywords, $andor, $limit, $offset, $userid)
    {
        // not implemented for uid specifications
        //if ! empty($userid)) {
        //return array();
        //}

        $chandler =& xoops_gethandler('config');
        $config =& $chandler->getConfigsByDirname($mydirname);
        $config['dirname'] = $mydirname;
        if (empty($config['search_comment'])) {
            $config = array();
        }
        $tpl = new Legacy_XoopsTpl();
        $tpl->assign('config', $config);
        $content = strip_tags($tpl->fetch("db:{$mydirname}_index.tpl"));

        if (!is_array($keywords)) {
            $keywords = array();
        }
        if (strtolower($andor) === 'exact') {
            $keyword = current($keywords);
            if (false !== mb_stripos($content, $keyword)) {
                $found = true;
            } else {
                $found = false;
            }
        } else {
            $found = 0;
            foreach ($keywords as $keyword) {
                if (false !== mb_stripos($content, $keyword)) {
                    $found++;
                }
            }
            if ($found > 0) {
                if (strtolower($andor) === 'or') {
                    $found = true;
                } else if ((strtolower($andor) === 'and') and ($found == count($keywords))) {
                    $found = true;
                } else {
                    $found = false;
                }
            } else {
                $found = false;
            }
        }

        // get time from tpl_lastmodified.
        if ($found) {
            $db =& Database::getInstance();
            $sql = <<<SQL_DESU
SELECT tpl_lastmodified FROM {$db->prefix('tplfile')} WHERE tpl_file = '{$mydirname}_index.tpl' ORDER BY tpl_lastmodified DESC
SQL_DESU;

            $result = $db->query($sql, 1);
            $time = array_pop(array_values($db->fetchRow($result)));
            unset($result);
        }
        if (empty($time)) {
            $time = null;
        }

        // XOOPS Search module
        $showcontext = empty($_GET['showcontext']) ? false : true;
        if ($showcontext && $found) {
            $context = str_replace(array("\r", "\t", "\f"), ' ', $content);
            $context = trim(preg_replace('/\n\s*\n/', "\n", $context));
            $context = search_make_context($context, $keywords);
        } else {
            $context = '';
        }

        $ret = array(
                     array(
                           'link' => 'index.php',
                           'title' => $mydirname,
                           'time' => $time,
                           'uid' => null,
                           'context' => $context,
                           )
                     );
        return $found ? $ret : array();
    }

}
