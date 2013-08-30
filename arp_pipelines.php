<?php
/**
 * Utilisations de pipelines par ARP
 *
 * @plugin     ARP
 * @copyright  2013
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\Arp\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;
	
function arp_recuperer_fond($flux){
    
    if ($flux['args']['fond'] == 'formulaires/inc-enchere_mise_palier_encherissement'){
        $champs = recuperer_fond('formulaires/inc_enchere_mise_super_encherisseur_champs',$flux['data']);
        $flux['data']['texte'] = str_replace('<div class="montant_actuel">',$champs. '<div class="montant_actuel">' , $flux['data']['texte']);
    }
    return $flux;
}
 
function arp_formulaire_charger($flux){
    $form = $flux['args']['form'];
    if ($form == 'enchere_mise'){
        $flux['data']['clients'] .= "";
    }
    
    return $flux;
}

function arp_formulaire_verifier($flux){
    $form = $flux['args']['form'];
    if ($form == 'enchere_mise'){
        if($clients=_request('clients')){
            list($nom,$email)=explode(',',$clients);
            if(!$nom OR !$email)$flux['data']['clients']='indiquez le nom suivis d\'une virgule et du email';
            else{
                set_request('nom',$nom);
                set_request('email',$email); 

                if(!$id_auteur=sql_getfetsel('id_auteur','spip_auteurs','email='.sql_quote($email))){
                    include_spip('inc/editer');  
                    set_request('role','client_agence');      
                    $res = formulaires_editer_objet_traiter('auteur','new');
                    $id_auteur=$res['id_auteur'];
                    sql_updateq('spip_auteurs',array('statut'=>'6forum'),'id_auteur='.$id_auteur);
                }
                if($id_auteur){spip_log(_request('id_auteur').$id_auteur,'teste')   ;
                    $instituer_objet=charger_fonction('instituer_objet_selectionne','action/');
                    $instituer_objet($id_auteur.'-auteur---auteur-'.session_get('id_auteur'));
                    set_request('id_auteur',$id_auteur);  
                }
            }

        }

    }
    
    return $flux;
}

?>