<?php 
######################################################################################################### 
//////////////////////////////////                /************************************************/        # 
//       #              #        //                /*     *****   class par Xavier Artot alias x@v */        # 
//       #             ##        //                /*     *****   artotal@gmail.com ****************/        # 
//       ###        #####        //                /*     *****   cette classe permet d'avoir une **/        # 
//       # ###    #######        //                /*     *****   **********************************/        # 
//            ########  #        //                /*     *****   couche d'abstraction avec ********/        # 
//           #######            //                /*     *****   sÃ©curiation en utilisant *********/        # 
//       # #########            //                /*     *****    des requÃªtes prÃ©parÃ©s ***********/        # 
//       ######     ### #        //                /*     *****   et des tranctions auto-commit*****/        # 
//       ###          ###        //                /*     ******************************************/        # 
//       #              #        //                /*     ******************************************/        # 
//          ###                    //                /*     ******************************************/        # 
//        #######    ##            //                /*     ******************************************/        # 
//       #########  ####        //                /************************************************/        # 
//       ##     ##   # ##        //                                                                        # 
//       #      ##      #        //                                                                        # 
//       ##     #      ##        //                                                                        # 
//       ###############        //                                                                        # 
//       ##############            //                                                                        # 
//       #                        //                                                                        # 
//                                //                                                                        # 
//                      #        //                                                                        # 
//                    ###        //                                                                        # 
//                #######        //                                                                        # 
//             ##########        //                                                                        # 
//        ##########            //                                                                        # 
//       ########                //                                                                        # 
//           ###                //                                                                        # 
//               ####   #        //                                                                        # 
//                   ####        //                                                                        # 
//                      #        //                                                                        # 
//////////////////////////////////                                                                        # 
######################################################################################################### 

class Connection extends PDO  
{     
//    private $db = 'pastourebd1';         // base de donnÃ©es 
  //  private $host = 'mysql5-8.bdb';     // adresse de la base 
   // private $user = 'pastourebd1';         // nom 
  //  private $pwd = 'ltIUED83';                 // mot de passe 
	private $db = 'pastourebd1';         // base de donnÃ©es
	private $host = 'localhost';     // adresse de la base
	private $user = 'root';         // nom
	private $pwd = 'nhc64mp81//';                 // mot de passe
    private $con;                    //  
    private $select;                 // requette de sÃ©lÃ©ction 
    private $execute;                 // requette d'execution 
    private $email='artotal@gmail.com';                    // email de l'admin du site 
    private $dns; 
       
    public function __construct ()  
    { 
        try  
        { 
            $this->con = parent::__construct($this->getDns(), $this->user, $this->pwd); 
            // pour mysql on active le cache de requÃªte 
            if($this->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql') 
                $this->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); 
            $this->exec('SET NAMES utf8');
            return $this->con; 
        } 
        catch(PDOException $e) { 
            //On indique par email qu'on n'a plus de connection disponible 
            error_log(date('D/m/y').' Ã  '.date("H:i:s").' : '.$e->getMessage(), 1, $this->email); 
            $message= new Message(); 
            $message->outPut('Erreur 500', 'Serveur de BDD indisponible, nous nous excusons de la gÃªne occasionnÃ©e'); 
        } 
    } 
     
    public function select($reqSelect) 
    { 
        try 
        { 
            $this->con = parent::beginTransaction(); 
            //$result= parent::query($reqSelect); 
            $result = parent::prepare($reqSelect); 
            $result->execute(); 
            $this->con = parent::commit(); 
            // ou 
            // $this->con = parent::rollBack(); 
              return $result; 
        } 
        catch (Exception $e)  
        { 
            //On indique par email que la requÃªte n'a pas fonctionnÃ©. 
            error_log(date('D/m/y').' Ã  '.date("H:i:s").' : '.$e->getMessage(), 1, 'artotal@gmail.com'); 
            $this->con =parent::rollBack(); 
            $message= new Message(); 
            $message->outPut('Erreur dans la requÃªtte', 'Votre requÃªte a Ã©tÃ© abandonnÃ©'); 
        } 
    } 
     
    // renvoie un tableau que l'on peux travailler avec count($result)... 
    public function selectTableau($reqSelect) 
    { 
        $result = parent::prepare($reqSelect); 
        $result->execute(); 
        /* RÃ©cupÃ©ration de toutes les lignes d'un jeu de rÃ©sultats "Ã©quivalent Ã  mysql_num_row() " */ 
        $resultat = $result->fetchAll(); 
        return $resultat; 
    } 

    // on change le type de base ici 
    public function getDns() 
    { 
        return 'mysql:dbname='.$this->db.';host='.$this->host; 
    } 
}