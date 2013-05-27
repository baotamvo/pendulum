<?php

/**
 * Description
 *  
 */
$urls = app()->urls->getAll();
echo '<ul>';
foreach($urls as $url) {
    echo '<p><li>'.$url->toHtml().'</li></p>';
}
echo '</ul>';
?>
