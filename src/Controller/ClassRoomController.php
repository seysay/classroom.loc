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
 * Class ClassRoomController
 * @package App\Controller
 */
class ClassRoomController extends AbstractController
{
    /**
     * @Route("/", name="class_room_index")
     * @param ApiService $apiService
     * @return Response
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
     * @param Request $request
     * @param ApiService $service
     * @param $id
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changeActive(
        Request $request,
        ApiService $service,
        $id
    )
    {
        $entity = $service->getClass($id);
        $form = $this->createForm(ActiveType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->changeClassRoomActive($id, $active = $form->getData()["active"]);

            return $this->redirectToRoute('class_room_index');
        }

        return $this->render("class_room/change_active.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="class_room_new")
     * @param Request $request
     * @param ApiService $apiService
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function new(Request $request, ApiService $apiService)
    {
        $entity = new ClassRoom();
        $form = $this->createForm(ClassRoomType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apiService->createClassRoom($entity->getApiSchema());

            return $this->redirectToRoute('class_room_index');

        }

        return $this->render('class_room/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="class_room_show")
     * @param ApiService $apiService
     * @param $id
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show(ApiService $apiService, $id): Response
    {
        $classRoom = $apiService->getClass($id);
        return $this->render('class_room/show.html.twig', [
            'class' => $classRoom,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="class_room_edit")
     * @param Request $request
     * @param ClassRoom $classRoom
     * @param ApiService $apiService
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function edit(Request $request, ClassRoom $classRoom, ApiService $apiService)
    {
        $form = $this->createForm(ClassRoomType::class, $classRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apiService->editClassRoom($classRoom->getId(), $classRoom->getApiSchema());

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
