<?php

namespace Noxlogic\BlogBundle\Controller;

use Noxlogic\BlogBundle\Entity\Blog;
use Noxlogic\BlogBundle\Form\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $blogs = $this->getDoctrine()->getManager()->getRepository('NoxlogicBlogBundle:Blog')->findAll();

        $transformService = $this->get('noxlogic.blogtransform.service');
        $transformService->transform($blogs);


        $api = $this->get('gravatar.api');
        $url = $api->getUrl('jthijssen@noxlogic.nl');

        return $this->render('NoxlogicBlogBundle:Default:index.html.twig', array(
            'blogs' => $blogs,
            'gravatar_url' => $url,
        ));
    }


    public function newAction(Request $request)
    {
        $blog = new Blog();
        return $this->editAction($request, $blog);
    }


    /** @secure( */
    public function editAction(Request $request, Blog $blog)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if (! $user->hasRole('ROLE_ADMIN')) {
            throw new AccessDeniedHttpException();
        }

        $form = $this->createForm(new BlogType(), $blog);

        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($blog);
                $manager->flush();

                return $this->redirect($this->generateUrl('noxlogic_blog_homepage'));
            }
        }

        return $this->render('NoxlogicBlogBundle:Default:edit.html.twig', array(
            'formulier' => $form->createView(),
            'blog' => $blog,
        ));
    }

}
