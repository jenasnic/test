<?php

namespace App\Controller;

use App\Entity\User;
use App\Enum\UserTypeEnum;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/new", name="user_new", methods={"GET","POST","PATCH"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->edit($request, $entityManager, new User());
    }

    /**
     * @Route("/user/{id}/edit", name="user_edit", methods={"GET","POST","PATCH"})
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, User $user): Response
    {
        $isPatch = $request->isMethod(Request::METHOD_PATCH);

        $form = $this->createForm(UserType::class, $user, [
            'method' => $isPatch ? Request::METHOD_PATCH : Request::METHOD_POST,
            'validation_groups' => function (FormInterface $form) {
                $user = $form->getData();
                return UserTypeEnum::CAR === $user->getType() ? ['car'] : ['passport'];
            },
        ]);

        $form->handleRequest($request);

        if (!$isPatch && $form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
