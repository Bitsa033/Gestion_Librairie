<?php

namespace App\Controller;

use App\Repository\LivreRepository;
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
    public function index(Request $request,ServiceLivres $service,LivreRepository $l): Response
    {
        $nb_id=$l->get_nb_id();
        $nb_el_par_page=2;
        $nb_pages=ceil($nb_id/$nb_el_par_page);
        $id_of_query=$request->query->get('id');
        $debut_de_page=($id_of_query-1) * $nb_el_par_page;
        //$nb_row = array(1);
        if (!empty( $nb_id)) {
           
            for ($i = 1; $i < $nb_pages; $i++) {
                $nb_row[$i] = $i;
            }
        }

        if (!empty( $id_of_query)) {
            $livres=$l->pagination($debut_de_page,$nb_el_par_page);
        }
        else {
            $livres="";
        }
        
        return $this->render('livre/index.html.twig', [
            'titre' => 'Application de gestion d\'une médiathèque !',
            'livre'=>$livres,
            'pages'=>$nb_row
        ]);
    }

    /**
     * @Route("livreAdd", name="livreAdd")
     * @return void
     */
    public function livreAdd()
    {
        return $this->render('livre/livreAdd.html.twig',[]);
    }

    /**
     * @Route("livreForSale", name="livreForSale")
     * @return void
     */
    public function livreForSale()
    {
        return $this->render('livre/livreForSale.html.twig',[]);
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
