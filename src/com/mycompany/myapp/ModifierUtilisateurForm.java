/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp;

import Services.UtilisateurService;
import com.codename1.ui.Button;
import static com.codename1.ui.Component.LEFT;
import static com.codename1.ui.Component.RIGHT;
import com.codename1.ui.Container;
import com.codename1.ui.Display;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
 
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.util.Resources;
import Entities.Utilisateur;
import com.codename1.ui.plaf.UIManager;


public class ModifierUtilisateurForm extends Form {
        private Resources themes;

    public ModifierUtilisateurForm(Resources theme,Utilisateur b) {
        super(new BorderLayout(BorderLayout.CENTER_BEHAVIOR_CENTER_ABSOLUTE));
        
        System.out.println(b.getId());
  
      
        TextField nom = new TextField("", "nom", 20, TextField.ANY) ;
        nom.setText(b.getNom());
        TextField prenom = new TextField("", "prenom", 20, TextField.EMAILADDR) ;
        prenom.setText(b.getPrenom());

        TextField password = new TextField("", "password", 20, TextField.ANY) ;
        password.setText( String.valueOf(b.getPassword()));

        TextField email = new TextField("", "email", 20, TextField.ANY) ;
       email.setText(String.valueOf(b.getEmail()));

        TextField adresse = new TextField("", "adresse", 20, TextField.ANY) ;
        adresse.setText(String.valueOf(b.getAdresse()));
        
           TextField username = new TextField("", "username", 20, TextField.ANY) ;
        username.setText(String.valueOf(b.getUsername()));

           TextField photo = new TextField("", "photo", 20, TextField.ANY) ;
        photo.setText(String.valueOf(b.getPhoto()));

        

        nom.getAllStyles().setMargin(LEFT, 0);
        adresse.getAllStyles().setMargin(LEFT, 0);
        prenom.getAllStyles().setMargin(LEFT, 0);
        password.getAllStyles().setMargin(LEFT, 0);
        email.getAllStyles().setMargin(LEFT, 0);
          adresse.getAllStyles().setMargin(LEFT, 0);
            username.getAllStyles().setMargin(LEFT, 0);
              photo.getAllStyles().setMargin(LEFT, 0);
              
        Label nomIcon = new Label("", "TextField");
        Label adresseIcon = new Label("", "TextField");
        Label prenomIcon = new Label("", "TextField");
        Label passwordIcon = new Label("", "TextField");
        Label emailIcon = new Label("", "TextField");
        Label usernameIcon = new Label("", "TextField");
        Label photoIcon = new Label("", "TextField");
        nomIcon.getAllStyles().setMargin(RIGHT, 0);
        adresseIcon.getAllStyles().setMargin(RIGHT, 0);
        prenomIcon.getAllStyles().setMargin(RIGHT, 0);
        passwordIcon.getAllStyles().setMargin(RIGHT, 0);
        emailIcon.getAllStyles().setMargin(RIGHT, 0);
          usernameIcon.getAllStyles().setMargin(RIGHT, 0);
            photoIcon.getAllStyles().setMargin(RIGHT, 0);
            
        FontImage.setMaterialIcon(nomIcon, FontImage.MATERIAL_PERSON_OUTLINE, 3);
        FontImage.setMaterialIcon(adresseIcon, FontImage.MATERIAL_PERSON_OUTLINE, 3);
        FontImage.setMaterialIcon(prenomIcon, FontImage.MATERIAL_LOCK_OUTLINE, 3);
        FontImage.setMaterialIcon(passwordIcon, FontImage.MATERIAL_PERSON_OUTLINE, 3);
        FontImage.setMaterialIcon(emailIcon, FontImage.MATERIAL_PERSON_OUTLINE, 3);
        
          FontImage.setMaterialIcon(usernameIcon, FontImage.MATERIAL_PERSON_OUTLINE, 3);
          FontImage.setMaterialIcon(photoIcon, FontImage.MATERIAL_PERSON_OUTLINE, 3);
        
          
        
        Button registerButton = new Button("modifier utilisateur");
        registerButton.setUIID("modifier");
               Button retour = new Button("retour");
        retour.setUIID("retour");
        retour.addActionListener((evtt) -> {
        themes = UIManager.initFirstTheme("/theme");
       
          new  UtilisateursForm(themes).show();
        
         Toolbar.setGlobalToolbar(true);
        });
        registerButton.addActionListener(e -> {
            Toolbar.setGlobalToolbar(false);
            UtilisateurService service= new UtilisateurService();
            Utilisateur u = new Utilisateur();
            u.setId(b.getId());
            u.setAdresse(adresse.getText());
            u.setNom(nom.getText());
              u.setPassword(password.getText());
                u.setPrenom(prenom.getText());
                  u.setPhoto(photo.getText());
             
                    u.setEmail(email.getText());
                    u.setUsername(username.getText());
                  
            
       
               themes = UIManager.initFirstTheme("/theme");

        // Enable Toolbar on all Forms by default
        Toolbar.setGlobalToolbar(true);
        Toolbar.setCenteredDefault(false);
        Services.UtilisateurService aa =new UtilisateurService();

            aa.update(themes, u);
            Toolbar.setGlobalToolbar(true);
        });
        
       
       
        
  
        // We remove the extra space for low resolution devices so things fit better
     
        
        Container by = BoxLayout.encloseY(

                BorderLayout.center(nom).
                        add(BorderLayout.WEST, nomIcon),
                BorderLayout.center(adresse).
                        add(BorderLayout.WEST, adresseIcon),
                BorderLayout.center(prenom).
                        add(BorderLayout.WEST, prenomIcon),
                BorderLayout.center(password).
                        add(BorderLayout.WEST, passwordIcon),
                   BorderLayout.center(email).
                        add(BorderLayout.WEST, emailIcon),
                   
       
                BorderLayout.center(photo).
                    add(BorderLayout.WEST, photoIcon),
                         BorderLayout.center(username).      
                    add(BorderLayout.WEST, usernameIcon),
                registerButton    ,retour            
                
                
                
        );
        add(BorderLayout.CENTER, by);
        
        // for low res and landscape devices
        by.setScrollableY(true);
        by.setScrollVisible(false);
    }
}
