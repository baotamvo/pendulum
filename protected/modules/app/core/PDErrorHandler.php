<?php

/**
 * Description
 *  
 */
class PDErrorHandler extends CErrorHandler {
    
    
    /**
	 * Handles the exception/error event.
	 * This method is invoked by the application whenever it captures
	 * an exception or PHP error.
     * <br>
     * This method differs from the original that comes with Yii in that it won't set content-encoding to none,
     * thus preventing the encoding from breaking the response text if the server uses gzip encoding.
	 * @param CEvent $event the event containing the exception/error information
	 */
	public function handle($event)
	{
		// set event as handled to prevent it from being handled by other event handlers
		$event->handled=true;

		if($this->discardOutput)
		{
			// the following manual level counting is to deal with zlib.output_compression set to On
			for($level=ob_get_level();$level>0;--$level)
			{
				@ob_end_clean();
			}
            // comment this out to prevent the encoding from breaking the page content
			//header("Content-Encoding: ", true);
		}

		if($event instanceof CExceptionEvent)
			$this->handleException($event->exception);
		else // CErrorEvent
			$this->handleError($event);
	}

}
?>
