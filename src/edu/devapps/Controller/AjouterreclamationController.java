/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package edu.devapps.Controller;

import edu.devapps.entity.Reclamation;
import edu.devapps.services.Mail;
import edu.devapps.services.ReclamationService;
import java.io.IOException;
import java.net.URL;
import java.sql.Date;
import java.util.ArrayList;
import java.util.List;
import java.util.ResourceBundle;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.TextField;
import javafx.scene.input.KeyEvent;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;

/**
 * FXML Controller class
 *
 * @author THEOLDISBACK
 */
public class AjouterreclamationController implements Initializable {

    @FXML
    private AnchorPane anchorme;
    @FXML
    private TextField sujetrec;
    @FXML
    private TextField descriptionrec;
    @FXML
    private TextField emailrec;
    @FXML
    private TextField etatrec;

      private static final List<String> badWords = new ArrayList<>();
    private static final String BAD_WORDS_REGEX = "\\b(%s)\\b"; // Word boundary regex for exact word match

    static {
        // Populate the list of bad words
        badWords.add("fuck");
        badWords.add("test");
        badWords.add("jihed");
        badWords.add("hamma");
        badWords.add("ammar");

        // Add more bad words to the list as needed
    }
    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void annulerreclamation(ActionEvent event) throws IOException {
          anchorme.setVisible(false);
        
                           FXMLLoader load = new FXMLLoader(getClass().getResource("/edu/devapps/Interface/reclamationview.fxml"));
                           Parent root =load.load();
                           ReclamationviewController c2=  load.getController();
                           Scene ss= new Scene(root);
                           Stage s= new Stage();
                           s=(Stage)((Node)event.getSource()).getScene().getWindow();
                           s.setScene(ss);
                           s.show();
        
    }

    @FXML
    private void ajouterreclamation(ActionEvent event) throws IOException, Exception {
        ReclamationService c = new ReclamationService();
            Date d = new Date(1999, 10, 30);

            
            if(sujetrec.getText().equals(""))
            {
                    Alert a = new Alert(Alert.AlertType.INFORMATION, "sujet cant be null");
                a.show();  
            }
            else if (emailrec.getText().equals(""))
            {
                       Alert a = new Alert(Alert.AlertType.INFORMATION, "email cant be null");
                a.show();  
            }
            else if (descriptionrec.getText().equals(""))
            {
                Alert a = new Alert(Alert.AlertType.INFORMATION, "description cant be null");
                a.show(); 
            }
            else if (etatrec.getText().equals(""))
            {
                Alert a = new Alert(Alert.AlertType.INFORMATION, "etat cant be null");
                a.show();
            }
            else
            {
                
            
            
            c.ajouterReclamation(new Reclamation(1,sujetrec.getText(), emailrec.getText(), descriptionrec.getText(), etatrec.getText(),d, 1));
                Mail.sendMail(emailrec.getText(), 0);
                Alert a = new Alert(Alert.AlertType.INFORMATION, "reclamation ajouter avec  success");
                a.show();
                            anchorme.setVisible(false);
        
                           FXMLLoader load = new FXMLLoader(getClass().getResource("/edu/devapps/Interface/reclamationview.fxml"));
                           Parent root =load.load();
                          ReclamationviewController c2=  load.getController();
                           Scene ss= new Scene(root);
                           Stage s= new Stage();
                           s=(Stage)((Node)event.getSource()).getScene().getWindow();
                           s.setScene(ss);
                           s.show();
    }
    }

    @FXML
    private void handlebadword(KeyEvent event) {
        
         String inputText = descriptionrec.getText();
        String regex = String.format(BAD_WORDS_REGEX, String.join("|", badWords));
        Pattern pattern = Pattern.compile(regex, Pattern.CASE_INSENSITIVE);
        Matcher matcher = pattern.matcher(inputText);

        while (matcher.find()) {
            int start = matcher.start();
            int end = matcher.end();
            // Replace bad words with asterisks
            StringBuilder asterisks = new StringBuilder();
            for (int i = start; i < end; i++) {
                asterisks.append("*");
            }
           Alert a = new Alert(Alert.AlertType.INFORMATION, "bad words detected");
                a.show();
            descriptionrec.replaceText(start, end, asterisks.toString());
        }
    }
    
}
