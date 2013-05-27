<?php
/**
 * Date: 3/30/13
 * Class: PDTheme
 * Description:
 *
 */
class PDTheme extends CTheme
{
    public function getPubUrl($relPath) {
        $path = $this->appendPath(app()->request->baseUrl,$this->baseUrl);
        $path = $this->appendPath($path,'/pub/');
        $path = $this->appendPath($path,$relPath);
        return $path;
    }

    protected function appendPath($base,$append) {
        return app()->load('models/url')->appendPath($base,$append);
    }
}
