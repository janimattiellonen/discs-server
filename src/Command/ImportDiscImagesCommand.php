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

class ImportDiscImagesCommand extends Command
{
    protected static $defaultName = 'app:import-disc-images';

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
            ->setDescription('Import disc images')
            ->addArgument('source', InputArgument::REQUIRED, 'Full path to the source json file containing discs')
            ->addArgument('imageDir', InputArgument::REQUIRED, 'Full path of the directory, where images will be stored')
            ->addArgument('outputMapFile', InputArgument::REQUIRED, 'Full path of the mapping file, which stores image hash and image file name mappings.')
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
        $outputMapFile = $input->getArgument('outputMapFile');

        if (!file_exists($source)) {
            $output->writeln(sprintf('Source file "%s" not found', $source));
            return;
        }

        if (!is_dir($imageDir)) {
            $output->writeln(sprintf('%s is not a directory', $imageDir));
            return;
        }

        $discs = json_decode(file_get_contents($source), true);

        $imageMappings = [];

        $i = 0;
        $skippedCount = 0;
        foreach ($discs as $disc) {
            if (empty($disc['image']) || empty($disc['image'][0])) {
                $skippedCount++;
                continue;
            }

            $imageHash = $disc['image'][0];
            $restDbImagePath = sprintf('https://testdb-8e20.restdb.io/media/%s', $imageHash);

            $localImagePath = sprintf('%s/%s.png', $imageDir, $imageHash);

            file_put_contents($localImagePath, file_get_contents($restDbImagePath));

            $imageMappings[$imageHash] = [
                'hash' => $imageHash,
                'localPath' => $localImagePath,
                'internalPath' => sprintf('discs/%s.png', $imageHash),
            ];

            if ($i % 10 === 0) {
                $output->writeln(sprintf('%d/%d', $i, count($discs)));
            }
            $i++;
        }

        $output->writeln(sprintf('%d/%d', count($discs), count($discs)));

        $output->writeln(sprintf('Skipped %d image(s).', $skippedCount));
        file_put_contents($outputMapFile, json_encode($imageMappings));

        // https://testdb-8e20.restdb.io/media/575bfc83376c9f6f00000005
    }
}
