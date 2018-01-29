<?php

namespace App\Post\Infrastructure\Domain\Model;

use App\Post\Domain\Model\Post;
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

    public function all() : array
    {
        return $this->findAll();
    }

    public function ofId(int $id) : Post
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