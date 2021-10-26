<?php
#    Almanak is en php and MySql based calendar to use on a web server or to incorporate in a website
#    Copyright (C) <2021>  <Maarten Verest>
#
#    This program is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program.  If not, see <https://www.gnu.org/licenses/>.


$usergroups = [translate('user 1'), translate('user 2'), translate('admin')];
$daynames = [translate('monday'), translate('tuesday'), translate('wednesday'), translate('thursday'), translate('friday'), translate('saturday'), translate('sunday')];
$monthnames = [' ', translate('january'), translate('february'), translate('march'), translate('april'), translate('may'), translate('june'), translate('july'), translate('august'), translate('september'), translate ('october'), translate('november'), translate('december')];
$numbernames = [' ', translate('first'), translate('second'), translate('third'), translate('fourth'), translate('last')];

$start_year = read_setting ('starting year of the calendar');
$future_years = read_setting ('future years of the calendar');




?>