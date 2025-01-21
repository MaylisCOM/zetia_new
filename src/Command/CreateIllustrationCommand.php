<?php

namespace App\Command;

use App\Entity\Categorie;
use App\Entity\Illustration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class CreateIllustrationCommand extends Command
{
    protected static $defaultName = 'app:create-illustration';
    protected static $defaultDescription = 'Create three illustrations';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->setName('app:create-illustration');
            
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $illustration = [
            ['categorie' => 1,'name' => 'premiére', 'price' => 20,'description'=>'illustration 1','image1'=>'femme.svg','image2'=>'femme.svg','image3'=>'femme.svg'],
            ['categorie' => 1,'name' => 'seconde', 'price' => 30,'description'=>'illustration 2','image1'=>'femme.svg','image2'=>'femme.svg','image3'=>'femme.svg'],
            ['categorie' => 1,'name' => 'troisiéme', 'price' => 40,'description'=>'illustration 3','image1'=>'femme.svg','image2'=>'femme.svg','image3'=>'femme.svg'],
        ];
   

        foreach ($illustration as $illustrationData) {
            $illustration = new Illustration();
            $categorie = $this->entityManager->getRepository(Categorie::class)->find($illustrationData['categorie']);

            if (!$categorie) {
                $io->error('Categorie not found');
                return Command::FAILURE;
            }
            $illustration->setCategorie($categorie);
            $illustration->setName($illustrationData['name']);           
            $illustration->setPrice($illustrationData['price']);
            $illustration->setDescription($illustrationData['description']);
            $illustration->setImage1($illustrationData['image1']);
            $illustration->setImage2($illustrationData['image2']);
            $illustration->setImage3($illustrationData['image3']);
            $this->entityManager->persist($illustration);
        }

        $this->entityManager->flush();

        $io->success('Three illustration have been created successfully.');

        return Command::SUCCESS;
    }
}