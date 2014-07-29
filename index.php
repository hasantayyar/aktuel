<?php 
// create a new persistent client

require __DIR__.'/libs/aktuel.php';
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
	$output = Aktuel::fetchAll();
	$m->set("aktuel_cache",$output,3600);
}

echo "<pre>\nBilgi : ".$link."\n\n";
echo $output;
