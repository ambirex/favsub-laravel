<?php

require_once dirname(__FILE__) . '/../Apache/Solr/Service.php';

class Controller_Solr extends Controller {

	public function action_index()
	{
		$solr = new Apache_Solr_Service( 'search.malk.com', '8080', '/solr/bookmarks' );
		$solr->setAuthenticationCredentials("malksolr", "m1lks0lr$");
		
		
		$bookmarks = Model_Item::lookup(array(), 1);
		
		$documents = array();
		
		foreach($bookmarks['items'] as $item)
		{
			$doc = new Apache_Solr_Document();
			$doc->id = $item['id'];
			$doc->title = $item['title_full'];
			
			$documents[] = $doc;
		}
		
		try {
			//$solr->addDocuments( $documents );
			$solr->deleteByQuery('id:*');
			$solr->commit();
			$solr->optimize();
		}
			catch ( Exception $e ) {
			echo $e->getMessage();
		}
		
		//$doc = new Apache_Solr_Document();
	}
}