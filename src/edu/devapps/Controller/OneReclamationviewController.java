/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package edu.devapps.Controller;

import edu.devapps.entity.Reclamation;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Label;
import javafx.scene.input.MouseEvent;
import yassine.MyListener;

/**
 * FXML Controller class
 *
 * @author THEOLDISBACK
 */
public class OneReclamationviewController implements Initializable {

    @FXML
    private Label sujetrec;
    @FXML
    private Label emailrec;
    @FXML
    private Label daterec;
    @FXML
    private Label descriptionrec;
    @FXML
    private Label etatrec;
 private Reclamation rec;
    private MyListener myListener;
    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    public void setData(Reclamation rec, MyListener myListener) {
        this.rec = rec;
        this.myListener = myListener;
        sujetrec.setText(rec.getSujet());
        emailrec.setText(rec.getEmail());
        daterec.setText(""+rec.getDate());
        descriptionrec.setText(""+rec.getDescription());
        etatrec.setText(""+rec.getEtat());
        
    }
    
    @FXML
    private void onclick(MouseEvent event) {
              myListener.onClickListener(rec);
    }

    
}
