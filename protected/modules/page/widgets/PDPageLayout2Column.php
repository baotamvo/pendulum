<?php
/**
 * Date: 3/19/13
 * Class: PDPageLayout2Column
 * Description:
 *
 */
class PDPageLayout2Column extends PDLayoutWidget
{
    protected $leftBlocks,$rightBlocks;

    protected function afterConstruct() {
        $this->leftBlocks  = new CList();
        $this->rightBlocks = new CList();
    }

    public function addLeft($block) {
        $this->leftBlocks->add($block);
        return $this;
    }

    public function addRight($block) {
        $this->rightBlocks->add($block);
        return $this;
    }

    public function addLeftAll($blocks) {
        foreach($blocks as $block) {
            $this->addLeft($block);
        }
        return $this;
    }

    public function addRightAll($blocks) {
        foreach($blocks as $block) {
            $this->addRight($block);
        }
        return $this;
    }

    public function getLeftBlocks() {
        return $this->leftBlocks;
    }

    public function getRightBlocks() {
        return $this->rightBlocks;
    }

}
