<?php

namespace App\Controller;

header('Access-Control-Allow-Origin: *');

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SchoolController extends AbstractController
{
    public function findAllSchools(){
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT s.id, s.name, s.street, s.created, s.updated, s.status  FROM App:School s');
        $listSchools = $query->getResult();

        $data = [
            'status'=> 200,
            'message'=> 'No se encontraron resultados',
            'listSchools' => $listSchools
        ];

        if(count($listSchools)>0){
            $data = [
                'status'=> 200,
                'message'=> 'Se encontraron '.count($listSchools) .' resultados',
                'listSchools' => $listSchools
            ];
        }

        return new JsonResponse($data);
    }

    public function createSchool (Request $request){
        $em = $this->getDoctrine()->getManager();

            $name = $request->get('name', null);
            $street = $request->get('street', null);
            $created = date_create("now");
            $updated = date_create("now");

            $school = new \App\Entity\School();

            $school->setName($name);
            $school->setStreet($street);
            $school->setCreated($created);
            $school->setUpdated($updated);
            $school->setStatus(1);

            $em->persist($school);
            $em->flush();
    
            $data = [
                'status'=> 200,
                'message'=> 'Se ha creado correctamente ',
                'school' => $school
            ];

        return new JsonResponse($data);
    }

    public function deleteSchool($id){
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('UPDATE App:School s SET s.status = 0, s.updated = :updated WHERE s.id = :id');
        $query->setParameter(':id', $id);
        $query->setParameter(':updated', date_create("now"));
        $school = $query->getResult();

        $data = [
            'status'=> 200,
            'message'=> 'Se ha deshabilitado la escuela ',
            'school' => $school
        ];

        return new JsonResponse($data);
    }

    public function schoolById ($id){
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT s.id, s.name, s.street, s.created, s.updated, s.status  FROM App:School s WHERE s.id = :s');
        $query->setParameter(':s', $id);
        $school = $query->getResult();


        $data = [
            'status'=> 200,
            'message'=> 'Se encontró la escuela',
            'school' => $school
        ];

        return new JsonResponse($data);
    }

    public function updateSchool(Request $request, $id){
        $em = $this->getDoctrine()->getManager();

        $name = $request->get('name', null);
        $street = $request->get('street', null);

        $query = $em->createQuery('UPDATE App:School s SET s.name= :name, s.street = :street, s.updated = :updated WHERE s.id = :id');
        $query->setParameter(':name', $name);
        $query->setParameter(':street', $street);
        $query->setParameter(':updated', date_create("now"));
        $query->setParameter(':id', $id);
        $flag = $query->getResult();

        if($flag == 1){
            $data=[
                'status'=>200,
                'message'=>'Se ha actualizado correctamente'
            ];
        }else{
            $data=[
                'status'=>200,
                'message'=>'No se ha actualizado correctamente'
            ];
        }

        return new JsonResponse($data);
    }
}
