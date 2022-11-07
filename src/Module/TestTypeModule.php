<?php


namespace App\Module;


use App\Entity\TestType;
use App\Repository\TestTypeRepository;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TestTypeModule extends BasicModule
{
    private TestTypeRepository $testTypeRepository;

    #[Pure]
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator,
                                        TestTypeRepository $testTypeRepository)
    {
        parent::__construct($registry, $validator);
        $this->testTypeRepository = $testTypeRepository;
    }

    /**
     * @return TestType[]
     */
    public function getTestTypes(): array
    {
        return $this->testTypeRepository->findAll();
    }
}