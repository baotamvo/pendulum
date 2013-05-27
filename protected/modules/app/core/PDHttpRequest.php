<?php

/**
 * Description of PDHttpRequest
 *
 * @author BaoTam Vo
 */
class PDHttpRequest extends CHttpRequest {
    public $returnUrlParam = '_return_url';

    public function getLastUrl() {
        $lastUrl = $this->getUrlReferrer();
        $urlInfo = parse_url($lastUrl);
        if(!$this->getIsHostInternal($urlInfo['host'])) {
            if($this->getUrl() == $urlInfo['path']) {
                if($returnUrl = $this->getParam($this->returnUrlParam))
                    return $this->decodeUrl($returnUrl);
                return null;
            }
        }
        return $lastUrl;
    }

    public function getIsHostInternal($host) {
        return !$host || ($host == $this->getBaseUrl(true)) || ($host == $this->getBaseUrl(false));
    }

    public function encodeUrl($url) {
        return base64_encode($url);
    }

    public function decodeUrl($url) {
        return base64_decode($url);
    }

}

?>
