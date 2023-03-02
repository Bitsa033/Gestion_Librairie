<?php

namespace App\Controller;

use App\Service\Application as ServiceLivres;
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
        $nb_id=$service->repo_livre->get_nb_id();//nbre d'id dans la bd
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
        if (empty( $nb_id)) {
            //on incrémente $i en fonction du $nb_pages Ex: si $nb_pages=10, $i=1...10
            $nb_row="";
            //  for ($i = 1; $i <= $nb_pages; $i++) {
            //  }
         }

        if (!empty( $id_of_query)) {
            //on affiche la pagination
            $livres=$service->repo_livre->pagination($debut_de_page,$nb_el_par_page);
        }
        else {
            $livres=$service->repo_livre->pagination($query_on_null,$nb_el_par_page);
        }
        
        return $this->render('livre/index.html.twig', [
            'titre' => 'Application de gestion d\'une médiathèque !',
            'livre'=>$livres,
            'pages'=>$nb_row,
            'nb_id'=>$nb_id,
            'par_page'=>$nb_el_par_page
        ]);
    }

    /**
     * on affiche le formulaire de modification du livre
     * @Route("history_{id}", name="history")
     * @return void
     */
    public function history(ServiceLivres $service,$id)
    {
        $livre=$service->repo_livre->find($id);
        $livre_in=$service->repo_entree_livre->findBy([
            'livre'=>$service->repo_livre->find($id)
        ]);
        $livre_out=$service->repo_sortie_livre->findBy([
            'livre'=>$service->repo_livre->find($id)
        ]);
        //dd($livre);
        
        return $this->render('livre/history.html.twig',[
            'livre_in'=>$livre_in,
            'livre_out'=>$livre_out,
            'livre'=>$livre

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
    public function saveLivre(Request $request, ServiceLivres $service_livre)
    {
        if (!empty($request->request->get("nb"))) {
            $nbExemplaires=$request->request->get("nb");
        }
        else {
            $nbExemplaires=0;
        }
        if ($nbExemplaires>0) {
            
        }
        if($nbExemplaires==0) {
            return $this->json([
                'message'=>'La quantité de votre stock d\'entrée est vide, Nous ne pouvons pas l\'enregistrer !',
                'icon'=>'error'
            ]);
           //return new Response('La quantité de votre stock d\'entrée est vide, Nous ne pouvons pas l\'enregistrer !');
        }
        //dd($nbExemplaires);
        $auteur=$service_livre->table_auteur;
        $auteur->setNom($request->request->get("auteur"));
        $livre=$service_livre->table_livre;
        $livre->setNom($request->request->get("nom"));
        $livre->setGenre($request->request->get("genre"));
        $livre->setAnneeEdition($request->request->get("annee"));
        $livre->setQuantite($nbExemplaires);
        $livre->setAuteur($auteur);
        $entree=$service_livre->table_entree_livre;
        $entree->setLivre($livre);
        $entree->setQuantite($request->request->get("nb"));
        $entree->setDateE(new \Datetime);
        $service_livre->saveToDb($entree);
        // return $this->redirectToRoute('livre');
        return $this->json([
            'message'=>'Votre stock a été inséré avec succèss !',
            'icon'=>'success'
        ]);
        
    }

    /**
     * on affiche le formulaire de modification du livre
     * @Route("getLivre_{id}", name="getLivre")
     * @return void
     */
    public function getLivre(ServiceLivres $service,$id)
    {

        return $this->render('livre/getLivre.html.twig',[
            'livre'=>$service->repo_livre->find($id)
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
        if (!empty($request->request->get("nb"))) {
            $nbExemplaires=$request->request->get("nb");
        }
        else {
            $nbExemplaires=0;
        }
        $auteurName=$request->request->get("auteur");
        $livre=$service_livre->repo_livre->find($id);
        $livre->setNom($livreName);
        $livre->setAnneeEdition($anneeEdition);
        $qte_livre_db=$livre->getQuantite();
        $qte_entree_livre=$nbExemplaires + $qte_livre_db;
        $livre->setQuantite($qte_entree_livre);
        $livre->setGenre($genre);
        $livre->getAuteur()->setNom($auteurName);
        $entree=$service_livre->table_entree_livre;
        $entree->setLivre($livre);
        //dd($qte_entree_livre);
        
        $entree->setQuantite($nbExemplaires);
        $entree->setDateE(new \Datetime);
        $service_livre->saveToDb($entree);
        // $service_livre->db->flush();
        
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
            'livre'=>$service->repo_livre->find($id)
        ]);
    }

    /**
     * on diminue la quantité du livre par son id dans la bd
     * Ex:si nb_livres=18, retirer_livre(5), nb_livres=13
     * @Route("removeLivre_{id}", name="removeLivre")
     * @return void
     */
    public function removeLivre(Request $request, ServiceLivres $service,$id)
    {
        $nbExemplaires=$request->request->get("nb");

        $livre=$service->repo_livre->find($id);
        $qte_livre_db=$livre->getQuantite();
        $qte_sortie_livre=$qte_livre_db -$nbExemplaires;
        $livre->setQuantite($qte_sortie_livre);
        $sortie=$service->table_sortie_livre;
        $sortie->setLivre($livre);
        //dd($qte_entree_livre);
        
        $sortie->setQuantite($nbExemplaires);
        $sortie->setDateS(new \Datetime);
        $service->saveToDb($sortie);
        //$service->repo_livre->retirer_livre($livre,$nbExemplaires);
        
        return $this->redirectToRoute('getLivre',[
            'id'=>$livre->getId()
        ]);
    }

    /**
     * supprime un livre de la bd par son id
     *@Route("deleteLivre_{id}", name="deleteLivre")
     * @return void
     */
    public function deleteLivre(ServiceLivres $service,$id)
    {
        $livre=$service->repo_livre->find($id);
        $service->repo_livre->remove($livre);
        return $this->redirectToRoute('livre');
    }
}
