<?php
$leftBlocks  = $this->leftBlocks;
$rightBlocks = $this->rightBlocks;
?>
<div class="span3 left-col">
    <?php
    foreach($leftBlocks as $leftBlock) {
        $leftBlock->run();
    }
    ?>
</div>
<div class="span9 right-col">
    <?php echo $this->content ?>
    <?php
    foreach($rightBlocks as $rightBlock) {
        $rightBlock->run();
    }
    ?>
</div>
