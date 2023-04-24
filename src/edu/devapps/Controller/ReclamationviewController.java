/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package edu.devapps.Controller;

import edu.devapps.entity.Reclamation;
import edu.devapps.entity.Reponse_rec;
import edu.devapps.services.ReclamationService;
import java.io.IOException;
import java.net.URL;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
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
import javafx.scene.control.TextField;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.KeyEvent;
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
public class ReclamationviewController implements Initializable {

    @FXML
    private VBox chosenFruitCard;
    @FXML
    private Label sujetrec;
    @FXML
    private Label emailrec;
    @FXML
    private ImageView fruitImg;
    @FXML
    private Label descriptionrec;
    @FXML
    private Label etatrec;
    @FXML
    private Label daterec;
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
    
    
           Reclamation currentrec;
     private Parent fxml;
      private List<Reclamation> reclamations = new ArrayList<>();
    private Image image;
    private MyListener myListener;
    @FXML
    private TextField rechercher;
    
    
    
       private List<Reclamation> getsearchData(String rechercher) throws SQLException {
      
            List<Reclamation> reclamation = new ArrayList<>();
        ReclamationService s = new ReclamationService();
        Reclamation rec1;

        for (int i = 0; i < s.rechercher(rechercher).size(); i++) {
            Reclamation get = s.rechercher(rechercher).get(i);
            
            
            rec1 = new Reclamation();
            rec1.setId_rec(get.getId_rec());
            rec1.setSujet(get.getSujet());
            rec1.setEmail(get.getEmail());
            rec1.setDescription(get.getDescription());
            rec1.setEtat(get.getEtat());
            rec1.setDate(get.getDate());
            rec1.setId_utilisateur_id(get.getId_utilisateur_id());
        
           
            
         
            reclamation.add(rec1);
        }
    

      
        return reclamation;
    }
    
    private List<Reclamation> getData() throws SQLException {
      
            List<Reclamation> reclamation = new ArrayList<>();
        ReclamationService s = new ReclamationService();
        Reclamation rec1;

        for (int i = 0; i < s.afficherreclamation().size(); i++) {
            Reclamation get = s.afficherreclamation().get(i);
            
            
            rec1 = new Reclamation();
            rec1.setId_rec(get.getId_rec());
            rec1.setSujet(get.getSujet());
            rec1.setEmail(get.getEmail());
            rec1.setDescription(get.getDescription());
            rec1.setEtat(get.getEtat());
            rec1.setDate(get.getDate());
            rec1.setId_utilisateur_id(get.getId_utilisateur_id());
        
           
            
         
            reclamation.add(rec1);
        }
    

      
        return reclamation;
    }

    private void setChosenCamping(Reclamation rec) {
        currentrec=rec;
        sujetrec.setText(rec.getSujet());
        emailrec.setText(""+ rec.getEmail());
       descriptionrec.setText(""+rec.getDescription());
       etatrec.setText(rec.getEtat());
       daterec.setText(""+rec.getDate());
      
        chosenFruitCard.setStyle("-fx-background-color: #FAEBD7;\n" +
                "    -fx-background-radius: 30;");
    }
    
    
    @Override
    public void initialize(URL url, ResourceBundle rb) {
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
               reclamations.addAll(getData());
        if (reclamations.size() > 0) {
            setChosenCamping(reclamations.get(0));
            myListener = new MyListener() {
           

            

                @Override
                public void onClickListener(Reclamation Reclamation) {
                      setChosenCamping(Reclamation);
                }

                @Override
                public void onClickListener(Reponse_rec Reponse_rec) {
                
                }
            };
        }
        int column = 0;
        int row = 1;
        try {
            for (int i = 0; i < reclamations.size(); i++) {
                FXMLLoader fxmlLoader = new FXMLLoader();
                fxmlLoader.setLocation(getClass().getResource("/edu/devapps/Interface/onereclamationview.fxml"));
                AnchorPane anchorPane = fxmlLoader.load();

                OneReclamationviewController oneReclamationviewController = fxmlLoader.getController();
                oneReclamationviewController.setData(reclamations.get(i),myListener);

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
    private void ajouterreclamation(ActionEvent event) throws IOException {
            anchorforedit.setVisible(true);
           
                fxml = FXMLLoader.load(getClass().getResource("/edu/devapps/Interface/ajouterreclamation.fxml"));
                         FXMLLoader load = new FXMLLoader(getClass().getResource("/edu/devapps/Interface/ajouterreclamation.fxml"));
                           Parent root =load.load();
                           AjouterreclamationController c2=  load.getController();
                          fxml=root;
                            anchorforedit.getChildren().removeAll();
                             anchorforedit.getChildren().setAll(fxml);
                              anchorforedit.setVisible(true);   
    }

    @FXML
    private void modifierreclamation(ActionEvent event) throws IOException {
    
       anchorforedit.setVisible(true);
           
                            fxml = FXMLLoader.load(getClass().getResource("/edu/devapps/Interface/modifierreclamation.fxml"));
                         FXMLLoader load = new FXMLLoader(getClass().getResource("/edu/devapps/Interface/modifierreclamation.fxml"));
                           Parent root =load.load();
                           ModifierReclamationController c2=  load.getController();
                           c2.getinfo(currentrec);
                          fxml=root;
                            anchorforedit.getChildren().removeAll();
                             anchorforedit.getChildren().setAll(fxml);
                              anchorforedit.setVisible(true);   
    
    
    }

    @FXML
    private void supprimerreclamation(ActionEvent event) throws IOException {
      
        ReclamationService s = new ReclamationService();
        
        Reclamation r = new Reclamation();
        r.setId_rec(currentrec.getId_rec());
        s.supprimerreclamation(r);
        Alert a = new Alert(Alert.AlertType.INFORMATION, "your reclamation has been deleted");
                a.show();
                           FXMLLoader load = new FXMLLoader(getClass().getResource("/edu/devapps/Interface/reclamationview.fxml"));
                           Parent root =load.load();
                           ReclamationviewController c2=  load.getController();
                           Scene ss= new Scene(root);
                           Stage se= new Stage();
                           se=(Stage)((Node)event.getSource()).getScene().getWindow();
                           se.setScene(ss);
                           se.show();
    
    
    }

    @FXML
    private void gototransport(MouseEvent event) throws IOException {
   
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
    private void reponsereclamation(ActionEvent event) throws IOException {
      anchorforedit.setVisible(true);
           
                fxml = FXMLLoader.load(getClass().getResource("/edu/devapps/Interface/ajouterreponserec.fxml"));
                         FXMLLoader load = new FXMLLoader(getClass().getResource("/edu/devapps/Interface/ajouterreponserec.fxml"));
                           Parent root =load.load();
                           AjoutereponserecController c2=  load.getController();
                           c2.getinfo(currentrec);
                          fxml=root;
                            anchorforedit.getChildren().removeAll();
                             anchorforedit.getChildren().setAll(fxml);
                              anchorforedit.setVisible(true);   
    
    
    
    }

    @FXML
    private void gotostatistique(ActionEvent event) throws IOException {
        FXMLLoader load = new FXMLLoader(getClass().getResource("/edu/devapps/Interface/statistic.fxml"));
                           Parent root =load.load();
                           StatisticController c2=  load.getController();
                           Scene ss= new Scene(root);
                           Stage se= new Stage();
                           se=(Stage)((Node)event.getSource()).getScene().getWindow();
                           se.setScene(ss);
                           se.show();
    }

    @FXML
    private void search(KeyEvent event) throws SQLException {
        
        reclamations.clear();
        grid.getChildren().clear();
           reclamations.addAll(getsearchData(rechercher.getText()));
        if (reclamations.size() > 0) {
            setChosenCamping(reclamations.get(0));
            myListener = new MyListener() {
           

            

                @Override
                public void onClickListener(Reclamation Reclamation) {
                      setChosenCamping(Reclamation);
                }

                @Override
                public void onClickListener(Reponse_rec Reponse_rec) {
                
                }
            };
        }
        int column = 0;
        int row = 1;
        try {
            for (int i = 0; i < reclamations.size(); i++) {
                FXMLLoader fxmlLoader = new FXMLLoader();
                fxmlLoader.setLocation(getClass().getResource("/edu/devapps/Interface/onereclamationview.fxml"));
                AnchorPane anchorPane = fxmlLoader.load();

                OneReclamationviewController oneReclamationviewController = fxmlLoader.getController();
                oneReclamationviewController.setData(reclamations.get(i),myListener);

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
    
}
