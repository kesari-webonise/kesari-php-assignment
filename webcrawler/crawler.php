<?php

$dom=new DOMDocument();

$alreadyVisitedLinksList=array();
$linksDetailArray=array();
$outerLinkPointer=0;

function getListOfImagesLinksTitleOnLink($url,$depth)
{
	global $dom;
	global $linksDetailArray;
	global $alreadyVisitedLinksList;
	global $outerLinkPointer;

	if($depth==0)
		return;

	$imagesArray=array();
	$linksArray=array();

	@$dom->loadHTMLFile($url);

	$alreadyVisitedLinksList[]=$url;

	$links=$dom->getElementsByTagName('a');
	foreach($links as $element) {
		$href = $element->getAttribute('href');
		$linksArray[]=$href;
	}

	$images=$dom->getElementsByTagName('img');
	foreach ($images as $element) {
		$src=$element->getAttribute('src');
		$imagesArray[]=$src;
	}

	$title=$dom->getElementsByTagName('title');
	foreach ($title as $pageTitle) {
		$titleName=$pageTitle->textContent;
	}

	$linksDetailArray[]=array($url,$linksArray,$imagesArray,$titleName);

	foreach ($linksArray as $link) {
			if(!in_array($link, $alreadyVisitedLinksList)){
				getListOfImagesLinksTitleOnLink($link,$depth-1);
			}
		}	
	print_r($linksDetailArray);
}
getListOfImagesLinksTitleOnLink($argv[1],$argv[2]);
file_put_contents("crawledData.json", json_encode($linksDetailArray));
?>