<?php

// create a new persistent client
$m = new Memcached("memcached_pool");
$m->setOption(Memcached::OPT_BINARY_PROTOCOL, TRUE);
$m->setOption(Memcached::OPT_NO_BLOCK, TRUE);
$m->setOption(Memcached::OPT_AUTO_EJECT_HOSTS, TRUE);
if (!$m->getServerList()) {
    $server = explode(":",getenv("MEMCACHIER_SERVERS"));
    $m->addServer($server[0], $server[1]);
}
$m->setSaslAuthData( getenv("MEMCACHIER_USERNAME")
                   , getenv("MEMCACHIER_PASSWORD") );

$output = $m->get("aktuel_cache");

if(empty($output)){
	require __DIR__.'/libs/ganon.php';
	$link = "http://www.bim.com.tr/Categories/100/aktuel_urunler.aspx";
	$html = file_get_dom($link);
	if(!empty($html)){
		foreach($html('td[class="kaktuel-tablo2-icerik2"]') as $p){
			$a = $p('span[class="au-tablo10-baslik1"] a',0);
			$items[] = $a->getInnerText();			
		}

		foreach($html('td[class="kaktuel-tablo2-icerik2"]') as $p){
			$a =  $p('td[class="fiyat3-tablo1-fiyat2"] div',0);
			$prices[] = $a->getInnerText();			
		}

		foreach($html('td[class="kaktuel-tablo2-icerik2"]') as $p){
			$a = $p('td[class="fiyat3-tablo1-kurus2"] div',0);
			$pricesFraction[] = $a->getInnerText();			
		}
	
	}
echo "Bilgi : ".$link."\n\n";

	for($i=0;$i<count($items);++$i){
		$output.=$items[$i]."\t\t".$prices[$i].$pricesFraction[$i]."\n";
	}
	echo "<!-- #nocache -->";
	$m->set("aktuel_cache",$output,3600);
}
print_r($_SERVER);
exit();
echo "<pre>";
echo $output;
