/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package edu.devapps.services;

import com.mysql.jdbc.Connection;
import edu.devapps.entity.Reclamation;
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
public class ReclamationService {
    
    
    
      Connection cnx =MaConnexion.getInstance().getCnx();
   

  
    public void ajouterReclamation(Reclamation r) {
        String req ="INSERT INTO `reclamation`( `sujet`, `email`, `description`,  `etat`, `id_utilisateur_id` ) VALUES"+ " ('"+r.getSujet()+"','"+r.getEmail()+"','"+r.getDescription()+"','"+r.getEtat()+"',"+r.getId_utilisateur_id()+")";

          try {
              Statement st = cnx.createStatement();
              st.executeUpdate(req);
              System.out.println("reclamation ajouté");
              
            
              
              
          } catch (SQLException ex) {
              
              System.out.println(ex.getMessage());
          }
              
          }
   
    public List<Reclamation> afficherreclamation() {
        //var
        
       
        List<Reclamation> films =new ArrayList<>();
        //requette
        String req ="SELECT * FROM reclamation";
          try {
              Statement st = cnx.createStatement();
              ResultSet rs = st.executeQuery(req);
              while (rs.next()){
                  films.add(new Reclamation(rs.getInt(1), rs.getString(2),rs.getString(3) ,rs.getString(4), rs.getString(5), rs.getDate(6), rs.getInt(7)));
              }
          } catch (SQLException ex) {
              }
    
        return films;

    
       
    }
    

    public void supprimerreclamation( Reclamation r  ) {
 String req="DELETE FROM `reclamation` WHERE id_rec="+r.getId_rec() ;
 
           try {
             //insert
             Statement st=cnx.createStatement();
             st.executeUpdate(req);
             System.out.println("reclamation supprimer avec succes");
         } catch (SQLException ex) {
             ex.printStackTrace();
         }  
             
          
    }
    
    

 
    public void modifierFilm( Reclamation r ) {
        
        String req=null;
        if(r.getId_rec()!=0)
        {   req="UPDATE `reclamation` SET sujet='"+r.getSujet()+"',email='"+r.getEmail()+"',description='"+r.getDescription()+"',etat='"+r.getEtat()+"' where id_rec ="+r.getId_rec();
       
            try {
             //insert
             Statement st=cnx.createStatement();
             st.executeUpdate(req);
             System.out.println("film modifier avec succes");
         } catch (SQLException ex) {
             ex.printStackTrace();
         }
            
        }
       
    }
    
    
    
    
   

    


    
      public int nbrec() {
        //var
        
       
        List<Reclamation> films =new ArrayList<>();
        //requette
        int i=0;
        String req ="SELECT COUNT(id_rec) as nb FROM reclamation";
          try {
              Statement st = cnx.createStatement();
              ResultSet rs = st.executeQuery(req);
              while (rs.next()){
                i=rs.getInt(1);              }
          } catch (SQLException ex) {
              }
    
        return i;

    
       
    }
    
    
     public List<Reclamation> rechercher(String s) {
        //var
        
       
        List<Reclamation> reclamations =new ArrayList<>();
        //requette
        String req ="SELECT * FROM reclamation  where sujet like '%"+s+"%' OR email like  '%"+s+"%' OR description like '%"+s+"%' OR  etat like '%"+s+"%'";
          try {
              Statement st = cnx.createStatement();
              ResultSet rs = st.executeQuery(req);
              while (rs.next()){
                  reclamations.add(new Reclamation(rs.getInt(1), rs.getString(2),rs.getString(3) ,rs.getString(4), rs.getString(5), rs.getDate(6), rs.getInt(7)));
              }
          } catch (SQLException ex) {
              }
    
        return reclamations;

    
       
    }
    
    
    
    
}
