<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
         $empArray = [
             ['name' => 'Akash Rastogi', 'age' => 29, 'doj' => new \DateTime('12-12-2018')],
             ['name' => 'Phyllidia Greg', 'age' => 32, 'doj' => new \DateTime('16-02-2017')],
         ];
         foreach ($empArray as $key => $value) {
             $employee = new Employee();
             foreach ($value as $prop => $val) {
                 $method = 'set' . ucfirst($prop);
                 $employee->$method($val);
                 $manager->persist($employee);
             }
             $manager->flush();
         }
    }
}
