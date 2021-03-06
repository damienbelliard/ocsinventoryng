<?php

/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
  -------------------------------------------------------------------------
  ocsinventoryng plugin for GLPI
  Copyright (C) 2015-2016 by the ocsinventoryng Development Team.

  https://github.com/pluginsGLPI/ocsinventoryng
  -------------------------------------------------------------------------

  LICENSE

  This file is part of ocsinventoryng.

  ocsinventoryng is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  ocsinventoryng is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with ocsinventoryng. If not, see <http://www.gnu.org/licenses/>.
  --------------------------------------------------------------------------
 */

include ('../../../inc/includes.php');

Session::checkRight("plugin_ocsinventoryng", READ);

Html::header('OCS Inventory NG', '', "tools", "pluginocsinventoryngmenu", "importipdiscover");

$ip = new PluginOcsinventoryngIpDiscover();
if (empty($_POST)) {
   $_POST = $_GET;
}
if (isset($_POST["subnetsChoice"]) && isset($_SESSION["subnets"]) || isset($_SESSION["subnets"])) {
   $sN             = "";
   $networksDetail = array();
   $ocsServerId    = $_SESSION["plugin_ocsinventoryng_ocsservers_id"];
   $tab            = $_SESSION["subnets"];
   $subnets        = $ip->getSubnets($ocsServerId);
   if (isset($_POST["subnetsChoice"])) {
      $sN                              = $tab[$_POST["subnetsChoice"]];
      $knownMacAdresses                = $ip->getKnownMacAdresseFromGlpi();
      $networksDetail["subnets"]       = $ip->showSubnets($ocsServerId, $subnets, $knownMacAdresses, $sN);
      $networksDetail["subnetsChoice"] = $_POST["subnetsChoice"];
   } else {
      $sN                              = $tab[1];
      $knownMacAdresses                = $ip->getKnownMacAdresseFromGlpi();
      $networksDetail["subnets"]       = $ip->showSubnets($ocsServerId, $subnets, $knownMacAdresses, $sN);
      $networksDetail["subnetsChoice"] = 1;
   }
   $lim = count($networksDetail["subnets"]);
   $start = isset($_POST['start'])? $_POST['start'] : 0;
   if ($lim > $_SESSION["glpilist_limit"]) {
      $ip->showSubnetsDetails($networksDetail, $_SESSION["glpilist_limit"], $start);
   } else {
      $ip->showSubnetsDetails($networksDetail, $lim, $start);
   }
}

Html::footer();
?>