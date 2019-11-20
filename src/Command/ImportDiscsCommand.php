<?php
/**
 * Created by PhpStorm.
 * User: jme
 * Date: 11/10/2019
 * Time: 21.02
 */

namespace App\Command;

use App\Entity\Disc;
use App\Entity\Manufacturer;
use App\Entity\Type;
use App\Repository\DiscRepository;
use App\Utils\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Ramsey\Uuid\Uuid;

class ImportDiscsCommand extends Command
{
    protected static $defaultName = 'app:import-discs';

    /**
     * @var SymfonyStyle
     */
    private $io;

    private $entityManager;
    private $validator;
    private $discs;

    public function __construct(EntityManagerInterface $em,  Validator $validator, DiscRepository $discs)
    {
        parent::__construct();

        $this->entityManager = $em;
        $this->validator = $validator;
        $this->discs = $discs;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Creates users and stores them in the database')
            ->addArgument('source', InputArgument::REQUIRED, 'Full path to the source json file containing discs')
            ->addArgument('imageDir', InputArgument::REQUIRED, 'Full path to the image directory containing all images')
            ->addArgument('mapFile', InputArgument::REQUIRED, 'Full path to the file that contains mappings between filename and image hash')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        // SymfonyStyle is an optional feature that Symfony provides so you can
        // apply a consistent look to the commands of your application.
        // See https://symfony.com/doc/current/console/style.html
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $source = $input->getArgument('source');
        $imageDir = $input->getArgument('imageDir');
        $mapFile = $input->getArgument('mapFile');

        $mapFileContent = json_decode(file_get_contents($mapFile), true);

        if (!file_exists($source)) {
            $output->writeln(sprintf('Source file "%s" not found', $source));
            return;
        }

        if (!is_dir($imageDir)) {
            $output->writeln(sprintf('%s is not a directory', $imageDir));
            return;
        }

        $discs = json_decode(str_replace('Latitude64', 'Latitude 64', file_get_contents($source)), true);

        $manufacturers = [];
        array_map(
            function ($disc) use(&$manufacturers) {
                $key = str_replace(' ', '-', strtolower($disc['manufacturer']));

                $manufacturers[$disc['manufacturer']] = $key;
            },
            $discs
        );

        $types = [];
        array_map(
            function ($disc) use(&$types) {
                $key = str_replace(' ', '-', strtolower($disc['type']));

                $types[$disc['type']] = $key;
            },
            $discs
        );

        $savedManufacturers = [];
        $savedTypes = [];

        foreach ($manufacturers as $name => $key) {
            $manufacturer = new Manufacturer();
            $manufacturer->setId($key);
            $manufacturer->setName($name);
            $manufacturer->setCreatedAt(new \DateTime());
            $this->entityManager->persist($manufacturer);
            $this->entityManager->flush();
            $savedManufacturers[$name] = $manufacturer;
        }

        foreach ($types as $name => $key) {
            $type = new Type();
            $type->setId($key);
            $type->setName($name);
            $type->setCreatedAt(new \DateTime());
            $this->entityManager->persist($type);
            $this->entityManager->flush();
            $savedTypes[$name] = $type;
        }


        //print_r($manufacturers);
        //print_r($types);die;

        foreach ($discs as $discData) {
            $uuid4 = Uuid::uuid4();

            $disc = new Disc($uuid4->toString());
            $disc->setName($discData['name']);
            $disc->setType($savedTypes[$discData['type']]);
            $disc->setManufacturer($savedManufacturers[$discData['manufacturer']]);
            $disc->setMaterial($discData['material'] ?? null);
            $disc->setColor($discData['color']);
            $disc->setSpeed($discData['speed']);
            $disc->setGlide($discData['glide']);
            $disc->setStability($discData['stability']);
            $disc->setFade($discData['fade']);
            $disc->setWeight($discData['weight']);
            $disc->setIsHoleInOne($discData['Hole in one'] ?? false);
            $disc->setHoleInOneDate(!empty($discData['HIO date']) ? new \DateTime($discData['HIO date']) : null);
            $disc->setHoleInOneDescription($discData['HIO description'] ?? null);
            $disc->setIsMissing($discData['missing'] ?? false);
            $disc->setMissingDescription($discData['missing_description'] ?? null);
            $disc->setIsOwnStamp($discData['Own stamp'] ?? false);
            $disc->setIsCollectionItem($discData['collection_item'] ?? false);
            $disc->setIsSold($discData['sold'] ?? false);
            $disc->setSoldAt(!empty($discData['sold_at']) ? new \DateTime($discData['sold_at']) : null);
            $disc->setSoldFor($discData['sold_for'] ?? null);
            $disc->setIsDonated($discData['donated'] ?? false);
            $disc->setDonationDescription($discData['Donation description'] ?? null);
            $disc->setPrice($discData['price'] ?? null);
            $disc->setPriceStatus($discData['price_status'] ?? null);
            $disc->setCreatedAt(new \DateTime($discData['_created']));
            $disc->setUpdatedAt(new \DateTime($discData['_changed']));

            if (isset($discData['image']) && count($discData['image'])) {
                if (isset($mapFileContent[$discData['image'][0]])) {
                    $disc->setImage($mapFileContent[$discData['image'][0]]);
                }
            }

            $this->entityManager->persist($disc);
            $this->entityManager->flush();
        }
    }
}
