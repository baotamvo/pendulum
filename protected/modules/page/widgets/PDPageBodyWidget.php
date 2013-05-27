<?php
/**
 * Date: 3/19/13
 * Class: PDPageBodyWidget
 * Description:
 *
 */
class PDPageBodyWidget extends PDWidget
{
    protected $_content;

    public function setContent($content) {
        $this->_content = $content;
    }

    public function getContent() {
        if(!$this->_content)
            return $this->owner->content;
        return $this->_content;
    }
}
