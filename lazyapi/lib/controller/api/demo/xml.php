<?php
class Controller_Api_Demo_Xml extends Controller_Api_Base {

	public function act() {
		echo "
		<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>
		<User>
			<Name>LazyBug</Name>
			<Sex>M</Sex>
			<Age>18</Age>
			<Address>ShangHai. CHINA.</Address>
			<Friends>
				<Friend Title=\"Best\" Order=\"1\">Kevin</Friend>
				<Friend Order=\"2\">John</Friend>
				<Friend Order=\"3\">Lily</Friend>
			</Friends>
		</User>";
	}
}