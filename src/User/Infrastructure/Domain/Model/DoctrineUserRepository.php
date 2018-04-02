<?php

declare(strict_types = 1);

namespace App\User\Infrastructure\Domain\Model;

use App\User\Domain\Model\User;
use App\User\Domain\Model\UserId;
use App\User\Domain\Model\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

final class DoctrineUserRepository extends EntityRepository implements UserRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new ClassMetadata(User::class));
    }

    public function nextIdentity() : UserId
    {
        return new UserId();
    }

    public function all(?int $limit = null, ?int $page = null) : array
    {
        $filterParameters = [];

        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select('u');
        $query->from('User:User', 'u');
        $query->where('1=1');

        if ($page && $limit) {
            $query->setFirstResult(($page-1)*$limit);
        }

        if ($limit) {
            $query->setMaxResults($limit);
        }

        $query->orderBy('u.username');

        $query->setParameters($filterParameters);

        return $query->getQuery()->getResult();
    }

    public function ofId(UserId $id) : ?User
    {
        return $this->find($id);
    }

    public function of(?string $username, ?string $email) : ?User
    {
        $arrayQuery = array();
        if ($username) {
            $arrayQuery["username"] = $username;
        }

        if ($email) {
            $arrayQuery["email"] = $email;
        }

        return $this->findOneBy($arrayQuery);
    }

    public function add(User $user) : void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function remove(User $user) : void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }
}
