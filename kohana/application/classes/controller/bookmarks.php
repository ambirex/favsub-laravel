<?php

class Controller_Bookmarks extends Controller {

	public $user = FALSE;
	public $title = FALSE;
	
	public function before()
	{
		$this->user = Auth::instance()->get_user();
	}
	
	public function action_index()
	{
		$query = array();
		
		if(isset($_GET['q']))
		{
			if( ! empty($_GET['q']))
			{
				$query['text'] = $_GET['q'];
			}
		}
		
		$page = 1;
		if(isset($_GET['page']))
		{
			$req_page = (int) $_GET['page'];
			if($req_page > 0)
			{
				$page = $req_page;
			}
		}
		
		$this->show_bookmarks($query, $page);
	}
	
	public function show_bookmarks($query = array(), $page = 1)
	{	
		$do_process = FALSE;
		if(false != $this->user)
		{
			if(4 == $this->user->id)
			{
				$do_process = TRUE;
			}
		}
		
		$query['logged_in'] = $do_process;
		$bookmarks = Model_Item::lookup($query, $page);
		
		//$view = new View('bookmarks');
		//$view->bookmarks = $bookmarks;
		//
		
		
		$view = new View('template');
		if($this->title != FALSE)
		{
			$view->title = $this->title;
		}
		$view->logged_in = $do_process;
		
		$view->follow_noindex = true;
		$view->body = new View('bookmark_list');
		$view->body->do_process = $do_process;
		$view->body->bookmarks = $bookmarks;
		
		$pagination = new Pagination(array(
			'total_items' => $bookmarks['item_found_count'], 
			'items_per_page' => 25,  // set this to 30 or 15 for the real thing, now just for testing purposes...

			'auto_hide' => false, 
			'view' => 'pagination/favsub'
		));
		
		$view->body->paging = $pagination;
		
		$view->body->curr_page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		$tags = Model_Tag::get_tag_list(45);
		$view->tags = $tags;
		
		echo $view;
	}
	
	public function action_tag($tag_name = false)
	{
		if($tag_name === false)
		{
			$this->request->redirect('bookmarks');
		}
		
		$tag_id = Model_Tag::get_id($tag_name);
		
		if($tag_id === false)
		{
			$this->request->redirect('bookmarks');
		}
		
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		$this->title = $tag_name . ' Bookmarks :: FavSub Viewer';
		$this->show_bookmarks(array('tag_id' => $tag_id), $page);
	}
	
	public function action_tagless()
	{
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		$this->show_bookmarks(array('tagless' => 1), $page);
	}
	
	public function action_on_time($time = false)
	{
		$time = preg_split('/:/', $time);
		
		if(count($time) != 2)
		{
			$this->request->redirect('bookmarks');
		}
		
		$this->show_bookmarks(array('time' => array('h' => (int) $time[0], 'm' => (int) $time[1])));
		
	}
	
	public function action_tags()
	{
		$tags = Model_Tag::get_simple_list();
		echo json_encode($tags);
	}
	
	public function action_edit($item_id = 0)
	{
		/*
		$user = Auth::instance()->get_user();
		echo '<pre>'; print_r($user); echo '</pre>';
		*/
		$orig_item_id = $item_id;
		$item_id = (int) $item_id;
		$show_ad = FALSE;
		$ad_enabled_ids = array(
			16504,
			12725,
			18174,
			9796,
			17838,
		);

		if(in_array($item_id, $ad_enabled_ids)) {
			$show_ad = TRUE;
		}

		$show_ad = TRUE;
		
		if($item_id == 0)
		{
			$this->request->redirect('bookmarks');
		}
		
		$do_process = FALSE;
		if(FALSE != $this->user)
		{
			if(4 == $this->user->id)
			{
				$do_process = TRUE;
			}
		}
			
		if($this->request->method() == 'POST')
		{
			if(FALSE === $do_process)
			{
				$this->request->redirect('bookmarks/edit/'.$item_id);
			}
			
			$this->process_edit($item_id);
		}
		
		$bookmarks = Model_Item::lookup(array('id' => $item_id, 'logged_in' => $do_process));
		$tags = Model_Tag::get_simple_list();
		
		//echo "<pre>"; print_r($this->request->method()); echo "</pre>";
		
		$view = new View('template');
		$view->logged_in = $do_process;
		
		$view->js_files = array('js/tagit/autocomplete.js', 'js/tagit/tagit.js', 'js/tagit/tagit.init.js');
		$view->css_files = array('css/tagit/tagit-simple-blue.css');
		
		$diffbot = false;
		
		if(!isset($bookmarks['items'][$item_id]))
		{
			$this->request->redirect('/bookmarks', 301);
		}
		
		$bookmark = $bookmarks['items'][$item_id];
		
		$related = array('items' => array(), 'urls' => array());
		if(is_array($bookmark['tags']))
		{
			foreach($bookmark['tags'] as $tag_id => $tag)
			{
				$found_not_me = false;
				$rbookmarks = Model_Item::lookup(array('tag_id' => $tag_id, 'not_id' => $item_id, 'logged_in' => $do_process), 1, 1);
				if(count($rbookmarks['items']) > 0)
				{
					$ritem = array_shift($rbookmarks['items']);
					$ritem_id = $ritem['id'];
					$related['items'][$ritem_id] = $ritem;
					foreach($rbookmarks['urls'] as $rurl)
					{
						$rurl_id = $rurl['id'];
						$related['urls'][$rurl_id] = $rurl;
					}
				}
			}
		}
		
		$correct_item_id = $item_id.'-'.URL::title($bookmark['title_full']);
		if($orig_item_id != $correct_item_id) {
			$this->request->redirect('/bookmarks/edit/'.$correct_item_id, 301);
		}
		
		if(isset($bookmarks['items'][$item_id]))
		{
			$url = (isset($bookmarks['urls'][$bookmark['item_url_id']])) ? $bookmarks['urls'][$bookmark['item_url_id']]['url'] : false;
			if($url)
			{
				$diffbot = Diffbot::get($url);
			}			
		}
		
		/*
		$feedArray = Zend_Feed::findFeeds('http://bhiv.com/');
		echo '<pre>'; print_r($feedArray); echo '</pre>';
		*/
		
		/*
		if(isset($diffbot['result']->text))
		{
			$apikey = "xyg77kpjkhstwpke2yhmwg4b";
			$oc = new OpenCalais($apikey);
			
			$entities = $oc->getEntities($diffbot['result']->text);
			
			echo '<pre>'; print_r($entities); echo '</pre>';
		}
		*/
		
		$view->title = $bookmark['title_full'] . ' :: FavSub Viewer';
		if(FALSE === $do_process)
		{
			$view->body = new View('bookmark_edit_view_only');
		}
		else
		{
			$view->body = new View('bookmark_edit');
		}
		

		$view->body->show_ad = $show_ad;
		$view->body->bookmarks = $bookmarks;
		$view->body->related = $related;
		$view->body->tags = $tags;
		$view->body->referrer = $this->request->referrer();
		$view->body->diffbot = $diffbot;
		
		echo $view;
	}
	
	public function process_edit($item_id)
	{
		$bookmarks_tags = (isset($_POST['bookmark_tags'])) ? $_POST['bookmark_tags'] : array();
		$result = Model_Item::edit(
						$item_id,
						$_POST['title'],
						$_POST['url'],
						$bookmarks_tags,
						$_POST['content']
					);
					
		if( ! empty($_POST['return_url']))
		{
			$this->request->redirect($_POST['return_url']);
		}
		
		$this->request->redirect('bookmarks');
	}
	
	public function action_add($from_special = false)
	{
		$cleaned_input = $_GET;
		if( ! isset($_GET['url']))
		{
			die();
		}
		
		if(empty($_GET['url']))
		{
			die();
		}
		
		$add_tags = array();
		
		if($from_special)
		{
			if($from_special == 'greader' || $from_special == 'greader-later')
			{
				$data = array(
					'url' => $_GET['url'],
					'title' => $_GET['title'],
					'content' => '',
				);

				if(isset($_GET['s'])) {
					$data['content'] = "From Google Reader - source: ".$_GET['s'];
				}

				if(isset($_GET['e'])) {
					$data['content'] = $_GET['e'];
				}
				
				$add_tags[] = 'Google Reader';
			}
			
			if($from_special == 'greader-later')
			{
				$add_tags[] = 'Read Later';
			}
		}
		else
		{
			$data = array(
				'url' => $_GET['url'],
				'reference' => $_GET['ref'],
				'title' => $_GET['title'],
				'content' => (isset($_GET['description'])) ? $_GET['description'] : '',
			);
		}
		
		
		
		$new_id = Model_Item::add($data);
		$diffbot = Diffbot::get($data['url']);
		
		if(isset($diffbot['result']))
		{
			if(isset($diffbot['result']->tags))
			{
				foreach($diffbot['result']->tags as $diff_tag)
				{
					$diff_tag = preg_replace('/,/', '', $diff_tag);
					if( ! in_array($diff_tag, $add_tags))
					{
						$add_tags[] = $diff_tag;
					}
				}
			}
		}
		
		foreach($add_tags as $tag)
		{
			Model_Tag::add_member($tag, $new_id);
		}

		$toRedditUrl = 'http://bookmarks.lruf.com//posttit?' . http_build_query(array('url' => $data['url'], 'title' => $data['title']));
		$toRedditResult = file_get_contents($toRedditUrl);
		
		$view = new View('bookmark_add_quick');
		echo $view;
	}

	public function action_addnb()
	{
		if($this->request->method() == 'POST')
		{
			//echo json_encode($_POST);
			$data = array(
					'url' => $_POST['url'],
					'title' => $_POST['title'],
					'content' => $_POST['content'],
				);

			$new_id = Model_Item::add($data);
			if(isset($_POST['tags'])) {
				foreach($_POST['tags'] as $tag)
				{
					Model_Tag::add_member($tag, $new_id);
				}
			}

			$toRedditUrl = 'http://ras6.com/posttit?' . http_build_query(array('url' => $data['url'], 'title' => $data['title']));
			$toRedditResult = file_get_contents($toRedditUrl);

			echo json_encode(array('response' => 'ok'));
		}
	}
	
	public function action_delete($item_id = 0)
	{
		$item_id = (int) $item_id;
		if($item_id == 0)
		{
			$this->request->redirect('bookmarks');
		}
		
		$do_process = FALSE;
		if(false != $this->user)
		{
			if(4 == $this->user->id)
			{
				$do_process = TRUE;
			}
		}
		else
		{
			$this->request->redirect('bookmarks/edit/'.$item_id, 301);
		}
		
		if($this->request->method() == 'POST')
		{
			if(false === $do_process) {
				$this->request->redirect('bookmarks');
			}
			
			$this->process_delete($item_id);
		}
		
		$bookmarks = Model_Item::lookup(array('id' => $item_id, 'logged_in' => $do_process));
		$tags = Model_Tag::get_simple_list();
		
		$view = new View('template');
		$view->logged_in = $do_process;
		
		$view->body = new View('bookmarks_delete');
		$view->body->bookmarks = $bookmarks;
		$view->body->tags = $tags;
		$view->body->referrer = $this->request->referrer();
		
		echo $view;
	}
	
	public function process_delete($id)
	{
		Model_Tag::clear_member_tags($id);
		Model_Item::delete($id);
		
		if( ! empty($_POST['return_url']))
		{
			$this->request->redirect($_POST['return_url']);
		}
		
		$this->request->redirect('bookmarks');
	}
	
	public function action_addq($from_special = false)
	{
		$add_tags = array();
		
		if($from_special)
		{
			if($from_special == 'greader' || $from_special == 'greader-later')
			{
				$data = array(
					'url' => $_GET['url'],
					'title' => $_GET['title'],
					'content' => "From Google Reader - source: ".$_GET['s'],
				);
				
				$add_tags[] = 'Google Reader';
			}
			
			if($from_special == 'greader-later')
			{
				$add_tags[] = 'Read Later';
			}
		}
		else
		{
			$data = array(
				'url' => $_GET['url'],
				'reference' => $_GET['ref'],
				'title' => $_GET['title'],
				'content' => $_GET['description'],
			);
		}
		
		
		
		//$new_id = Model_Item::add($data);
		$new_id = 0;
		
		$tags = Model_Tag::get_simple_list();
		
		$view = new View('template_simple');
		$view->js_files = array('js/tagit/autocomplete.js', 'js/tagit/tagit.js', 'js/tagit/tagit.init.js');
		$view->css_files = array('css/tagit/tagit-simple-blue.css');
		
		$view->body = new View('bookmark_add_w_tags');
		$view->body->tags = $tags;
		$view->body->add_tags = $add_tags;
		$view->body->new_id = $new_id;
		
		echo $view;
	}
	
	public function action_openc()
	{
		$data = file_get_contents( Kohana::find_file('vendor', 'openc.sample') );
		
		$xml = simplexml_load_string($data);
		
		foreach($xml->CalaisSimpleOutputFormat[0] as $key => $value)
		{
			echo '<pre>'; print_r($key); echo '</pre>';
			echo '<pre>'; print_r($value); echo '</pre>';
		}
	}
	
	public function action_sitemap()
	{
		$cache = Cache::instance();
		//43200
		
		if($response = $cache->get('sitemap-bookmarks') === NULL)
		{
			$sitemap = new Sitemap;
			
			$bookmarks = Model_Item::lookup(array(), 1, 300);
			//echo '<pre>'; print_r($bookmarks); echo '</pre>';
			
			foreach($bookmarks['items'] as $item)
			{
				$url = new Sitemap_URL;
	
				// Set arguments.
				$url->set_loc('http://favsub.com/bookmarks/edit/'.$item['id'].'-'.URL::title($item['title_full']))
					->set_last_mod(strtotime($item['entered_date']))
					->set_change_frequency('weekly')
					->set_priority(0.3);
				
				// Add it to sitemap.
				$sitemap->add($url);
			}
	
			 // Render the output.
			$response = $sitemap->render();
		
			// Cache the output for 6 hours.
			$cache->set('sitemap', $response, 21600);			
		}
		
		echo $response;
	}

	public function action_twfeed()
	{
		$bookmarks = Model_Item::lookup(array(), 1, 20);

		$items = array();
		foreach ($bookmarks['items'] as $item_id => $item) {
			$desc_strlen = 0;
			$hastags = array();

			foreach($item['tags'] as $tag) {
				$tag = '#'.URL::title($tag['name'], '');

				// Skip the googlereader tag
				if($tag == '#googlereader') {
					continue;
				}

				if(strlen($tag) > 15) {
					continue;
				}

				$tag_strlen = strlen($tag);
				$newlen = $tag_strlen + $desc_strlen;
				if($newlen < 50) {
					$hastags[] = $tag;
					$desc_strlen = $newlen + 1;
				}
			}

			$link_url = $bookmarks['urls'][$item['item_url_id']]['url'];
			if(stripos($link_url, '//news.ycombinator.com')) {
				continue;
			}

			$items[] = array(
				'title' => HTML::entities(Text::limit_chars($item['title_short'], 50)),
				'link' => htmlspecialchars($link_url),
				'description' => implode(' ', $hastags),
				'pubDate' => gmdate( 'D, d M Y H:i:s +0000', strtotime($item['entered_date'])),
			);
		}
		
		echo Feed::create(array('title' => 'Twitter Bookmark Feed', 'generator' => 'FavSub', 'link' => 'http://www.favsub.com/bookmarks'), $items);
	}
	
	public function action_alc() {
		$alc = new Alchemy;
		//$result = $alc->get_story_entities(17004);
		$diffbot = Diffbot::get('http://smashinghub.com/beware-of-the-tricks-used-by-clients-to-manipulate-freelancers.htm');
		echo '<pre>'; print_r($diffbot); echo '</pre>';
	}

	public function action_imgtest()
	{
		//$img = Image::factory('http://bhiv.com/wp-content/uploads/2006/05/time-management.jpg');
	}
}