<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    /**
     * @throws Exception
     */
    public function findRandomByCategories(array $categoryIds): ?Image
    {
        $query = 'SELECT DISTINCT image_id FROM image_category';
        $where = [];
        foreach ($categoryIds as $categoryId)
        {
            $where[] = 'image_id IN (SELECT image_id FROM image_category WHERE category_id = ?)';
        }
        $query = $query . ' WHERE ' . implode(' AND ', $where);

        $query .= ' order by rand() limit 1';

        $image = null;
        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare($query);

        foreach ($categoryIds as $key => $value)
        {
            $statement->bindValue($key+1, $value);
        }

        $result = $statement->executeQuery()->fetchAssociative();

        if($result)
        {
            $image = $this->find($result['image_id']);
        }

        return $image;
    }

    public function showAllImages(): array
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT i FROM App\Entity\Image i');
        return $query->getResult();
    }
}
