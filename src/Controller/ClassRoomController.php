<?php

namespace App\Controller;

use App\Entity\ClassRoom;
use App\Form\ActiveType;
use App\Form\ClassRoomType;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/class/room")
 */
class ClassRoomController extends AbstractController
{
    /**
     * @Route("/", name="class_room_index", methods={"GET"})
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index(ApiService $apiService): Response
    {
        $classRoom = $apiService->getAllClassRoom();
        return $this->render('class_room/index.html.twig', [
            'class' => $classRoom
        ]);
    }

    /**
     * @Route("/change-active/{id}", name="class_room_change_active")
     * @param int $id
     * @param Request $request
     * @param ApiService $service
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changeActive(
        Request $request,
        ApiService $service,
        $id
    )
    {
        $class = $service->getClass($id);
        $form = $this->createForm(ActiveType::class, $class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $result = $service->changeClassRoomActive($id, $active = $form->getData()["active"]);
            dd($result);

//            return $this->redirectToRoute('class_room_index');
            return new Response(
                $result ? $commenter->comment($id, $active, $this->getUser()) : "",
                $result ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->render("class_room/change_active.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="class_room_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $classRoom = new ClassRoom();
        $form = $this->createForm(ClassRoomType::class, $classRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classRoom);
            $entityManager->flush();

            return $this->redirectToRoute('class_room_index');
        }

        return $this->render('class_room/new.html.twig', [
            'class_room' => $classRoom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="class_room_show", methods={"GET"})
     * @param ApiService $apiService
     * @param $id
     * @return Response
     */
    public function show(ApiService $apiService, $id): Response
    {
        $classRoom = $apiService->getClass($id);
        return $this->render('class_room/show.html.twig', [
            'class' => $classRoom,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="class_room_edit", methods={"GET","POST"})
     * @param Request $request
     * @param ClassRoom $classRoom
     * @return Response
     */
    public function edit(Request $request, ClassRoom $classRoom): Response
    {
        $form = $this->createForm(ClassRoomType::class, $classRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('class_room_index');
        }

        return $this->render('class_room/edit.html.twig', [
            'class_room' => $classRoom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="class_room_delete")
     * @param ApiService $apiService
     * @param $id
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(ApiService $apiService, $id): Response
    {
        if ($apiService->removeClass($id)) {
            return $this->redirectToRoute('class_room_index');
        }
        return $this->redirectToRoute('class_room_index');
    }
}
