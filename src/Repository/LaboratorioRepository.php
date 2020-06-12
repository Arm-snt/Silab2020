<?php

namespace App\Repository;

use App\Entity\Laboratorio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Laboratorio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Laboratorio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Laboratorio[]    findAll()
 * @method Laboratorio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LaboratorioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Laboratorio::class);
    }

    public function Mostrar(){
        try {
            $conn = $this->getEntityManager()->getConnection();
            $stm = $conn->prepare("SELECT lab.id, lab.codlaboratorio, lab.nombre, lab.ubicacion, lab.usuario_id, lab.observacion
            FROM laboratorio lab, usuario usu
            GROUP BY lab.id");
            $stm->execute([]);
            $res = $stm->fetchAll();
            return $res;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function Insertar($codlaboratorio, $usuario_id, $nombre, $ubicacion, $observacion){
        try {
            $conn = $this->getEntityManager()->getConnection();
            $stm = $conn->prepare(" INSERT INTO laboratorio (codlaboratorio, usuario_id, nombre, ubicacion, observacion) VALUES (:codlaboratorio, :usuario_id, :nombre, :ubicacion, :observacion)");
            if($stm->execute(array(':codlaboratorio'=>$codlaboratorio, ':usuario_id'=>$usuario_id, ':nombre'=>$nombre, ':ubicacion'=>$ubicacion, ':observacion'=>$observacion)));
        } catch (Exception $e) {
            return $e;
        }
    }


    public function Buscar($id){
        try {
            $conn = $this->getEntityManager()->getConnection();
            $stm = $conn->prepare(" SELECT lab.codlaboratorio, lab.nombre, lab.ubicacion, lab.observacion, lab.usuario_id
            FROM laboratorio lab
            WHERE lab.id=:lab");
            $lab=$id;
            if($stm->execute(array(':lab'=>$lab)))
            $res = $stm->fetch();
            return $res;
        } catch (Exception $e) {
            return $e;
        }
    }

    
    public function Actualizar($id, $codlaboratorio, $usuario_id, $nombre, $ubicacion, $observacion){
        try {
            $conn = $this->getEntityManager()->getConnection();
            $stm = $conn->prepare(" UPDATE laboratorio SET  codlaboratorio=:codlaboratorio, nombre=:nombre, ubicacion=:ubicacion, observacion=:observacion, usuario_id = :usuario_id  WHERE laboratorio.id =:id");
            if($stm->execute(array(':id'=>$id, ':codlaboratorio' =>$codlaboratorio, ':nombre' =>$nombre, ':ubicacion' =>$ubicacion,':observacion'=>$observacion,  ':usuario_id' =>$usuario_id )));
        } catch (Exception $e) {
            return $e;
        }
    }

    public function Eliminar($id){
        try {
            $conn = $this->getEntityManager()->getConnection();
            $stm = $conn->prepare(" DELETE FROM laboratorio WHERE laboratorio.id =:id");
            if($stm->execute(array(':id'=>$id)));
        } catch (Exception $e) {
            return $e;
        }
    }




    // /**
    //  * @return Laboratorio[] Returns an array of Laboratorio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Laboratorio
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}