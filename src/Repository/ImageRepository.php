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
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function findRandomByCategories(array $categoryIds): ?Image
    {
        $query = 'select distinct image_id from image_category where image_id in (select image_id from image_category where category_id = ?)';

        foreach ($categoryIds as $key => $value)
        {
            if($key > 0)
            {
                $query .= ' and image_id in (select image_id from image_category where category_id = ?)';
            }
        }
        /*if(count($categoryIds) > 0)
        {

            for ($i = 1; $i < count($categoryIds); $i++)
            {
                $query .= ' and image_id in (select image_id from image_category where category_id = ?)';
            }

        }*/

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


}
