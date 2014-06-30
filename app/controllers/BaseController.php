<?php

class BaseController extends Controller {

    public function __construct()
    {
        Validator::extend('skinmimes', function($attribute, $value, $parameters)
            {
                $allowed = array('audio/mpeg', 'image/jpeg', 'application/ogg', 'audio/wave', 'audio/aiff', 'image/png', 'text/plain');
                $mime = new MimeReader($value->getRealPath());
                return in_array($mime->get_type(), $allowed);
            });
    }
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}