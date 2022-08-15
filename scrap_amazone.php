<?php
# scraping books to scrape: https://books.toscrape.com/


$LinksArr = [];

$row = 1;
if (($handle = fopen("csv/product.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $num = count($data);
    $row++;
    for ($c=0; $c < $num; $c++) {
        array_push($LinksArr,$data[$c]);
    }
  }
  fclose($handle);
}


$limit = 5;
// $limit = count($LinksArr);

$limitedLinksArr = [];

for($k = 0; $k < $limit; $k++){
	array_push($limitedLinksArr,$LinksArr[$k]);
}



$allProductArr = [];

require 'vendor/autoload.php';
$httpClient = new \Goutte\Client();


foreach ($limitedLinksArr as $limitedLinksAr ) {
	
	
	$url = $limitedLinksAr;
	$response = $httpClient->request('GET', 'https://www.amazon.com/dp/B0B72HXD3G?ref=myi_title_dp');

	$title = $response->filter('#productTitle')->each(function ($node) {
	    return $node->text();
	});
	$price = $response->filter('.priceToPay span')->each(function ($node) {
	    return $node->text();
	});

	$desc = $response->filter('#feature-bullets')->each(function ($node) {
	    return $node->html();
	});


	$gallery = $response->filter('.a-dynamic-image')->each(function ($node) {
		$href = $node->extract(array('src'));
		return $href[0];
	});

		echo "<pre>";
	print_r($gallery);
	exit();


	$productArr = array(
		'title' => $title[0],
		'price' => $price[0],
		'desc' => $desc[0],
		'featured_img' => $gallery[0],
		'gallery' => $gallery
	);


	echo "<pre>";
	print_r($productArr);
	exit();

	array_push($allProductArr,$productArr);
}


echo "<pre>";
print_r($allProductArr);
exit();



echo json_encode($alljobs);

