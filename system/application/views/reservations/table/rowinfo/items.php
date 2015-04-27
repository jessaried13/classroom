<?php
$url = site_url('items/info/'.$school_id.'/'.$item_id);
$title = '<a onclick="window.open(\''.$url.'\',\'\',\'width='.$itemtitle['width'].',height=360,scrollbars\');return false;" href="'.$url.'" title="View More Information" '.$itemtitle['event'].'>'.$name.'</a>'."\n";
?>
<td align="center" valign="middle" width="100"><br />
<strong><?php echo $item_group_name ?> - <?php echo $location ?></strong><br />
<span style="font-size:90%"><?php echo ($displayname == '') ? $username : $displayname; ?>&nbsp;</span>
</td>
