<?php
  require 'serverside.php';
  $table_data->get('vista_altas','id',array('id', 'tecnico','ot','direccion', 'zona','calendario','mac_ont','sn_ont','mac_uno_stb', 'sn_uno_stb', 'mac_dos_stb', 'sn_dos_stb', 'mac_tres_stb', 'sn_tres_stb', 'ap_uno_mac', 'ap_uno_sn', 'ap_dos_mac', 'ap_dos_sn', 'ap_tres_mac', 'ap_tres_sn'));
?>