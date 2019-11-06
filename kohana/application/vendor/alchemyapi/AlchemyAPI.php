<?php
/*
 *    AlchemyAPI Functions
 *
 */


class AlchemyAPI_Params{
	private $url = null;
	private $html = null;
	private $text = null;
	private $outputMode = "xml";
	private $customParameters = null;
	
	private function outputMode_arr()
	{
		return array
		(
			'xml',
			'json'
		);
	} 
	
	public function getUrl(){
		return $this->url;
	}

	public function setUrl($url){
		$this->url = $url;
	}
	
	public function getHtml(){
		return $this->html;
	}

	public function setHtml($html){
		$this->html = $html;
	}
	
	public function getText(){
		return $this->text;
	}

	public function setText($text){
		$this->text = $text;
	}
	
	public function getOutputMode(){
		return $this->outputMode;
	}
	
	public function resetBaseParams() {
		unset($this->url);
		unset($this->html);
		unset($this->text);
	}

	public function setOutputMode($outputMode){
		$arr = $this->outputMode_arr();
		$isValid = false;
		for($i=0;$i<count($arr);$i++){
			if($arr[$i] == $outputMode){
				$this->outputMode = $outputMode;
				return;
			}
		}
		if (!$isValid)
		{
			throw new Exception("Invalid setting (".$outputMode.") for parameter outputMode");
		}
	}
	
	public function getCustomParameters(){
		return $this->customParameters;
	}

	public function setCustomParameters(){
		$this->customParameters = "";
		
		$numargs = func_num_args();
		for($i = 0; $i < $numargs; $i++)
		{
		    $this->customParameters .= "&".func_get_arg($i);
		    if ((++$i) < $numargs)
			$this->customParameters .= "=".rawurlencode(func_get_arg($i));
		}
	}
	
	public function getParameterString() {
		$retString = "";
		$retString = $retString."&outputMode=".$this->outputMode;
		if(isset($this->url))
			$retString=$retString."&url=".rawurlencode($this->url);
		if(isset($this->html))
			$retString=$retString."&html=".rawurlencode($this->html);
		if(isset($this->text))
			$retString=$retString."&text=".rawurlencode($this->text);
		if(isset($this->customParameters))
			$retString=$retString.$this->customParameters;
		return $retString;
	}

}

class AlchemyAPI_NamedEntityParams extends AlchemyAPI_Params{	  

	private $disambiguate = null;
	private $linkedData = null;
	private $coreference = null;
	private $quotations = null;
	private $sourceText = null;
	private $showSourceText = null;
	private $maxRetrieve = null;
	private $baseUrl = null;
	private $cQuery = null;
	private $xPath = null;
	private $sentiment = null;
	
	private function sourceText_arr()
	{
		return array
		(
			'cleaned_or_raw',
			'cleaned',
			'raw',
			'cquery',
			'xpath'
		);
	} 

	public function getDisambiguate(){
		return $this->disambiguate;
	}

	public function setDisambiguate($disambiguate){
		if ($disambiguate != 0 && $disambiguate != 1)
		{
			throw new Exception("Invalid setting (".$disambiguate.") for parameter disambiguate");
		}
		$this->disambiguate = $disambiguate;
	}

	public function getLinkedData(){
		return $this->linkedData;
	}

	public function setLinkedData($linkedData){
		if ($linkedData != 0 && $linkedData != 1)
		{
			throw new Exception("Invalid setting (".$linkedData.") for parameter linkedData");
		}
		$this->linkedData = $linkedData;
	}

	public function getCoreference(){
		return $this->coreference;
	}

	public function setCoreference($coreference){
		if ($coreference != 0 && $coreference != 1)
		{
			throw new Exception("Invalid setting (".$coreference.") for parameter coreference");
		}
		$this->coreference = $coreference;
	}

	public function getQuotations(){
		return $this->quotations;
	}

	public function setQuotations($quotations){
		if ($quotations != 0 && $quotations != 1)
		{
			throw new Exception("Invalid setting (".$quotations.") for parameter quotations");
		}
		$this->quotations = $quotations;
	}
	
	public function getSourceText(){
		return $this->sourceText;
	}

	public function setSourceText($sourceText){
		$arr = $this->sourceText_arr();
		$isValid = false;
		for($i=0;$i<count($arr);$i++){
			if($arr[$i] == $sourceText){
				$this->sourceText = $sourceText;
				return;
			}
		}
		if (!$isValid)
		{
			throw new Exception("Invalid setting (".$sourceText.") for parameter sourceText");
		}
	}

	public function getShowSourceText(){
		return $this->showSourceText;
	}

	public function setShowSourceText($showSourceText){
		if ($showSourceText != 0 && $showSourceText != 1)
		{
			throw new Exception("Invalid setting (".$showSourceText.") for parameter showSourceText");
		}
		$this->showSourceText = $showSourceText;
	}

	public function getMaxRetrieve(){
		return $this->maxRetrieve;
	}

	public function setMaxRetrieve($maxRetrieve){
		$this->maxRetrieve = $maxRetrieve;
	}

	public function getBaseUrl(){
		return $this->baseUrl;
	}

	public function setBaseUrl($baseUrl){
		$this->baseUrl = $baseUrl;
	}
	
	public function getCQuery(){
		return $this->cQuery;
	}

	public function setCQuery($cQuery){
		$this->cQuery = $cQuery;
	}
	
	public function getXPath(){
		return $this->xPath;
	}

	public function setXPath($xPath){
		$this->xPath = $xPath;
	}

        public function getSentiment(){
                return $this->sentiment;
        }

        public function setSentiment($sentiment){
                if ($sentiment != 0 && $sentiment != 1)
                {
                        throw new Exception("Invalid setting (".$sentiment.") for parameter sentiment");
                }
                $this->sentiment = $sentiment;
        }

	

	
	public function getParameterString() {
		$retString = parent::getParameterString();
		if(isset($this->disambiguate))
			$retString=$retString."&disambiguate=".rawurlencode($this->disambiguate);
		if(isset($this->linkedData))
			$retString=$retString."&linkedData=".rawurlencode($this->linkedData);
		if(isset($this->coreference))
			$retString=$retString."&coreference=".rawurlencode($this->coreference);
		if(isset($this->quotations))
			$retString=$retString."&quotations=".rawurlencode($this->quotations);
		if(isset($this->showSourceText))
			$retString=$retString."&showSourceText=".rawurlencode($this->showSourceText);
		if(isset($this->sourceText))
			$retString=$retString."&sourceText=".rawurlencode($this->sourceText);
		if(isset($this->maxRetrieve))
			$retString=$retString."&maxRetrieve=".rawurlencode($this->maxRetrieve);
		if(isset($this->baseUrl))
			$retString=$retString."&baseUrl=".rawurlencode($this->baseUrl);
		if(isset($this->cQuery))
			$retString=$retString."&cquery=".rawurlencode($this->cQuery);
		if(isset($this->xPath))
			$retString=$retString."&xpath=".rawurlencode($this->xPath);
                if(isset($this->sentiment))
                        $retString=$retString."&sentiment=".rawurlencode($this->sentiment);
		return $retString;
	}

}

/* Parameter class for functions URLGetCategory, HTMLGetCategory, TextGetCategory
//
//  See http://www.alchemyapi.com/api/categ/proc.html for detailed parameter descriptions
//
*/
class AlchemyAPI_CategoryParams extends AlchemyAPI_Params{	  

	private $sourceText = null;
	private $cQuery = null;
	private $xPath = null;
	private $baseUrl = null;
	
	private function sourceText_arr()
	{
		return array
		(
			'cleaned_or_raw',
			'cquery',
			'xpath'
		);
	}  
	
	public function getSourceText(){
		return $this->sourceText;
	}

	public function setSourceText($sourceText){
		$arr = $this->sourceText_arr();
		$isValid = false;
		for($i=0;$i<count($arr);$i++){
			if($arr[$i] == $sourceText){
				$this->sourceText = $sourceText;
				return;
			}
		}
		if (!$isValid)
		{
			throw new Exception("Invalid setting (".$sourceText.") for parameter sourceText");
		}
	}

	public function getCQuery(){
		return $this->cQuery;
	}

	public function setCQuery($cQuery){
		$this->cQuery = $cQuery;
	}

	public function getXPath(){
		return $this->xPath;
	}

	public function setXPath($xPath){
		$this->xPath = $xPath;
	}

	public function getBaseUrl(){
		return $this->baseUrl;
	}

	public function setBaseUrl($baseUrl){
		$this->baseUrl = $baseUrl;
	}
	
	public function getParameterString() {
		$retString = parent::getParameterString();
		if(isset($this->sourceText))
			$retString=$retString."&sourceText=".rawurlencode($this->sourceText);
		if(isset($this->cQuery))
			$retString=$retString."&cquery=".rawurlencode($this->cQuery);
		if(isset($this->xPath))
			$retString=$retString."&xpath=".rawurlencode($this->xPath);
		if(isset($this->baseUrl))
			$retString=$retString."&baseUrl=".rawurlencode($this->baseUrl);	
		return $retString;
	}

}

/* Parameter class for functions URLGetLanguage, HTMLGetLanguage, TextGetLanguage
//
//  See http://www.alchemyapi.com/api/lang/proc.html for detailed parameter descriptions
//
*/
class AlchemyAPI_LanguageParams extends AlchemyAPI_Params{	  

	private $sourceText = null;
	private $cQuery = null;
	private $xPath = null;
	
	private function sourceText_arr()
	{
		return array
		(
			'cleaned_or_raw',
			'cleaned',
			'raw',
			'cquery',
			'xpath'
		);
	}  
	
	public function getSourceText(){
		return $this->sourceText;
	}

	public function setSourceText($sourceText){
		$arr = $this->sourceText_arr();
		$isValid = false;
		for($i=0;$i<count($arr);$i++){
			if($arr[$i] == $sourceText){
				$this->sourceText = $sourceText;
				return;
			}
		}
		if (!$isValid)
		{
			throw new Exception("Invalid setting (".$sourceText.") for parameter sourceText");
		}
	}

	public function getCQuery(){
		return $this->cQuery;
	}

	public function setCQuery($cQuery){
		$this->cQuery = $cQuery;
	}

	public function getXPath(){
		return $this->xPath;
	}

	public function setXPath($xPath){
		$this->xPath = $xPath;
	}
	
	public function getParameterString() {
		$retString = parent::getParameterString();
		if(isset($this->sourceText))
			$retString=$retString."&sourceText=".rawurlencode($this->sourceText);
		if(isset($this->cQuery))
			$retString=$retString."&cquery=".rawurlencode($this->cQuery);
		if(isset($this->xPath))
			$retString=$retString."&xpath=".rawurlencode($this->xPath);
		return $retString;
	}

}

/* Parameter class for functions URLGetRankedConcepts, HTMLGetRankedConcepts, TextGetRankedConcepts
//
//  See http://www.alchemyapi.com/api/concept/proc.html for detailed parameter descriptions
//
*/
class AlchemyAPI_ConceptParams extends AlchemyAPI_Params{	  

	private $maxRetrieve = null;
	private $sourceText = null;
	private $showSourceText = null;
	private $cQuery = null;
	private $xPath = null;
	private $linkedData = null;
	
	private function sourceText_arr()
	{
		return array
		(
			'cleaned_or_raw',
			'cleaned',
			'raw',
			'cquery',
			'xpath'
		);
	}    
	
	public function getMaxRetrieve(){
		return $this->maxRetrieve;
	}

	public function setMaxRetrieve($maxRetrieve){
		$this->maxRetrieve = $maxRetrieve;
	}
	
	public function getSourceText(){
		return $this->sourceText;
	}

	public function setSourceText($sourceText){
		$arr = $this->sourceText_arr();
		$isValid = false;
		for($i=0;$i<count($arr);$i++){
			if($arr[$i] == $sourceText){
				$this->sourceText = $sourceText;
				return;
			}
		}
		if (!$isValid)
		{
			throw new Exception("Invalid setting (".$sourceText.") for parameter sourceText");
		}
	}

	public function getShowSourceText(){
		return $this->showSourceText;
	}

	public function setShowSourceText($showSourceText){
		if ($showSourceText != 0 && $showSourceText != 1)
		{
			throw new Exception("Invalid setting (".$showSourceText.") for parameter showSourceText");
		}
		$this->showSourceText = $showSourceText;
	}

	public function getLinkedData(){
		return $this->linkedData;
	}

	public function setLinkedData($linkedData){
		if ($linkedData != 0 && $linkedData != 1)
		{
			throw new Exception("Invalid setting (".$linkedData.") for parameter linkedData");
		}
		$this->linkedData = $linkedData;
	}

	public function getCQuery(){
		return $this->cQuery;
	}

	public function setCQuery($cQuery){
		$this->cQuery = $cQuery;
	}

	public function getXPath(){
		return $this->xPath;
	}

	public function setXpath($xPath){
		$this->xPath = $xPath;
	}

	public function getParameterString() {
		$retString = parent::getParameterString();
		if(isset($this->maxRetrieve))
			$retString=$retString."&maxRetrieve=".rawurlencode($this->maxRetrieve);
		if(isset($this->sourceText))
			$retString=$retString."&sourceText=".rawurlencode($this->sourceText);
		if(isset($this->showSourceText))
			$retString=$retString."&showSourceText=".rawurlencode($this->showSourceText);
		if(isset($this->linkedData))
			$retString=$retString."&linkedData=".rawurlencode($this->linkedData);
		if(isset($this->cQuery))
			$retString=$retString."&cquery=".rawurlencode($this->cQuery);
		if(isset($this->xPath))
			$retString=$retString."&xpath=".rawurlencode($this->xPath);
		return $retString;
	}

}

/* Parameter class for functions URLGetRankedKeywords, HTMLGetRankedKeywords, TextGetRankedKeywords
//
//  See http://www.alchemyapi.com/api/keyword/proc.html for detailed parameter descriptions
//
*/
class AlchemyAPI_KeywordParams extends AlchemyAPI_Params{	  

	private $maxRetrieve = null;
	private $sourceText = null;
	private $showSourceText = null;
	private $sentiment = null;
	private $cQuery = null;
	private $xPath = null;
	private $baseUrl = null;
	private $keywordExtractMode = null;
	
	private function sourceText_arr()
	{
		return array
		(
			'cleaned_or_raw',
			'cleaned',
			'raw',
			'cquery',
			'xpath'
		);
	}    
	
	public function getMaxRetrieve(){
		return $this->maxRetrieve;
	}

	public function setMaxRetrieve($maxRetrieve){
		$this->maxRetrieve = $maxRetrieve;
	}
	
	public function getSourceText(){
		return $this->sourceText;
	}

	public function setSourceText($sourceText){
		$arr = $this->sourceText_arr();
		$isValid = false;
		for($i=0;$i<count($arr);$i++){
			if($arr[$i] == $sourceText){
				$this->sourceText = $sourceText;
				return;
			}
		}
		if (!$isValid)
		{
			throw new Exception("Invalid setting (".$sourceText.") for parameter sourceText");
		}
	}

	public function getShowSourceText(){
		return $this->showSourceText;
	}

	public function setShowSourceText($showSourceText){
		if ($showSourceText != 0 && $showSourceText != 1)
		{
			throw new Exception("Invalid setting (".$showSourceText.") for parameter showSourceText");
		}
		$this->showSourceText = $showSourceText;
	}
	
	public function getSentiment(){
		return $this->sentiment;
	}

	public function setSentiment($sentiment){
		if ($sentiment != 0 && $sentiment != 1)
		{
			throw new Exception("Invalid setting (".$sentiment.") for parameter sentiment");
		}
		$this->sentiment = $sentiment;
	}

	public function getCQuery(){
		return $this->cQuery;
	}

	public function setCQuery($cQuery){
		$this->cQuery = $cQuery;
	}

	public function getXPath(){
		return $this->xPath;
	}

	public function setXpath($xPath){
		$this->xPath = $xPath;
	}

	public function getBaseUrl(){
		return $this->baseUrl;
	}

	public function setBaseUrl($baseUrl){
		$this->baseUrl = $baseUrl;
	}
	
	public function getKeywordExtractMode(){
		return $this->keywordExtractMode;
	}

	public function setKeywordExtractMode($keywordExtractMode){
		if ($keywordExtractMode != "strict")
		{
			throw new Exception("Invalid setting (".$keywordExtractMode.") for parameter keywordExtractMode");
		}
		$this->keywordExtractMode = $keywordExtractMode;
	}
	
	
	public function getParameterString() {
		$retString = parent::getParameterString();
		if(isset($this->maxRetrieve))
			$retString=$retString."&maxRetrieve=".rawurlencode($this->maxRetrieve);
		if(isset($this->sourceText))
			$retString=$retString."&sourceText=".rawurlencode($this->sourceText);
		if(isset($this->showSourceText))
			$retString=$retString."&showSourceText=".rawurlencode($this->showSourceText);
		if(isset($this->sentiment))
			$retString=$retString."&sentiment=".rawurlencode($this->sentiment);
		if(isset($this->cQuery))
			$retString=$retString."&cquery=".rawurlencode($this->cQuery);
		if(isset($this->xPath))
			$retString=$retString."&xpath=".rawurlencode($this->xPath);
		if(isset($this->baseUrl))
			$retString=$retString."&baseUrl=".rawurlencode($this->baseUrl);
		if(isset($this->keywordExtractMode))
			$retString=$retString."&keywordExtractMode=".rawurlencode($this->keywordExtractMode);
		return $retString;
	}

}

/* Parameter class for functions URLGetText, HTMLGetText, URLGetRawText, HTMLGetRawText, URLGetTitle, HTMLGetTitle
//
//  See http://www.alchemyapi.com/api/text/proc.html for detailed parameter descriptions
//
*/
class AlchemyAPI_TextParams extends AlchemyAPI_Params{	  

	private $useMetaData = null;
	private $extractLinks = null;

	public function getUseMetaData(){
		return $this->useMetaData;
	}

	public function setUseMetaData($useMetaData){
		if ($useMetaData != 0 && $useMetaData != 1)
		{
			throw new Exception("Invalid setting (".$useMetaData.") for parameter useMetaData");
		}
		$this->useMetaData = $useMetaData;
	}

	public function getExtractLinks(){
		return $this->extractLinks;
	}

	public function setExtractLinks($extractLinks){
		if ($extractLinks != 0 && $extractLinks != 1)
		{
			throw new Exception("Invalid setting (".$extractLinks.") for parameter extractLinks");
		}
		$this->extractLinks = $extractLinks;
	}
	
	public function getParameterString() {
		$retString = parent::getParameterString();
		if(isset($this->useMetaData))
			$retString=$retString."&useMetaData=".rawurlencode($this->useMetaData);
		if(isset($this->extractLinks))
			$retString=$retString."&extractLinks=".rawurlencode($this->extractLinks);
		return $retString;
	}

}

/* Parameter class for functions URLGetConstraintQuery, HTMLGetConstraintQuery, TextGetConstraintQuery
//
//  See http://www.alchemyapi.com/api/scrape/proc.html for detailed parameter descriptions
//
*/
class AlchemyAPI_ConstraintQueryParams extends AlchemyAPI_Params{

	private $cQuery = null;

	public function getCQuery(){
		return $this->cQuery;
	}

	public function setCQuery($cQuery){
		$this->cQuery = $cQuery;
	}

	public function getParameterString() {
		$retString = parent::getParameterString();
		if(isset($this->cQuery))
			$retString=$retString."&cquery=".rawurlencode($this->cQuery);
		return $retString;
	}

}

class AlchemyAPI_RelationParams extends AlchemyAPI_Params{	  

	private $disambiguate = null;
	private $linkedData = null;
	private $coreference = null;
	private $sourceText = null;
	private $showSourceText = null;
	private $entities = null;
	private $sentimentExcludeEntities = null;
	private $requireEntities = null;
	private $maxRetrieve = null;
	private $baseUrl = null;
	private $cQuery = null;
	private $xPath = null;
	private $sentiment = null;
	
	private function sourceText_arr()
	{
		return array
		(
			'cleaned_or_raw',
			'cleaned',
			'raw',
			'cquery',
			'xpath'
		);
	} 

	public function getDisambiguate(){
		return $this->disambiguate;
	}

	public function setDisambiguate($disambiguate){
		if ($disambiguate != 0 && $disambiguate != 1)
		{
			throw new Exception("Invalid setting (".$disambiguate.") for parameter disambiguate");
		}
		$this->disambiguate = $disambiguate;
	}

	public function getLinkedData(){
		return $this->linkedData;
	}

	public function setLinkedData($linkedData){
		if ($linkedData != 0 && $linkedData != 1)
		{
			throw new Exception("Invalid setting (".$linkedData.") for parameter linkedData");
		}
		$this->linkedData = $linkedData;
	}

	public function getCoreference(){
		return $this->coreference;
	}

	public function setCoreference($coreference){
		if ($coreference != 0 && $coreference != 1)
		{
			throw new Exception("Invalid setting (".$coreference.") for parameter coreference");
		}
		$this->coreference = $coreference;
	}
	
	public function getSourceText(){
		return $this->sourceText;
	}

	public function setSourceText($sourceText){
		$arr = $this->sourceText_arr();
		$isValid = false;
		for($i=0;$i<count($arr);$i++){
			if($arr[$i] == $sourceText){
				$this->sourceText = $sourceText;
				return;
			}
		}
		if (!$isValid)
		{
			throw new Exception("Invalid setting (".$sourceText.") for parameter sourceText");
		}
	}

	public function getShowSourceText(){
		return $this->showSourceText;
	}

	public function setShowSourceText($showSourceText){
		if ($showSourceText != 0 && $showSourceText != 1)
		{
			throw new Exception("Invalid setting (".$showSourceText.") for parameter showSourceText");
		}
		$this->showSourceText = $showSourceText;
	}

	public function getMaxRetrieve(){
		return $this->maxRetrieve;
	}

	public function setMaxRetrieve($maxRetrieve){
		$this->maxRetrieve = $maxRetrieve;
	}

	public function getBaseUrl(){
		return $this->baseUrl;
	}

	public function setBaseUrl($baseUrl){
		$this->baseUrl = $baseUrl;
	}
	
	public function getCQuery(){
		return $this->cQuery;
	}

	public function setCQuery($cQuery){
		$this->cQuery = $cQuery;
	}
	
	public function getXPath(){
		return $this->xPath;
	}

	public function setXPath($xPath){
		$this->xPath = $xPath;
	}

	public function getSentiment(){
			return $this->sentiment;
	}

	public function setSentiment($sentiment){
			if ($sentiment != 0 && $sentiment != 1)
			{
					throw new Exception("Invalid setting (".$sentiment.") for parameter sentiment");
			}
			$this->sentiment = $sentiment;
	}
	
	public function getEntities(){
			return $this->entities;
	}

	public function setEntities($entities){
			if ($entities != 0 && $entities != 1)
			{
					throw new Exception("Invalid setting (".$entities.") for parameter entities");
			}
			$this->entities = $entities;
	}

	public function getSentimentExcludeEntities(){
			return $this->sentimentExcludeEntities;
	}

	public function setSentimentExcludeEntities($sentimentExcludeEntities){
			if ($sentimentExcludeEntities != 0 && $sentimentExcludeEntities != 1)
			{
					throw new Exception("Invalid setting (".$sentimentExcludeEntities.") for parameter sentimentExcludeEntities");
			}
			$this->sentimentExcludeEntities = $sentimentExcludeEntities;
	}
	
	public function getRequireEntities(){
			return $this->requireEntities;
	}

	public function setRequireEntities($requireEntities){
			if ($requireEntities != 0 && $requireEntities != 1)
			{
					throw new Exception("Invalid setting (".$requireEntities.") for parameter requireEntities");
			}
			$this->requireEntities = $requireEntities;
	}
	

	
	public function getParameterString() {
		$retString = parent::getParameterString();
		if(isset($this->disambiguate))
			$retString=$retString."&disambiguate=".rawurlencode($this->disambiguate);
		if(isset($this->linkedData))
			$retString=$retString."&linkedData=".rawurlencode($this->linkedData);
		if(isset($this->coreference))
			$retString=$retString."&coreference=".rawurlencode($this->coreference);
		if(isset($this->entities))
			$retString=$retString."&entities=".rawurlencode($this->entities);
		if(isset($this->sentimentExcludeEntities))
			$retString=$retString."&sentimentExcludeEntities=".rawurlencode($this->sentimentExcludeEntities);
		if(isset($this->requireEntities))
			$retString=$retString."&requireEntities=".rawurlencode($this->requireEntities);
		if(isset($this->showSourceText))
			$retString=$retString."&showSourceText=".rawurlencode($this->showSourceText);
		if(isset($this->sourceText))
			$retString=$retString."&sourceText=".rawurlencode($this->sourceText);
		if(isset($this->maxRetrieve))
			$retString=$retString."&maxRetrieve=".rawurlencode($this->maxRetrieve);
		if(isset($this->baseUrl))
			$retString=$retString."&baseUrl=".rawurlencode($this->baseUrl);
		if(isset($this->cQuery))
			$retString=$retString."&cquery=".rawurlencode($this->cQuery);
		if(isset($this->xPath))
			$retString=$retString."&xpath=".rawurlencode($this->xPath);
                if(isset($this->sentiment))
                        $retString=$retString."&sentiment=".rawurlencode($this->sentiment);
		return $retString;
	}

}

/* Parameter class for functions URLGetMicroformats, HTMLGetMicroformats, TextGetMicroformats
//
//  See http://www.alchemyapi.com/api/mformat/proc.html for detailed parameter descriptions
//
*/
class AlchemyAPI_MicroformatParams extends AlchemyAPI_Params{

	public function getParameterString() {
		$retString = parent::getParameterString();
		return $retString;
	}

}

/* Parameter class for functions TextGetTargetedSentiment
//
//  See http://www.alchemyapi.com/api/sentiment/proc.html for detailed parameter descriptions
//
*/
class AlchemyAPI_TargetedSentimentParams extends AlchemyAPI_Params{

	private $target = null;
	private $showSourceText = null;

	public function getTarget(){
		return $this->target;
	}

	public function setTarget($target){
		$this->target = $target;
	}

	public function getShowSourceText(){
		return $this->showSourceText;
	}

	public function setShowSourceText($showSourceText){
		if ($showSourceText != 0 && $showSourceText != 1)
		{
			throw new Exception("Invalid setting (".$showSourceText.") for parameter showSourceText");
		}
		$this->showSourceText = $showSourceText;
	}

	public function getParameterString() {
		$retString = parent::getParameterString();
		$retString=$retString."&showSourceText=".rawurlencode($this->showSourceText);
		$retString=$retString."&target=".rawurlencode($this->target);
		return $retString;
	}
}

class AlchemyAPI
{
	const XML_OUTPUT_MODE = "xml";
	const JSON_OUTPUT_MODE = "json";

	private $_apiKey = '';
	private $_hostPrefix = 'access';

	public function setAPIHost($apiHost)
	{
		$this->_hostPrefix = $apiHost;

		if (strlen($this->_hostPrefix) < 2)
		{
			throw new Exception("Error setting API host.");
		}
	}

	public function setAPIKey($apiKey)
	{
		$this->_apiKey = $apiKey;

		if (strlen($this->_apiKey) < 5)
		{
			throw new Exception("Error setting API key.");
		}
	}

	public function loadAPIKey($filename)
	{
		$handle = fopen($filename, 'r');
		$theData = fgets($handle, 512);
		fclose($handle);
		$this->_apiKey = rtrim($theData);

		if (strlen($this->_apiKey) < 5)
		{
			throw new Exception("Error loading API key.");
		}
	}

	public function URLGetAuthor($url, $outputMode = self::XML_OUTPUT_MODE, $params = null)
	{

		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_Params", $params);

		if(is_null($params))
			$params = new AlchemyAPI_Params();

		$params->setUrl($url);
		$params->SetOutputMode($outputMode);

		return $this->GET("URLGetAuthor", "url", $params);

	}

	public function HTMLGetAuthor($html, $url, $outputMode = self::XML_OUTPUT_MODE, $params = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_Params", $params);

		if(is_null($params))
			$params = new AlchemyAPI_Params();

		$params->setHtml($html);
		$params->setUrl($url);
		$params->SetOutputMode($outputMode);

        
		return $this->POST("HTMLGetAuthor", "html", $params);
	}

	public function URLGetRankedNamedEntities($url, $outputMode = self::XML_OUTPUT_MODE, $namedEntityParams = null)
	{
		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_NamedEntityParams", $namedEntityParams);
		
		if(is_null($namedEntityParams))
			$namedEntityParams = new AlchemyAPI_NamedEntityParams();
		
		$namedEntityParams->setUrl($url);
		$namedEntityParams->setOutputMode($outputMode);

		return $this->GET("URLGetRankedNamedEntities", "url", $namedEntityParams);
	}

	public function HTMLGetRankedNamedEntities($html, $url, $outputMode = self::XML_OUTPUT_MODE, $namedEntityParams = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_NamedEntityParams", $namedEntityParams);
				
		if(is_null($namedEntityParams))
			$namedEntityParams = new AlchemyAPI_NamedEntityParams();
		
		$namedEntityParams->setHtml($html);
		$namedEntityParams->setUrl($url);
		$namedEntityParams->setOutputMode($outputMode);

		return $this->POST("HTMLGetRankedNamedEntities", "html", $namedEntityParams);
	}

	public function TextGetRankedNamedEntities($text, $outputMode = self::XML_OUTPUT_MODE, $namedEntityParams = null)
	{
		$this->CheckText($text, $outputMode);
		$this->CheckParamType("AlchemyAPI_NamedEntityParams", $namedEntityParams);
		
		if(is_null($namedEntityParams))
			$namedEntityParams = new AlchemyAPI_NamedEntityParams();
		
		$namedEntityParams->setText($text);
		$namedEntityParams->setOutputMode($outputMode);

		return $this->POST("TextGetRankedNamedEntities", "text", $namedEntityParams);
	}

	public function URLGetRankedConcepts($url, $outputMode = self::XML_OUTPUT_MODE, $conceptParams = null)
	{
		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_ConceptParams", $conceptParams);
		
		if(is_null($conceptParams))
			$conceptParams = new AlchemyAPI_ConceptParams();
		
		$conceptParams->setUrl($url);
		$conceptParams->setOutputMode($outputMode);

		return $this->GET("URLGetRankedConcepts", "url", $conceptParams);
	}

	public function HTMLGetRankedConcepts($html, $url, $outputMode = self::XML_OUTPUT_MODE, $conceptParams = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_ConceptParams", $conceptParams);
		
		if(is_null($conceptParams))
			$conceptParams = new AlchemyAPI_ConceptParams();
		
		$conceptParams->setHtml($html);
		$conceptParams->setUrl($url);
		$conceptParams->setOutputMode($outputMode);

		return $this->POST("HTMLGetRankedConcepts", "html", $conceptParams);
	}

	public function TextGetRankedConcepts($text, $outputMode = self::XML_OUTPUT_MODE, $conceptParams = null)
	{
		$this->CheckText($text, $outputMode);
		$this->CheckParamType("AlchemyAPI_ConceptParams", $conceptParams);
		
		if(is_null($conceptParams))
			$conceptParams = new AlchemyAPI_ConceptParams();
		
		$conceptParams->setText($text);
		$conceptParams->setOutputMode($outputMode);

		return $this->POST("TextGetRankedConcepts", "text", $conceptParams);
	}

	public function URLGetRankedKeywords($url, $outputMode = self::XML_OUTPUT_MODE, $keywordParams = null)
	{
		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_KeywordParams", $keywordParams);
		
		if(is_null($keywordParams))
			$keywordParams = new AlchemyAPI_KeywordParams();
		
		$keywordParams->setUrl($url);
		$keywordParams->setOutputMode($outputMode);

		return $this->GET("URLGetRankedKeywords", "url", $keywordParams);
	}

	public function HTMLGetRankedKeywords($html, $url, $outputMode = self::XML_OUTPUT_MODE, $keywordParams = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_KeywordParams", $keywordParams);
		
		if(is_null($keywordParams))
			$keywordParams = new AlchemyAPI_KeywordParams();
		
		$keywordParams->setHtml($html);
		$keywordParams->setUrl($url);
		$keywordParams->setOutputMode($outputMode);

		return $this->POST("HTMLGetRankedKeywords", "html", $keywordParams);
	}

	public function TextGetRankedKeywords($text, $outputMode = self::XML_OUTPUT_MODE, $keywordParams = null)
	{
		$this->CheckText($text, $outputMode);
		$this->CheckParamType("AlchemyAPI_KeywordParams", $keywordParams);
		
			if(is_null($keywordParams))
			$keywordParams = new AlchemyAPI_KeywordParams();
		
		$keywordParams->setText($text);
		$keywordParams->setOutputMode($outputMode);

		return $this->POST("TextGetRankedKeywords", "text", $keywordParams);
	}

	public function URLGetLanguage($url, $outputMode = self::XML_OUTPUT_MODE, $languageParams = null)
	{
		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_LanguageParams", $languageParams);
		
		if(is_null($languageParams))
			$languageParams = new AlchemyAPI_LanguageParams();
		
		$languageParams->setUrl($url);
		$languageParams->setOutputMode($outputMode);

		return $this->GET("URLGetLanguage", "url", $languageParams);
	}

	public function HTMLGetLanguage($html, $url, $outputMode = self::XML_OUTPUT_MODE, $languageParams = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_LanguageParams", $languageParams);
		
		if(is_null($languageParams))
			$languageParams = new AlchemyAPI_LanguageParams();
		
		$languageParams->setHtml($html);
		$languageParams->setUrl($url);
		$languageParams->setOutputMode($outputMode);

		return $this->POST("HTMLGetLanguage", "html", $languageParams);
	}

	public function TextGetLanguage($text, $outputMode = self::XML_OUTPUT_MODE, $languageParams = null)
	{
		$this->CheckText($text, $outputMode);
		$this->CheckParamType("AlchemyAPI_LanguageParams", $languageParams);
		
		if(is_null($languageParams))
			$languageParams = new AlchemyAPI_LanguageParams();
		
		$languageParams->setText($text);
		$languageParams->setOutputMode($outputMode);

		return $this->POST("TextGetLanguage", "text", $languageParams);
	}
	

	public function URLGetCategory($url, $outputMode = self::XML_OUTPUT_MODE, $categorizeParams = null)
	{
		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_CategoryParams", $categorizeParams);
		
		if(is_null($categorizeParams))
			$categorizeParams = new AlchemyAPI_CategoryParams();
		
		$categorizeParams->setUrl($url);
		$categorizeParams->setOutputMode($outputMode);

		return $this->GET("URLGetCategory", "url", $categorizeParams);
	}

	public function HTMLGetCategory($html, $url, $outputMode = self::XML_OUTPUT_MODE, $categorizeParams = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_CategoryParams", $categorizeParams);
		
		if(is_null($categorizeParams))
			$categorizeParams = new AlchemyAPI_CategoryParams();
		
		$categorizeParams->setHtml($html);
		$categorizeParams->setUrl($url);
		$categorizeParams->setOutputMode($outputMode);

		return $this->POST("HTMLGetCategory", "html", $categorizeParams);
	}

	public function TextGetCategory($text, $outputMode = self::XML_OUTPUT_MODE, $categorizeParams = null)
	{
		$this->CheckText($text, $outputMode);
		$this->CheckParamType("AlchemyAPI_CategoryParams", $categorizeParams);
		
		if(is_null($categorizeParams))
			$categorizeParams = new AlchemyAPI_CategoryParams();
		
		$categorizeParams->setText($text);
		$categorizeParams->setOutputMode($outputMode);

		return $this->POST("TextGetCategory", "text", $categorizeParams);
	}

	public function URLGetText($url, $outputMode = self::XML_OUTPUT_MODE, $textParams = null)
	{
		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_TextParams", $textParams);
		
		if(is_null($textParams))
			$textParams = new AlchemyAPI_TextParams();
		
		$textParams->setUrl($url);
		$textParams->setOutputMode($outputMode);

		return $this->GET("URLGetText", "url", $textParams);
	}

	public function HTMLGetText($html, $url, $outputMode = self::XML_OUTPUT_MODE, $textParams = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_TextParams", $textParams);
		
		if(is_null($textParams))
			$textParams = new AlchemyAPI_TextParams();
		
		$textParams->setHtml($html);
		$textParams->setUrl($url);
		$textParams->setOutputMode($outputMode);

		return $this->POST("HTMLGetText", "html", $textParams);
	}

	public function URLGetRawText($url, $outputMode = self::XML_OUTPUT_MODE, $params = null)
	{
		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_Params", $params);
		
		if(is_null($params))
			$params = new AlchemyAPI_Params();
		
		$params->setUrl($url);
		$params->setOutputMode($outputMode);
		
		return $this->GET("URLGetRawText", "url", $params);
	}

	public function HTMLGetRawText($html, $url, $outputMode = self::XML_OUTPUT_MODE, $params = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_Params", $params);
		
		if(is_null($params))
			$params = new AlchemyAPI_TextParams();
		
		$params->setHtml($html);
		$params->setUrl($url);
		$params->setOutputMode($outputMode);

		return $this->POST("HTMLGetRawText", "html", $params);
	}

	public function URLGetTitle($url, $outputMode = self::XML_OUTPUT_MODE, $params = null)
	{
		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_Params", $params);
		
		if(is_null($params))
			$params = new AlchemyAPI_Params();
		
		$params->setUrl($url);
		$params->setOutputMode($outputMode);

		return $this->GET("URLGetTitle", "url", $params);
	}

	public function HTMLGetTitle($html, $url, $outputMode = self::XML_OUTPUT_MODE, $params = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_Params", $params);
		
		if(is_null($params))
			$params = new AlchemyAPI_Params();
		
		$params->setHtml($html);
		$params->setUrl($url);
		$params->setOutputMode($outputMode);

		return $this->POST("HTMLGetTitle", "html", $params);
	}

	public function URLGetFeedLinks($url, $outputMode = self::XML_OUTPUT_MODE, $params = null)
	{
		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_Params", $params);
		
		if(is_null($params))
			$params = new AlchemyAPI_Params();
		
		$params->setUrl($url);
		$params->setOutputMode($outputMode);

		return $this->GET("URLGetFeedLinks", "url", $params);
	}

	public function HTMLGetFeedLinks($html, $url, $outputMode = self::XML_OUTPUT_MODE, $params = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_Params", $params);
	
		if(is_null($params))
			$params = new AlchemyAPI_Params();
		
		
		$params->setHtml($html);
		$params->setUrl($url);
		$params->setOutputMode($outputMode);

		return $this->POST("HTMLGetFeedLinks", "html", $params);
	}

	public function URLGetMicroformats($url, $outputMode = self::XML_OUTPUT_MODE, $params = null)
	{
		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_Params", $params);
		
		if(is_null($params))
			$params = new AlchemyAPI_Params();
		
		$params->setUrl($url);
		$params->setOutputMode($outputMode);

		return $this->GET("URLGetMicroformatData", "url", $params);
	}

	public function HTMLGetMicroformats($html, $url, $outputMode = self::XML_OUTPUT_MODE, $params = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_Params", $params);
		
		if(is_null($params))
			$params = new AlchemyAPI_Params();
		
		$params->setHtml($html);
		$params->setUrl($url);
		$params->setOutputMode($outputMode);

		return $this->POST("HTMLGetMicroformatData", "html", $params);
	}

	public function URLGetConstraintQuery($url, $query, $outputMode = self::XML_OUTPUT_MODE, $constraintParams = null)
    {
        $this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_ConstraintQueryParams", $constraintParams);
		
        if (strlen($query) < 2)
        {
            throw new Exception("Invalid constraint query specified.");
        }
		
		if(is_null($constraintParams))
			$constraintParams = new AlchemyAPI_ConstraintQueryParams();
		
		$constraintParams->setUrl($url);
		$constraintParams->setOutputMode($outputMode);
		$constraintParams->setCQuery($query);

        return $this->GET("URLGetConstraintQuery", "url", $constraintParams);
    }

    public function HTMLGetConstraintQuery($html, $url, $query, $outputMode = self::XML_OUTPUT_MODE, $constraintParams = null)
    {
        $this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_ConstraintQueryParams", $constraintParams);
		
        if (strlen($query) < 2)
        {
            throw new Exception("Invalid constraint query specified.");
        }
				
		$constraintParams = new AlchemyAPI_ConstraintQueryParams();
		
		$constraintParams->setUrl($url);
		$constraintParams->setHtml($html);
		$constraintParams->setOutputMode($outputMode);
		$constraintParams->setCQuery($query);

        return $this->POST("HTMLGetConstraintQuery", "html", $constraintParams);
    }
	
	public function URLGetTextSentiment($url, $outputMode = self::XML_OUTPUT_MODE, $baseParams = null)
	{
		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_Params", $baseParams);
		
		if(is_null($baseParams))
			$baseParams = new AlchemyAPI_Params();
		
		$baseParams->setUrl($url);
		$baseParams->setOutputMode($outputMode);

		return $this->GET("URLGetTextSentiment", "url", $baseParams);
	}

	public function HTMLGetTextSentiment($html, $url, $outputMode = self::XML_OUTPUT_MODE, $baseParams = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_Params", $baseParams);
		
		if(is_null($baseParams))
			$baseParams = new AlchemyAPI_Params();
		
		$baseParams->setHtml($html);
		$baseParams->setUrl($url);
		$baseParams->setOutputMode($outputMode);

		return $this->POST("HTMLGetTextSentiment", "html", $baseParams);
	}

	public function TextGetTextSentiment($text, $outputMode = self::XML_OUTPUT_MODE, $baseParams = null)
	{
		$this->CheckText($text, $outputMode);
		$this->CheckParamType("AlchemyAPI_Params", $baseParams);
		
		if(is_null($baseParams))
			$baseParams = new AlchemyAPI_Params();
		
		$baseParams->setText($text);
		$baseParams->setOutputMode($outputMode);

		return $this->POST("TextGetTextSentiment", "text", $baseParams);
	}

	public function URLGetTargetedSentiment($url, $target, $outputMode = self::XML_OUTPUT_MODE, $sentimentParams = null)
	{
		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_TargetedSentimentParams", $sentimentParams);

		if(is_null($sentimentParams))
			$sentimentParams = new AlchemyAPI_TargetedSentimentParams();

		$sentimentParams->setUrl($url);
		$sentimentParams->setTarget($target);
		$sentimentParams->setOutputMode($outputMode);

		return $this->GET("URLGetTargetedSentiment", "url", $sentimentParams);
	}

	public function HTMLGetTargetedSentiment($html, $url, $target, $outputMode = self::XML_OUTPUT_MODE, $sentimentParams = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_TargetedSentimentParams", $sentimentParams);

		if(is_null($sentimentParams))
			$sentimentParams = new AlchemyAPI_TargetedSentimentParams();

		$sentimentParams->setUrl($url);
		$sentimentParams->setHtml($html);
		$sentimentParams->setTarget($target);
		$sentimentParams->setOutputMode($outputMode);
 
		return $this->POST("HTMLGetTargetedSentiment", "html", $sentimentParams);
        }

	public function TextGetTargetedSentiment($text, $target, $outputMode = self::XML_OUTPUT_MODE, $sentimentParams = null)
	{
		$this->CheckText($text, $outputMode);
		$this->CheckParamType("AlchemyAPI_TargetedSentimentParams", $sentimentParams);

		if(is_null($sentimentParams))
			$sentimentParams = new AlchemyAPI_TargetedSentimentParams();

		$sentimentParams->setText($text);
		$sentimentParams->setTarget($target);
		$sentimentParams->setOutputMode($outputMode);

		return $this->POST("TextGetTargetedSentiment", "text", $sentimentParams);
	}

	public function URLGetRelations($url, $outputMode = self::XML_OUTPUT_MODE, $relationParams = null)
	{
		$this->CheckURL($url, $outputMode);
		$this->CheckParamType("AlchemyAPI_RelationParams", $relationParams);
		
		if(is_null($relationParams))
			$relationParams = new AlchemyAPI_RelationParams();
		
		$relationParams->setUrl($url);
		$relationParams->setOutputMode($outputMode);

		return $this->GET("URLGetRelations", "url", $relationParams);
	}

	public function HTMLGetRelations($html, $url, $outputMode = self::XML_OUTPUT_MODE, $relationParams = null)
	{
		$this->CheckHTML($html, $url, $outputMode);
		$this->CheckParamType("AlchemyAPI_RelationParams", $relationParams);
		
		if(is_null($relationParams))
			$relationParams = new AlchemyAPI_RelationParams();
		
		$relationParams->setHtml($html);
		$relationParams->setUrl($url);
		$relationParams->setOutputMode($outputMode);

		return $this->POST("HTMLGetRelations", "html", $relationParams);
	}

	public function TextGetRelations($text, $outputMode = self::XML_OUTPUT_MODE, $relationParams = null)
	{
		$this->CheckText($text, $outputMode);
		$this->CheckParamType("AlchemyAPI_RelationParams", $relationParams);
		
		if(is_null($relationParams))
			$relationParams = new AlchemyAPI_RelationParams();
		
		$relationParams->setText($text);
		$relationParams->setOutputMode($outputMode);

		return $this->POST("TextGetRelations", "text", $relationParams);
	}

	private function CheckOutputMode($outputMode)
	{
		if (strlen($this->_apiKey) < 5)
                {
                        throw new Exception("Load an API key.");
                }

                if (self::XML_OUTPUT_MODE !== $outputMode &&
                    self::JSON_OUTPUT_MODE !== $outputMode)
                {
                        throw new Exception("Illegal Output Mode specified, see *_OUTPUT_MODE constants.");
                }
	}

	private function CheckURL($url, $outputMode)
	{
		$this->CheckOutputMode($outputMode);

		if (strlen($url) < 10)
		{
			throw new Exception("Enter a valid URL to analyze.");
		}
	}

	private function CheckHTML($html, $url, $outputMode)
	{
		$this->CheckURL($url, $outputMode);

		if (strlen($html) < 10)
		{
			throw new Exception("Enter a HTML document to analyze.");
		}
	}

	private function CheckText($text, $outputMode)
	{
		$this->CheckOutputMode($outputMode);

		if (strlen($text) < 5)
		{
			throw new Exception("Enter some text to analyze.");
		}
	}
	
	private function CheckParamType($className, $class)
	{
		if(!is_null($class) && ($className != get_class($class)) )
		{
			throw new Exception("Trying to pass ".get_class($class)." into a function that requires ".$className);
		}
	}

	private function POST()
	{ // callMethod, $callPrefix, $parameterObject
		$callMethod = func_get_arg(0);
		$callPrefix = func_get_arg(1);
		$paramObj = func_get_arg(2);
		
		$outputMode = $paramObj->getOutputMode();
		
		$data = "apikey=".$this->_apiKey.$paramObj->getParameterString();
		$paramObj->resetBaseParams();

		$params = array('http' => array('method' => 'POST',
						'Content-type'=> 'application/x-www-form-urlencoded',
						'Content-length' =>strlen( $data ),
						'content' => $data
						));
		
		$hostPrefix = $this->_hostPrefix;
		$endpoint = "http://$hostPrefix.alchemyapi.com/calls/$callPrefix/$callMethod";

		$context = stream_context_create($params);
		
		return $this->DoRequest($endpoint,$context,$outputMode);
	}
	
	private function GET()
	{ // callMethod, $callPrefix, $parameterObject
		$callMethod = func_get_arg(0);
		$callPrefix = func_get_arg(1);
		$paramObj = func_get_arg(2);
		
		$outputMode = $paramObj->getOutputMode();
		
		$data = "apikey=".$this->_apiKey.$paramObj->getParameterString();
		$paramObj->resetBaseParams();

		$params = array('http' => array('method' => 'GET',
						'Content-type'=> 'application/x-www-form-urlencoded'
						));

		$hostPrefix = $this->_hostPrefix;
		$uri = "http://$hostPrefix.alchemyapi.com/calls/$callPrefix/$callMethod"."?".$data;

		$context = stream_context_create($params);
		
		return $this->DoRequest($uri,$context,$outputMode);
	
	}
	
	private function DoRequest($uri,$context, $outputMode) 
	{
		$fp = @fopen($uri, 'rb', false, $context);
		if (!($fp))
		{
			throw new Exception("Error making API call.");
		}

		$response = @stream_get_contents($fp);
		fclose($fp);
		if ($response === false)
		{
			throw new Exception("Error making API call.");
		}

		if (self::XML_OUTPUT_MODE == $outputMode)
		{
			$doc = simplexml_load_string($response);

                	if (!($doc))
	        	{
    	        		throw new Exception("Error making API call.");
			}

			$status = $doc->xpath("/results/status");
			if ($status[0] != "OK")
			{
				$statusInfo = $doc->xpath("/results/statusInfo");
				throw new Exception("Error making API call: $statusInfo[0]");
			}
		}
		else
		{
			$obj = json_decode($response);

			if (is_null($obj))
			{
				throw new Exception("Error making API call.");
			}
			if ("OK" != $obj->{'status'})
			{
				$statusInfo = $obj->{'statusInfo'};
				throw new Exception("Error making API call: $statusInfo");
			}
		}

		return $response;
	}
}


?>
