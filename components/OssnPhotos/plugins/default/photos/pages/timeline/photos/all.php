<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

$albums = new OssnAlbums;
$photos = $albums->GetUserTimelinePhotos($params['user']->guid, "user");
echo '<div class="ossn-photos">';
echo '<h2>' . ossn_print('timeline:photos') . '</h2>';
if ($photos) {
    foreach ($photos as $photo) {
        $imagefile = str_replace('ossnwall/images/', '', $photo->value);
        $image = ossn_site_url() . "album/getphoto/{$photo->guid}/{$imagefile}?size=larger&type=timeline";
        $view_url = ossn_site_url() . 'photos/timeline/view/' . $photo->guid;
        echo "<li><a href='{$view_url}'><img src='{$image}'  class='pthumb'/></a></li>";
    }
}
echo ossn_view_pagination(count((array)$photos));
