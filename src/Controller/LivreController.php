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
     * on crée un système de pagination
     * on consulte tous les enregistrements
     * @Route("/", name="livre")
     */
    public function index(Request $request,ServiceLivres $service): Response
    {
        $nb_id=$service->repo->get_nb_id();//nbre d'id dans la bd
        $nb_el_par_page=5; //nbre d'éléments par page
        $nb_pages=ceil($nb_id/$nb_el_par_page);//on calcule le nbre de pages
        $id_of_query=$request->query->get('id');//on recupère l'id dans le $_GET
        $debut_de_page=($id_of_query-1) * $nb_el_par_page;//on calcule la limite inférieure
        if (!empty( $nb_id)) {
           //on incrémente $i en fonction du $nb_pages Ex: si $nb_pages=10, $i=1...10
            for ($i = 1; $i <= $nb_pages; $i++) {
                $nb_row[$i] = $i;
            }
        }

        if (!empty( $id_of_query)) {
            //on affiche la pagination
            $livres=$service->repo->pagination($debut_de_page,$nb_el_par_page);
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
     * @Route("addLivre", name="addLivre")
     * @return void
     */
    public function addLivre()
    {
        return $this->render('livre/addLivre.html.twig',[]);
    }

    /**
     * formulaire de modification du livre
     * @Route("getLivre_{id}", name="getLivre")
     * @return void
     */
    public function getLivre(ServiceLivres $service,$id)
    {

        return $this->render('livre/getLivre.html.twig',[
            'livre'=>$service->repo->find($id)
        ]);
    }

    /**
     * @Route("forGiveLivre", name="forGiveLivre")
     * @return void
     */
    public function forGiveLivre(ServiceLivres $service)
    {
        return $this->render('livre/forGiveLivre.html.twig',[
            'livre'=>$service
        ]);
    }

    /**
     * @Route("saveLivre", name="saveLivre")
     * @return void
     */
    public function saveLivre(Request $request, ServiceLivres $livre)
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

    /**
     * @Route("updateLivre_{id}", name="updateLivre")
     * @return void
     */
    public function updateLivre(Request $request, ServiceLivres $service,$id)
    {
        $livreName=$request->request->get("nom");
        $genre=$request->request->get("genre");
        $anneeEdition=$request->request->get("annee");
        $nbExemplaires=$request->request->get("nb");
        $auteurName=$request->request->get("auteur");

        $livre=$service->repo->find($id);
        $livre->setNom($livreName);
        $livre->setAnneeEdition($anneeEdition);
        $livre->setQuantite($nbExemplaires);
        $livre->setGenre($genre);
        //$livre->setAuteur($auteurName);

        $service->db->flush();
        
        return $this->redirectToRoute('livre');
    }
}
