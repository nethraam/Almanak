<!--
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
-->


<div id="menu_container">
	
	<div id="logged_in"><?php echo " ".translate('logged in as')." ";?>
		<a href="add_update_user.php?user_id=<?php echo $_SESSION['user_id']; ?>" onclick="window.open('add_update_user.php?user_id=<?php echo $_SESSION['user_id'];?>','update user', 'width=400,height=425,top=100,left=100,scrollbars=no,toolbar=no,location=no'); return false"> <?php echo $_SESSION['username']; ?> </a> | <a href="logout.php"><?php echo translate('logout'); ?></a>
	</div>
	
	<div id="menu">
		
		<a class="toggleMenu" href="#" style="display: none;"><span>Menu</span></a>
		
		<ul class="nav">
		<li><a href="year.php"><?php echo translate('year view'); ?></a></li>
		<li><a href="month.php"><?php echo translate('month view'); ?></a></li>
		<li><a href="list.php"><?php echo translate('list view'); ?></a></li>
		<li><a href="add_update_event.php" onclick="window.open('add_update_event.php','add event', 'width=400,height=425,top=100,left=100,scrollbars=no,toolbar=no,location=no'); return false"><?php echo translate('add event') ?></a></li>
		<?php if ($_SESSION['group_id'] == '2' ) echo "<li><a href=\"users.php\">".translate ('users')."</a></li>" ?>
			<?php if ($_SESSION['group_id'] == '2' ) echo "<li><a href=\"settings.php\">".translate ('settings')."</a></li>" ?>
		</ul>	
	</div>

	

</div>

<div id="content">