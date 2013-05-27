<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class PDController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layoutId='page/widgets/layout2Column';
    public $mainLayoutPath='//layouts/main_layout';

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    protected $content, $layoutBlock;

    public function back() {
        if(app()->request->lastUrl)
            $this->redirect(app()->request->lastUrl);
        if(user()->returnUrl)
            $this->redirect(user()->returnUrl);
        return false;
    }

    public function layout() {
        if(!$this->layoutBlock)
            $this->layoutBlock = app()->load($this->layoutId);
        return $this->layoutBlock;
    }

    public function render($view=null,$data=null,$return=false)
    {
        if($this->beforeRender($view))
        {
            if(!$view) return $this->renderText(null,$return);

            $this->layout()->content = $this->content = $output = $this->renderPartial($view,$data,true);
            if($layoutFile=$this->getLayoutFile($this->mainLayoutPath))
                $output=$this->renderFile($layoutFile,array('content'=>$output),true);

            $this->afterRender($view,$output);

            $output=$this->processOutput($output);

            if($return)
                return $output;
            else
                echo $output;
        }
    }

    public function renderText($text,$return=false)
    {
        $this->layout()->content = $this->content = $text;
        if($layoutFile=$this->getLayoutFile($this->mainLayoutPath))
            $text=$this->renderFile($layoutFile,array('content'=>$text),true);

        $text=$this->processOutput($text);

        if($return)
            return $text;
        else
            echo $text;
    }

    public function getContent() {
        return $this->content;
    }

    public function post($name=null,$default=null) {
        return $name ? app()->request->getPost($name,$default) : $_POST;
    }

}