<?php

declare(strict_types = 1);

namespace App\Post\Infrastructure\Domain\Model;

use App\Post\Domain\Model\Post;
use App\Post\Domain\Model\PostId;
use App\Post\Domain\Model\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

final class DoctrinePostRepository extends EntityRepository implements PostRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new ClassMetadata(Post::class));
    }

    public function nextIdentity() : PostId
    {
        return new PostId();
    }

    public function all(?int $limit = null, ?int $page = null, ?\DateTime $dateStart = null, ?\DateTime $dateEnd = null) : array
    {
        $filterParameters = [];

        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select('p');
        $query->from('Post:Post', 'p');
        $query->where('1=1');

        if ($dateStart) {
            $query->andwhere('p.date >= :dateStart');
            $filterParameters = array_merge($filterParameters, array('dateStart' => $dateStart->format('Y-m-d')));
        }

        if ($dateEnd) {
            $query->andwhere('p.date <= :dateEnd');
            $filterParameters = array_merge($filterParameters, array('dateEnd' => $dateEnd->format('Y-m-d')));
        }

        if ($page && $limit) {
            $query->setFirstResult(($page-1)*$limit);
        }

        if ($limit) {
            $query->setMaxResults($limit);
        }

        $query->orderBy('p.date');

        $query->setParameters($filterParameters);

        return $query->getQuery()->getResult();
    }

    public function ofId(PostId $id) : ?Post
    {
        return $this->find($id);
    }

    public function add(Post $post) : void
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush();
    }

    public function remove(Post $post) : void
    {
        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush();
    }
}
