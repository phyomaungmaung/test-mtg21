<?php

class Dog{
	public $name;
	static $age=4;
	function __construct($name){
		$this->name=$name;
	}

	private function bark(){
		Dog::$age++;
		return $this->name." says woff woff".Dog::$age;

	}
}

$dog1=new Dog("bobo");
echo $dog1->bark();
$dog2=new Dog("peypey");
echo $dog2->bark();