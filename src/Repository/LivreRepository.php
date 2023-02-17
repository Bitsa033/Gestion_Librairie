<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use PDO;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Livre $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function connection_to_databse(){

        try {
            $pdo=new \PDO('mysql:host=localhost;dbname=mediatheque','root','');
        } catch (Exception $th) {
            die( "Base de données introuvable ! ");
        }

        return $pdo;
    }
    
    public function get_nb_id()
    {
        $conn = $this->connection_to_databse();
        $sql = '
        SELECT count(id) as id from livre
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $tab=$stmt->fetch();
        // returns an array of arrays (i.e. a raw data set)
        return $tab['id'];
        
    }

    public function pagination($debut,$fin)
    {
        $conn = $this->connection_to_databse();
        $sql = '
        SELECT livre.id as idl,livre.nom as noml,annee_edition,genre,quantite, auteur.nom as auteur
        from livre inner join auteur on auteur.id=livre.auteur_id order by livre.id desc limit
        ' .$debut. ',' .$fin;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $tab=$stmt->fetchAll();
        // returns an array of arrays (i.e. a raw data set)
        return $tab;
        
    }

    // public function nb(Compte $compte,$somme)
    // {
    //     $conn = $this->_em->getConnection();
    //     $sql = '
    //         update compte set solde = solde + :somme where id= :compte
    //     ';
    //     $stmt = $conn->prepare($sql);
    //     $stmt->executeQuery([
    //         'compte'=>$compte->getId(),
    //         'somme'=>$somme
    //     ]);

    //     //$resultat=$stmt->fetchAll();

    //     // returns an array of arrays (i.e. a raw data set)
    //     //return $resultat;
        
    // }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Livre $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
