<?php
/**
 * Fichier gérant l'installation et désinstallation du plugin ARP
 *
 * @plugin     ARP
 * @copyright  2013
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\Arp\Installation
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Fonction d'installation et de mise à jour du plugin ARP.
 *
 * Vous pouvez :
 *
 * - créer la structure SQL,
 * - insérer du pre-contenu,
 * - installer des valeurs de configuration,
 * - mettre à jour la structure SQL 
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 * @return void
**/
function arp_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();

	include_spip('inc/config');
    $maj['create'] = array(
        array('ecrire_config', 
            'encheres', 
                array(
                'devise' => "EUR",
                'roles'=>"client_direct,Client directe
agence,Agence
client_agence,Client d'agence",
                'activer_super_encherisseur'=>'on',
                'roles_super_encherisseur',
                'roles_super_encherisseur'=>'agence',
                'activer_palier_encherissment'=>'on')                         
            ),
        array('ecrire_config', 
            'selection_objet', 
                array(
                'objets_cible' => array("auteur"),
                'selection_rubrique_objet'=>array("auteur"))                           
            ),                      
        );	
	
    
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


/**
 * Fonction de désinstallation du plugin ARP.
 * 
 * Vous devez :
 *
 * - nettoyer toutes les données ajoutées par le plugin et son utilisation
 * - supprimer les tables et les champs créés par le plugin. 
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @return void
**/
function arp_vider_tables($nom_meta_base_version) {
	# quelques exemples
	# (que vous pouvez supprimer !)
	# sql_drop_table("spip_xx");
	# sql_drop_table("spip_xx_liens");


	effacer_meta($nom_meta_base_version);
}

?>