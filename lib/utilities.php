<?php
function createRandomPassword() {
		$chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890";
		srand((double)microtime()*1000000);
		$pass = '' ;
		for ($i = 0; $i < 10; $i++) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
		}
		return $pass;
	}

?>

