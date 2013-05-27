<?php
/**
 * Date: 3/17/13
 * Class: PDPageHeadWidget
 * Description:
 *
 */
class PDPageHeadWidget extends PDWidget
{
    public function getTitle() {
        return app()->html->encode($this->owner->pageTitle);
    }

    public function getCss($relPath) {
        return $this->getPublicItem('css/',$relPath);
    }

    public function getJs($relPath) {
        return $this->getPublicItem('js/',$relPath);
    }

    public function getPublicItem($folder,$relPath) {
        return
            $this->appendPath(app()->request->baseUrl,$this->appendPath($folder,$relPath));
    }

    public function getThemeItem($folder,$relPath) {
        return
           app()->theme->getPubUrl($this->appendPath($folder,$relPath));
    }

    public function getThemeJs($relPath) {
        return $this->getThemeItem('js/',$relPath);
    }

    public function getThemeCss($relPath) {
        return $this->getThemeItem('css/',$relPath);
    }

    public function appendPath($basePath,$appendedPath) {
        return app()->load('models/url')->appendPath($basePath,$appendedPath);
    }

}
