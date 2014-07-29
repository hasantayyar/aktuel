<?php
require 'ganon.php';
Class Aktuel{
        public static function fetchAll(){
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
                for($i=0;$i<count($items);++$i){
                        $output.=$items[$i]."\t\t".$prices[$i].$pricesFraction[$i]."\n";
                } 
                return $output;

        }
}


