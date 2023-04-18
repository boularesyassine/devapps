/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package yassine;


import com.mysql.jdbc.Connection;
import edu.devapps.entity.Reclamation;
import edu.devapps.entity.Reponse_rec;
import edu.devapps.services.ReclamationService;
import edu.devapps.services.ReponseRecService;
import java.sql.Date;


/**
 *
 * @author FAROUK
 */
public class Pidev1 {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        
      Reponse_rec r;
        Date d = new Date(1999, 10, 30);
            r= new Reponse_rec(40
, "yassine", "yassine", d, 49
);
            ReponseRecService re = new ReponseRecService();
           re.supprimerreclamation(r);
    }

   
    
}
