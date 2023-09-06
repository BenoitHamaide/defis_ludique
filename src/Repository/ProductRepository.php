<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Recherche les produits en fonction des critères de nom et de référence.
     *
     * @param string $nom      Le nom du produit à rechercher.
     * @param string $reference La référence du produit à rechercher (peut être vide).
     *
     * @return Product[] Un tableau d'objets Product correspondant aux critères de recherche.
     */
    public function findBySearchCriteria($nom, $reference)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->andWhere('p.nom LIKE :nom')
            ->setParameter('nom', '%' . $nom . '%');

        if (!empty($reference)) {
            $queryBuilder->andWhere('p.reference = :reference')
                ->setParameter('reference', $reference);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
