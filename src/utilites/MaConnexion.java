/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package utilites;

import com.mysql.jdbc.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;


/**
 *
 * @author FAROUK
 */
public class MaConnexion {
    //BD
   final static String URL ="jdbc:mysql://127.0.0.1:3306/devappsfinal";
   final static String USERNAME ="root";
   final static String PWD ="";
   
//att
static private Connection cnx;
//Singleton 1
static  MaConnexion instance = null ;

// cosntructor 
// singleton 2
    
    private MaConnexion() {
       try {
           cnx=(Connection) DriverManager.getConnection(URL, USERNAME, PWD);
           System.out.println("connexion etablie");
       } catch (SQLException ex) {
           
           ex.printStackTrace();
       }
        
       
    }

//getters 

    public static Connection getCnx() {
        return cnx;
    }
//singleton3

    public static MaConnexion getInstance() {
        if (instance == null ){
            instance =new MaConnexion();
        }
        return instance;
    }
    

    
}