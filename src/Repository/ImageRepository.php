<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function findRandomByCategories(array $categoryIds): Image
    {
        $query = 'select * from image join image_category on image.id = image_id where category_id = ' . $categoryIds[0];

        if(count($categoryIds) > 1)
        {
            for ($i = 1; $i < count($categoryIds); $i++)
            {
                $query .= ' or category_id = ' . $categoryIds[$i];
            }
        }

        $query .= ' order by rand() limit 1';
        //dump($query);die;

        $em = $this->getEntityManager();
        $statement = $em->createQuery($query);
        dump($statement);die;
        return $statement->getResult();
    }


}
