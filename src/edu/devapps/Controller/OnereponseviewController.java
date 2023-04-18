/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package edu.devapps.Controller;

import edu.devapps.entity.Reclamation;
import edu.devapps.entity.Reponse_rec;
import java.net.URL;
import java.util.ResourceBundle;
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
public class OnereponseviewController implements Initializable {

    @FXML
    private Label sujetrec;
    @FXML
    private Label etatrec;
    @FXML
    private Label id_rec;
 private Reponse_rec rep;
    private MyListener myListener;
    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    
      public void setData(Reponse_rec rep, MyListener myListener) {
        this.rep = rep;
        this.myListener = myListener;
        sujetrec.setText(rep.getSujet());
        etatrec.setText(""+rep.getEtat());
        id_rec.setText(""+rep.getId_reclamation());
    }
    @FXML
    private void onclick(MouseEvent event) {
                      myListener.onClickListener(rep);

    }
    
}
