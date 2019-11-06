<?php


class Controller_V2 extends Controller {

	public function action_index()
	{
		$this->request->redirect('bookmarks', 301);
	}
	
	public function __call($method, $args)
	{
		$this->request->redirect('bookmarks', 301);
	}
	
	
}