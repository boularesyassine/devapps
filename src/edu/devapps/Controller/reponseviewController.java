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
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.geometry.Insets;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Label;
import javafx.scene.control.ScrollPane;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.HBox;
import javafx.scene.layout.Region;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;
import yassine.MyListener;

/**
 * FXML Controller class
 *
 * @author THEOLDISBACK
 */
public class reponseviewController implements Initializable {

    @FXML
    private VBox chosenFruitCard;
    @FXML
    private Label sujetrec;
    @FXML
    private ImageView fruitImg;
    @FXML
    private Label etat;
    @FXML
    private HBox hboxcamping;
    @FXML
    private ScrollPane scroll;
    @FXML
    private GridPane grid;
    @FXML
    private AnchorPane anchorforedit;

    /**
     * Initializes the controller class.
     */
    
               Reponse_rec currentrep;
     private Parent fxml;
      private List<Reponse_rec> reponses = new ArrayList<>();
    private Image image;
    private MyListener myListener;
    @FXML
    private Label date;
    
    
    
    
    
    
        private List<Reponse_rec> getData() throws SQLException {
      
            List<Reponse_rec> reponses = new ArrayList<>();
            ReponseRecService s = new ReponseRecService();
        Reponse_rec rep1;

        for (int i = 0; i < s.afficherreponsereclamation().size(); i++) {
            Reponse_rec get = s.afficherreponsereclamation().get(i);
            
            
            rep1 = new Reponse_rec();
            rep1.setId_reponse(get.getId_reponse());
            rep1.setSujet(get.getSujet());
   
  
            rep1.setEtat(get.getEtat());
            rep1.setDate(get.getDate());
            rep1.setId_reclamation(get.getId_reclamation());
        
           
            
         
            reponses.add(rep1);
        }
    

      
        return reponses;
    }

    private void setChosenCamping(Reponse_rec rec) {
        currentrep=rec;
        sujetrec.setText(rec.getSujet());
       
       etat.setText(rec.getEtat());
       date.setText(""+rec.getDate());
      
        chosenFruitCard.setStyle("-fx-background-color: #FAEBD7;\n" +
                "    -fx-background-radius: 30;");
    }
    
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
         // TODO
         hboxcamping.setVisible(false);
        anchorforedit.setVisible(false);
        try {
            // TODO
            afficher();
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }    

    
    
    
     public void afficher() throws SQLException
    {
               reponses.addAll(getData());
        if (reponses.size() > 0) {
            setChosenCamping(reponses.get(0));
            myListener = new MyListener() {
           

            

                @Override
                public void onClickListener(Reclamation Reclamation) {
                    
                }

                @Override
                public void onClickListener(Reponse_rec Reponse_rec) {
                           setChosenCamping(Reponse_rec);
                }
            };
        }
        int column = 0;
        int row = 1;
        try {
            for (int i = 0; i < reponses.size(); i++) {
                FXMLLoader fxmlLoader = new FXMLLoader();
                fxmlLoader.setLocation(getClass().getResource("/edu/devapps/Interface/onereponseview.fxml"));
                AnchorPane anchorPane = fxmlLoader.load();

                OnereponseviewController OnereponseviewController = fxmlLoader.getController();
                OnereponseviewController.setData(reponses.get(i),myListener);

                if (column == 2) {
                    column = 0;
                    row++;
                }

                grid.add(anchorPane, column++, row); //(child,column,row)
                //set grid width
                grid.setMinWidth(Region.USE_COMPUTED_SIZE);
                grid.setPrefWidth(Region.USE_COMPUTED_SIZE);
                grid.setMaxWidth(Region.USE_PREF_SIZE);

                //set grid height
                grid.setMinHeight(Region.USE_COMPUTED_SIZE);
                grid.setPrefHeight(Region.USE_COMPUTED_SIZE);
                grid.setMaxHeight(Region.USE_PREF_SIZE);

                GridPane.setMargin(anchorPane, new Insets(10));
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
    @FXML
    private void modifierreponse(ActionEvent event) throws IOException {
    
      anchorforedit.setVisible(true);
           
                            fxml = FXMLLoader.load(getClass().getResource("/edu/devapps/Interface/modifierreponserec.fxml"));
                         FXMLLoader load = new FXMLLoader(getClass().getResource("/edu/devapps/Interface/modifierreponserec.fxml"));
                           Parent root =load.load();
                           ModifierReponserecController c2=  load.getController();
                           c2.getinfo(currentrep);
                          fxml=root;
                            anchorforedit.getChildren().removeAll();
                             anchorforedit.getChildren().setAll(fxml);
                              anchorforedit.setVisible(true);   
    
    }

    @FXML
    private void supprimerreponse(ActionEvent event) throws IOException {
   ReponseRecService s = new ReponseRecService();
        
        Reponse_rec r = new Reponse_rec();
        r.setId_reponse(currentrep.getId_reponse());
        s.supprimerreclamation(r);
        Alert a = new Alert(Alert.AlertType.INFORMATION, "your reponse has been deleted");
                a.show();
                           FXMLLoader load = new FXMLLoader(getClass().getResource("/edu/devapps/Interface/reponseview.fxml"));
                           Parent root =load.load();
                           reponseviewController c2=  load.getController();
                           Scene ss= new Scene(root);
                           Stage se= new Stage();
                           se=(Stage)((Node)event.getSource()).getScene().getWindow();
                           se.setScene(ss);
                           se.show();
    
    
    
    }

    @FXML
    private void gototransport(MouseEvent event) throws IOException {
   
     FXMLLoader load = new FXMLLoader(getClass().getResource("/edu/devapps/Interface/reclamationview.fxml"));
                           Parent root =load.load();
                           ReclamationviewController c2=  load.getController();
                           Scene ss= new Scene(root);
                           Stage se= new Stage();
                           se=(Stage)((Node)event.getSource()).getScene().getWindow();
                           se.setScene(ss);
                           se.show();
    
    }
    
}
