<?php

namespace App\Post\Infrastructure\Domain\Model;

use App\Post\Application\Query\ViewPostsQuery;
use App\Post\Domain\Model\Post;
use App\Post\Domain\Model\PostId;
use App\Post\Domain\Model\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class DoctrinePostRepository extends EntityRepository implements PostRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new ClassMetadata(Post::class));
    }

    public function nextIdentity() : PostId
    {
        return new PostId();
    }

    public function all(ViewPostsQuery $postsQuery) : array
    {
        $filterParameters = [];

        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select('p');
        $query->from('Post:Post', 'p');
        $query->where('1=1');

        if ($postsQuery->dateStart()) {
            $query->andwhere('p.date >= :dateStart');
            $filterParameters = array_merge($filterParameters, array('dateStart' => $postsQuery->dateStart()->format('Y-m-d')));
        }

        if ($postsQuery->dateEnd()) {
            $query->andwhere('p.date <= :dateEnd');
            $filterParameters = array_merge($filterParameters, array('dateEnd' => $postsQuery->dateEnd()->format('Y-m-d')));
        }

        if ($postsQuery->page()) {
            $query->setFirstResult(($postsQuery->page()-1)*$postsQuery->limit());
        }

        if ($postsQuery->limit()) {
            $query->setMaxResults($postsQuery->limit());
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
        $this->getEntityManager()->flush($post);
    }

    public function update(Post $post) : void
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush($post);
    }

    public function remove(Post $post) : void
    {
        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush($post);
    }
}