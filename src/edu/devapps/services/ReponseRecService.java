/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package edu.devapps.services;

import com.mysql.jdbc.Connection;
import edu.devapps.entity.Reclamation;
import edu.devapps.entity.Reponse_rec;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import utilites.MaConnexion;

/**
 *
 * @author THEOLDISBACK
 */
public class ReponseRecService {
    
    
        
      Connection cnx =MaConnexion.getInstance().getCnx();
   

  
    public void ajouterReclamation(Reponse_rec r) {
        String req ="INSERT INTO `reponse_reclamation`( `sujet`,  `etat`, `id_reclamation` ) VALUES"+ " ('"+r.getSujet()+"','"+r.getEtat()+"',"+r.getId_reclamation()+")";

          try {
              Statement st = cnx.createStatement();
              st.executeUpdate(req);
              System.out.println(" reponse reclamation ajouté");
              
            
              
              
          } catch (SQLException ex) {
              
              System.out.println(ex.getMessage());
          }
              
          }
   
    public List<Reponse_rec> afficherreponsereclamation() {
        //var
        
       
        List<Reponse_rec> reponse =new ArrayList<>();
        //requette
        String req ="SELECT * FROM reponse_reclamation";
          try {
              Statement st = cnx.createStatement();
              ResultSet rs = st.executeQuery(req);
              while (rs.next()){
                  reponse.add(new Reponse_rec(rs.getInt(1), rs.getString(2),rs.getString(3) ,rs.getDate(4), rs.getInt(5)));
              }
          } catch (SQLException ex) {
              }
    
        return reponse;

    
       
    }
    

    public void supprimerreclamation( Reponse_rec r  ) {
 String req="DELETE FROM `reponse_reclamation` WHERE id_reponse ="+r.getId_reponse();
 
           try {
             //insert
             Statement st=cnx.createStatement();
             st.executeUpdate(req);
             System.out.println("reclamation supprimer avec succes");
         } catch (SQLException ex) {
             ex.printStackTrace();
         }  
             
          
    }
    
    

 
    public void modifierFilm( Reponse_rec r ) {
        
        String req=null;
        if(r.getId_reponse()!=0)
        {   req="UPDATE `reponse_reclamation` SET sujet='"+r.getSujet()+"',etat='"+r.getEtat()+"' where id_reponse ="+r.getId_reponse();
       
            try {
             //insert
             Statement st=cnx.createStatement();
             st.executeUpdate(req);
             System.out.println("reponse modifier avec succes");
         } catch (SQLException ex) {
             ex.printStackTrace();
         }
            
        }
}
    
    
   public int nbreprec() {
        //var
        
       
        List<Reclamation> films =new ArrayList<>();
        //requette
        int i=0;
        String req ="SELECT COUNT(id_reponse) as nb FROM reponse_reclamation";
          try {
              Statement st = cnx.createStatement();
              ResultSet rs = st.executeQuery(req);
              while (rs.next()){
                i=rs.getInt(1);              }
          } catch (SQLException ex) {
              }
    
        return i;

    
   }
    
    
    
    
    
}

