<?php
/**
 * Date: 3/20/13
 * Class: PDLayoutWidget
 * Description:
 *
 */
class PDLayoutWidget extends PDWidget {
    public $content;
    public $htmlBlock;

    public function setHtmlBlockId($id) {
        $this->htmlBlock = app()->load($id);
    }

    public function renderLayout() {
        $this->htmlBlock->getChild('body')->setChild('content',$this);
        $this->htmlBlock->run();
    }
}
