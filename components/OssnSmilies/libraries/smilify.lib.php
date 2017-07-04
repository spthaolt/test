<?php
/* File:        smilify.lib.php
 * Version:     20150212_0001
 */
function smilify($text) {

    $icon = ossn_site_url() . 'components/OssnChat/images/emoticons/';
    
    $ascii_pattern = array(
            ':(' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-sad.gif' />",
            ':)' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-smile.gif' />",
            '=D' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-happy.gif' />",
            ';)' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-wink.gif' />",
            ':p' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-tongue.gif' />",
            '8|' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-sunglasses.gif' />",
            'o.O' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-confused.gif' />",
            ':O' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-gasp.gif' />",
            ':*' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-kiss.gif' />",
            'a:' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-angel.gif' />",
            ':h:' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-heart.gif' />",
            '3:|' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-devil.gif' />",
            'u:' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-upset.gif' />",
            ':v' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-pacman.gif' />",
            'g:' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-grumpy.gif' />",
            '8)' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-glasses.gif' />",
            'c:' => "<img class='ossn-smiley-item' src='{$icon}ossnchat-cry.gif' />"
    );


    foreach($ascii_pattern as $smiley=>$image) {
        $smiley = preg_quote($smiley);
        $text = preg_replace("~\b$smiley\b~",$image,$text);
    }    
    
    return $text;
}


