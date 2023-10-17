<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Model;
use App\Entity\Vehicle;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VehicleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $brand1 = new Brand();
        $brand1->setName('Porsche')
            ->setStatus(1);
        $manager->persist($brand1);

        $brand2 = new Brand();
        $brand2->setName('Chevrolet')
            ->setStatus(1);
        $manager->persist($brand2);

        $brand3 = new Brand();
        $brand3->setName('Aston Martin')
            ->setStatus(1);
        $manager->persist($brand3);

        $brand4 = new Brand();
        $brand4->setName('Ferrari')
            ->setStatus(1);
        $manager->persist($brand4);

        $models = [911, 356, 'Corvette', 'Camaro', 'DB6', 308, '512'];
        foreach ($models as $model) {
            $newModel = new Model();
            $newModel->setName($model)
                ->setStatus(1);

            if ($model == 911 || $model == 356) {
                $newModel->setBrand($brand1);
            } elseif ($model == 'Corvette' || $model == 'Camaro') {
                $newModel->setBrand($brand2);
            } elseif ($model == 'DB6') {
                $newModel->setBrand($brand3);
            } else {
                $newModel->setBrand($brand4);
            }

            $manager->persist($newModel);

            for ($i=1; $i <= mt_rand(3,5); $i++) {
                $vehicle = new Vehicle();
                $vehicle->setMileAge($faker->numberBetween($min=1000, $max=222000))
                    ->setYearManufacture($faker->numberBetween($min=1990, $max=2010))
                    ->setDoorNumber($faker->randomElement([3,5]))
                    ->setHorsePower($faker->randomElement([150,200,350]))
                    ->setSeatNumber($faker->randomElement([2,4,5]))
                    /*->setVehicleCondition($faker->randomElement(['Original Condition', 'Restored', 'Used with guarantee', 'Used']))*/
                    ->setVehicleCondition($faker->randomElement(['Neuf', 'Restauré', 'Occasion']))
                    ->setGearBoxType($faker->randomElement(['manual', 'automatic']))
                    ->setPrice($faker->numberBetween($min=20000, $max=500000))
                    ->setFuelType($faker->randomElement(['diesel', 'gasoline', 'ethanol']))
                    ->setRegistrationNumber($faker->regexify('[A-Z]{2}-[0-9]{3}-[A-Z]{2}'));

                if ($newModel->getName() == 911) {
                    $vehicle->setColor($faker->randomElement(['blue', 'red']));
                } elseif ($newModel->getName() == 356) {
                    $vehicle->setColor('black')
                        ->setImage('porsche-356-black.jpg');
                } elseif ($newModel->getName() == 'Corvette') {
                    $vehicle->setColor($faker->randomElement(['black', 'red']));
                } elseif ($newModel->getName() == 'Camaro') {
                    $vehicle->setColor('blue')
                        ->setImage('chevrolet-camaro-blue.webp');
                } elseif ($newModel->getName() == 'DB6') {
                    $vehicle->setColor('grey')
                        ->setImage('aston-martin-db6-grey.jpg');
                } elseif ($newModel->getName() == 308) {
                    $vehicle->setColor('red')
                        ->setImage('ferrari-308-black.jpg');
                } elseif ($newModel->getName() == '512') {
                    $vehicle->setColor('yellow')
                        ->setImage('ferrari-512-yellow.jpg');
                }

                if ($newModel->getName() == 911 && $vehicle->getColor() == 'blue') {
                        $vehicle->setImage('porsche-911-blue.webp');
                } elseif ($newModel->getName() == 911 && $vehicle->getColor() == 'red') {
                    $vehicle->setImage('porsche-911-red.jpg');
                } elseif ($newModel->getName() == 'Corvette' && $vehicle->getColor() == 'red') {
                    $vehicle->setImage('chevrolet-corvette-red.jpg');
                } elseif ($newModel->getName() == 'Corvette' && $vehicle->getColor() == 'black') {
                    $vehicle->setImage('chevrolet-corvette-black.jpg');
                }
                $vehicle->setModel($newModel);

                if ($vehicle->getVehicleCondition() === "Neuf") {
                    $vehicle->setMileAge(0);
                }

                $manager->persist($vehicle);
            }
        }

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        // TODO: Implement setContainer() method.
    }
}
