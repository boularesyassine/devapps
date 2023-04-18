/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package edu.devapps.Controller;

import edu.devapps.entity.Reclamation;
import edu.devapps.entity.Reponse_rec;
import edu.devapps.services.ReclamationService;
import edu.devapps.services.ReponseRecService;
import java.io.IOException;
import java.net.URL;
import java.sql.Date;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.TextField;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;

/**
 * FXML Controller class
 *
 * @author THEOLDISBACK
 */
public class ModifierReponserecController implements Initializable {

    @FXML
    private AnchorPane anchorme;
    @FXML
    private TextField sujetrec;
    @FXML
    private TextField etatrec;
   Reponse_rec thisrep;
    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void annulerreponse(ActionEvent event) throws IOException {
  
      anchorme.setVisible(false);
        
                           FXMLLoader load = new FXMLLoader(getClass().getResource("/edu/devapps/Interface/reponseview.fxml"));
                           Parent root =load.load();
                           reponseviewController c2=  load.getController();
                           Scene ss= new Scene(root);
                           Stage s= new Stage();
                           s=(Stage)((Node)event.getSource()).getScene().getWindow();
                           s.setScene(ss);
                           s.show();
    
    }

    @FXML
    private void modifierreponse(ActionEvent event) throws IOException {
    
        ReponseRecService s = new ReponseRecService();
                      Date d = new Date(19993010);
               
                       if(sujetrec.getText().equals(""))
            {
                    Alert a = new Alert(Alert.AlertType.INFORMATION, "sujet cant be null");
                a.show();  
            }
            
           
            else if (etatrec.getText().equals(""))
            {
                Alert a = new Alert(Alert.AlertType.INFORMATION, "etat cant be null");
                a.show();
            }
            else
            { 
                 
                      s.modifierFilm(new Reponse_rec(thisrep.getId_reponse(), sujetrec.getText(), etatrec.getText(),d,thisrep.getId_reclamation()));
                        Alert a = new Alert(Alert.AlertType.INFORMATION, "votre reponse est modifier ");
                        a.show();
        
                          anchorme.setVisible(false);
        
                           FXMLLoader load = new FXMLLoader(getClass().getResource("/edu/devapps/Interface/reponseview.fxml"));
                           Parent root =load.load();
                           reponseviewController c2=  load.getController();
                           Scene ss= new Scene(root);
                           Stage se= new Stage();
                           se=(Stage)((Node)event.getSource()).getScene().getWindow();
                           se.setScene(ss);
                           se.show();
    
            }
    
    }
    
    
     public void  getinfo (Reponse_rec rep)
    {
        thisrep=rep;
  
        sujetrec.setText(rep.getSujet());
        etatrec.setText(rep.getEtat());
        
        
    }
}
