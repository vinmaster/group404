<?php

class Person {
    public $age = 'bar';
    
    public function getAge() {
        return $this->age;
    }
}

$p = new Person();
echo 'funcction: '.$p->getAge();
echo 'variable: '.$p->age;

echo 'End Page';

?>