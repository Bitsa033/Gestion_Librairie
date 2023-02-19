<?php

namespace App\Controller;

use App\Service\Auteurs;
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
        $query_on_null=(1-1) * $nb_el_par_page;//on calcule la limite inférieure [ si $id_of_query==null ]
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
            $livres=$service->repo->pagination($query_on_null,$nb_el_par_page);;
        }
        
        return $this->render('livre/index.html.twig', [
            'titre' => 'Application de gestion d\'une médiathèque !',
            'livre'=>$livres,
            'pages'=>$nb_row
        ]);
    }

    /**
     * on affiche le formulaire d'enregistrement du livre
     * @Route("addLivre", name="addLivre")
     * @return void
     */
    public function addLivre()
    {
        return $this->render('livre/addLivre.html.twig',[]);
    }

    /**
     * on enregistre le livre dans la bd
     * @Route("saveLivre", name="saveLivre")
     * @return void
     */
    public function saveLivre(Request $request, ServiceLivres $service_livre,Auteurs $service_auteur)
    {
        $livre=$service_livre->table;
        $auteur=$service_auteur->table;
        $auteur->setNom($request->request->get("auteur"));
        $livre->setNom($request->request->get("nom"));
        $livre->setGenre($request->request->get("genre"));
        $livre->setAnneeEdition($request->request->get("annee"));
        $livre->setQuantite($request->request->get("nb"));
        $livre->setAuteur($auteur);
        $service_livre->saveToDb($livre);
        return $this->redirectToRoute('livre');
    }

    /**
     * on affiche le formulaire de modification du livre
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
     * on modifie les données du livre par son id dans la bd
     * @Route("updateLivre_{id}", name="updateLivre")
     * @return void
     */
    public function updateLivre(Request $request, ServiceLivres $service_livre,$id)
    {
        $livreName=$request->request->get("nom");
        $genre=$request->request->get("genre");
        $anneeEdition=$request->request->get("annee");
        $nbExemplaires=$request->request->get("nb");
        $auteurName=$request->request->get("auteur");

        $livre=$service_livre->repo->find($id);
        $livre->setNom($livreName);
        $livre->setAnneeEdition($anneeEdition);
        $livre->setQuantite($nbExemplaires);
        $livre->setGenre($genre);
        $livre->getAuteur()->setNom($auteurName);

        $service_livre->db->flush();
        
        return $this->redirectToRoute('livre');
    }

    /**
     * on affiche le formulaire pour diminuer la quantité du livre
     * @Route("forGiveLivre_{id}", name="forGiveLivre")
     * @return void
     */
    public function forGiveLivre(ServiceLivres $service,int $id)
    {
        return $this->render('livre/forGiveLivre.html.twig',[
            'livre'=>$service->repo->find($id)
        ]);
    }

    /**
     * on diminue la quantité du livre par son id dans la bd
     * @Route("removeLivre_{id}", name="removeLivre")
     * @return void
     */
    public function removeLivre(Request $request, ServiceLivres $service,$id)
    {
        $nbExemplaires=$request->request->get("nb");

        $livre=$service->repo->find($id);
        $service->repo->retirer_livre($livre,$nbExemplaires);
        
        return $this->redirectToRoute('getLivre',[
            'id'=>$livre->getId()
        ]);
    }

    /**
     *@Route("deleteLivre_{id}", name="deleteLivre")
     * @return void
     */
    public function deleteLivre(ServiceLivres $service,$id)
    {
        $livre=$service->repo->find($id);
        $service->repo->remove($livre);
        return $this->redirectToRoute('livre');
    }
}
