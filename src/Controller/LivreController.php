<?php

namespace App\Controller;
use App\Service\Livres as ServiceLivres;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{
    /**
     * @Route("/", name="livre")
     */
    public function index(ServiceLivres $livres): Response
    {
        return $this->render('livre/index.html.twig', [
            'titre' => 'Application de gestion d\'une médiathèque !',
            'livre'=>$livres->getAllData()
        ]);
    }
    /**
     * @Route("addLivre", name="addLivre")
     * @return void
     */
    public function addLivre(Request $request, ServiceLivres $livre)
    {
        $livreName=$request->request->get("nom");
        $genre=$request->request->get("genre");
        $anneeEdition=$request->request->get("annee");
        $nbExemplaires=$request->request->get("nb");
        $auteurName=$request->request->get("auteur");
        $livre->saveData(compact(
            "livreName",
            "genre",
            "anneeEdition",
            "nbExemplaires",
            "auteurName",
        ));
        return $this->redirectToRoute('livre');
    }
}
