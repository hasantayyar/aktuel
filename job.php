<?php 
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
$output = Aktuel::fetchAll();
$m->set("aktuel_cache",$output,3600);
