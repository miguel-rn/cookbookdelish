<?php

namespace App\Controllers;

class User extends BaseController
{
    public function saved()
    {
    }

    public function account()
    {
        $this->data['page_title'] = 'Account Settings';
        $view = view('account');
        //loading the view prior to passing it to the parser for rendering is required so that the parser works properly.
        //Just passing the view to the parser via the render($view) function will not work as expected.
        return $this->parser->setData($this->data)->renderString($view);
    }
}
