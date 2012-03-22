<?php

Class A {
	public function returnA (){
		return 'a';
	}
}

Class B extends A {
	public function returnBA(){
		return 'ba';
	}
}

Class C extends B {
	public function __construct(){
		echo parent::returnA();
	}
}
new C();

?>

