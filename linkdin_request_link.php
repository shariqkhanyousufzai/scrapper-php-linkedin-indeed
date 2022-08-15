<?php
# scraping books to scrape: https://books.toscrape.com/
require 'vendor/autoload.php';
$httpClient = new \Goutte\Client();
$response = $httpClient->request('GET', 'https://www.linkedin.com/jobs/search?keywords=PHP&location=Saudi%20Arabia&locationId=&geoId=100459316&f_TPR=r86400&position=1&pageNum=0');

$titles = $response->evaluate('//ul[@class="jobs-search__results-list"]//li//div[@class="base-card relative w-full hover:no-underline focus:no-underline base-card--link base-search-card base-search-card--link job-search-card"]//div[@class="base-search-card__info"]/h3[@class="base-search-card__title"]');

$companynames = $response->evaluate('//ul[@class="jobs-search__results-list"]//li//div[@class="base-card relative w-full hover:no-underline focus:no-underline base-card--link base-search-card base-search-card--link job-search-card"]//div[@class="base-search-card__info"]//h4[@class="base-search-card__subtitle"]/a');

$locations = $response->evaluate('//ul[@class="jobs-search__results-list"]//li//div[@class="base-card relative w-full hover:no-underline focus:no-underline base-card--link base-search-card base-search-card--link job-search-card"]//div[@class="base-search-card__info"]//div[@class="base-search-card__metadata"]/span[@class="job-search-card__location"]');
$benefits = $response->evaluate('//ul[@class="jobs-search__results-list"]//li//div[@class="base-card relative w-full hover:no-underline focus:no-underline base-card--link base-search-card base-search-card--link job-search-card"]//div[@class="base-search-card__info"]//div[@class="base-search-card__metadata"]//div[@class="job-search-card__benefits"]//div[@class="result-benefits"]/span[@class="result-benefits__text"]');

$days = $response->evaluate('//ul[@class="jobs-search__results-list"]//li//div[@class="base-card relative w-full hover:no-underline focus:no-underline base-card--link base-search-card base-search-card--link job-search-card"]//div[@class="base-search-card__info"]//div[@class="base-search-card__metadata"]/time[@class="job-search-card__listdate"]');


$test = $response->evaluate('//ul[@class="jobs-search__results-list"]//li//div[@class="base-card relative w-full hover:no-underline focus:no-underline base-card--link base-search-card base-search-card--link job-search-card"]/a');

$alljobs = array();
$links_arr = array();
$x = 0;

$links_arrs = $response->filter('ul.jobs-search__results-list li a.base-card__full-link')->each(function ($node) {
	$href = $node->extract(array('href'));
	return $href[0];
});


$title_c = 0;
$company_c = 0;
$salary_c = 0;
$nature_c = 0;
$descs_c = 0;
$day_c = 0;
$benefit_c = 0;
$location_c = 0;
$link_c = 0;
foreach ($titles as $key => $title) {
	$alljobs[$title_c]['title'] = trim($title->textContent);
	$title_c++;
}

foreach ($companynames as $keys => $companyname) {
	$alljobs[$company_c]['company'] = trim($companyname->textContent);
	$company_c++;
}

foreach ($locations as $keys => $location) {
	$alljobs[$location_c]['location'] = trim($location->textContent);
	$location_c++;
}

foreach ($benefits as $keys => $benefit) {
	$alljobs[$benefit_c]['benefit'] = trim($benefit->textContent);
	$benefit_c++;
}

foreach ($days as $keys => $day) {
	$alljobs[$day_c]['day'] = trim($day->textContent);
	$day_c++;
}

foreach ($links_arrs as $keys => $links_arr) {
	$alljobs[$link_c]['link'] = $links_arr;
	$link_c++;
}




echo json_encode($alljobs);

