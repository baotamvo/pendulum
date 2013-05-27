<?php
$urls = array(
    'viewJobPositionPage',
    'viewJobPostingFieldPage',
    'viewJobPostingFormPage',
    'viewJobPostingPage',
);
?>

<h3>
    <p>Welcome testers!</p>
</h3>
<h5>
    <p>Please follow the below urls. They will lead you to the available service packages</p>
</h5>
<?php
echo '<ul>';
foreach($urls as $url) {
    echo '<p><li>'.app()->urls->get($url)->toHtml().'</li></p>';
}
echo '</ul>';
?>
