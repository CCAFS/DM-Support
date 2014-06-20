<?php  
/**
*  This file is part of Data Management Support Pack (DMSP).
*
*  DMSP is free software: you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation, either version 3 of the License, or
*  at your option) any later version.
*
*  DMSP is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with DMSP.  If not, see <http://www.gnu.org/licenses/>.
*
* Copyright 2014 (C) Climate Change, Agriculture and Food Security (CCAFS)
* 
* Created on : 20-12-2013
* @author      Sebastian Amariles Garcia (CIAT/CCAFS)
* @version     1.0
*/
 
$filename = str_replace(' ', '%20', $_GET['file']);

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false); // required for certain browsers 
header('Content-Type: application/pdf');

header('Content-Disposition: attachment; filename="'. basename($filename) . '";');
header('Content-Transfer-Encoding: binary');
//header('Content-Length: ' . filesize($filename));

readfile($filename);

?> 
