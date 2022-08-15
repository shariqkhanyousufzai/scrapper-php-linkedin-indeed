<?php
# scraping books to scrape: https://books.toscrape.com/
require 'vendor/autoload.php';
$httpClient = new \Goutte\Client();
$response = $httpClient->request('GET', 'https://www.indeed.com/jobs?q=php&l=Richardson%2C+TX&start=10');
$titles = $response->evaluate('//div[@class="job_seen_beacon"]//table[@class="jobCard_mainContent big6_visualChanges"]//tbody//tr//td//div[@class="heading4 color-text-primary singleLineTitle tapItem-gutter"]//h2//a/span');
$companynames = $response->evaluate('//div[@class="job_seen_beacon"]//table[@class="jobCard_mainContent big6_visualChanges"]//tbody//tr//td//div[@class="heading6 company_location tapItem-gutter companyInfo"]/span[@class="companyName"]');
$salaries = $response->evaluate('//div[@class="job_seen_beacon"]//table[@class="jobCard_mainContent big6_visualChanges"]//tbody//tr//td//div[@class="heading6 tapItem-gutter metadataContainer noJEMChips salaryOnly"]/div[@class="metadata salary-snippet-container"]');
$natures = $response->evaluate('//div[@class="job_seen_beacon"]//table[@class="jobCard_mainContent big6_visualChanges"]//tbody//tr//td//div[@class="heading6 tapItem-gutter metadataContainer noJEMChips salaryOnly"]//div[@class="metadata"]/div[@class="attribute_snippet"]');

$descs = $response->evaluate('//div[@class="job_seen_beacon"]//table[@class="jobCardShelfContainer big6_visualChanges"]//tbody//tr[@class="underShelfFooter"]//td//div[@class="heading6 tapItem-gutter result-footer"]//div[@class="job-snippet"]/ul');
$days = $response->evaluate('//div[@class="job_seen_beacon"]//table[@class="jobCardShelfContainer big6_visualChanges"]//tbody//tr[@class="underShelfFooter"]//td//div[@class="heading6 tapItem-gutter result-footer"]/span[@class="date"]');


$links_arrs = $response->filter('.resultContent a')->each(function ($node) {
	$href = $node->extract(array('href'));
	return 'https://www.indeed.com'.$href[0];
});


$alljobs = array();
$title_c = 0;
$company_c = 0;
$salary_c = 0;
$nature_c = 0;
$descs_c = 0;
$day_c = 0;
$link_c = 0;
foreach ($titles as $key => $title) {
	$alljobs[$title_c]['title'] = $title->textContent;
	$title_c++;
}

foreach ($companynames as $keys => $companyname) {
	$alljobs[$company_c]['company'] = $companyname->textContent;
	$company_c++;
}

foreach ($salaries as $keys => $salarie) {
	$alljobs[$salary_c]['salary'] = $salarie->textContent;
	$salary_c++;
}

foreach ($natures as $keys => $nature) {
	$alljobs[$nature_c]['nature'] = $nature->textContent;
	$nature_c++;
}

foreach ($descs as $keys => $desc) {
	$alljobs[$descs_c]['desc'] = $desc->textContent;
	$descs_c++;
}

foreach ($days as $keys => $day) {
	$alljobs[$day_c]['day'] = $day->textContent;
	$day_c++;
}

foreach ($links_arrs as $keys => $links_arr) {
	$alljobs[$link_c]['link'] = $links_arr;
	$link_c++;
}

echo json_encode($alljobs);

