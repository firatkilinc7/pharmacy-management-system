<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'dashboard';



$route['login']                     = 'userop/login';
$route['logout']					= 'userop/logout';

$route['dashboard/(:num)']          = 'dashboard/index/$1';

$route['ilaclar/save/(:any)']       = 'ilaclar/save/$1';
$route['expired']                   = 'ilaclar/expired';
$route['stockout']                  = 'ilaclar/stockout';

$route['sepete-ekle']               = 'satis/sepete_ekle';
$route['satis/sepeti-temizle']      = 'satis/sepeti_temizle';
$route['satis/sepetten-cikar']      = 'satis/sepetten_cikar';
$route['satis/sepet/sepeti-onayla'] = 'satis/sepeti_onayla';
$route['satis/sepet/(:any)']        = 'satis/sepet/$1';

$route['ilaclar/ilac-iste']         = 'request';
$route['ilaclar/ilac-iste/onayla']  = 'request/ilaclari_iste';






