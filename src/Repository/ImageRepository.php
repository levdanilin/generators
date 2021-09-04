<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

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
    public function findRandomByCategories(array $categoryIds): Image
    {
        $query = 'select distinct image_id from image_category where image_id in (select image_id from image_category where category_id = ' . $categoryIds[0] . ')';

        if(count($categoryIds) > 0)
        {

            for ($i = 1; $i < count($categoryIds); $i++)
            {
                $query .= ' and image_id in (select image_id from image_category where category_id = ' . $categoryIds[$i] . ')';
            }

        }

        $query .= ' order by rand() limit 1';

        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare($query);
        $imageId = $statement->executeQuery()->fetchAssociative()['image_id'];
        //dump($this->find($imageId));die;
        return $this->find($imageId);






        /*$rsm = new ResultSetMapping();
        $statement = $em->createNativeQuery($query, $rsm);
        dump($statement->getArrayResult());die;
        $image_id = $statement->getResult();
        dump($image_id);die;*/



       /* $qb = $em->createQueryBuilder('i');
        $qb
            ->select('i.id', 'i.filename', 'i.path')
            ->from('App:Image', 'i')
            ->join('i.categories', 'ic', 'WITH', 'ic.id = 1 or ic.id = 2');
            //->where('i.id = 14');
        $query = $qb->getQuery();
        dump($query->getResult());die;*/

        /*$query = 'select * from image join image_category on image.id = image_id where category_id = ' . $categoryIds[0];

        if(count($categoryIds) > 1)
        {
            for ($i = 1; $i < count($categoryIds); $i++)
            {
                $query .= ' or category_id = ' . $categoryIds[$i];
            }
        }

        $query .= ' order by rand() limit 1';

        $queryBuilder = $this->createQueryBuilder('i');
        $queryBuilder
        ->select()

        dump($query);die;

        $em = $this->getEntityManager();
        $statement = $em->createQuery($query);
        dump($statement->getResult());die;
        return $statement->getResult();*/
    }


}
