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
import Services.Mail;
import com.codename1.components.ToastBar;
import com.codename1.l10n.ParseException;
import com.codename1.l10n.SimpleDateFormat;
import com.codename1.ui.plaf.UIManager;
import java.util.Date;




public class AddUtilisateurForm extends Form {
        private Resources themes;

    public AddUtilisateurForm(Resources theme) {
        super(new BorderLayout(BorderLayout.CENTER_BEHAVIOR_CENTER_ABSOLUTE));
        
        
  
      
        TextField nom = new TextField("", "nom", 20, TextField.ANY) ;
        TextField prenom = new TextField("", "prenom", 20, TextField.EMAILADDR) ;
        TextField password = new TextField("", "password", 20, TextField.ANY) ;
        TextField email = new TextField("", "email", 20, TextField.ANY) ;
        TextField adresse = new TextField("", "adresse", 20, TextField.ANY) ;
         TextField username = new TextField("", "username", 20, TextField.ANY) ;
          TextField photo = new TextField("", "photo", 20, TextField.ANY) ;
           TextField age = new TextField("", "age", 20, TextField.ANY) ;
        nom.getAllStyles().setMargin(LEFT, 0);
        prenom.getAllStyles().setMargin(LEFT, 0);
        password.getAllStyles().setMargin(LEFT, 0);
        email.getAllStyles().setMargin(LEFT, 0);
        username.getAllStyles().setMargin(LEFT, 0);
            photo.getAllStyles().setMargin(LEFT, 0);
                age.getAllStyles().setMargin(LEFT, 0);
                    adresse.getAllStyles().setMargin(LEFT, 0);
        
        Label nomIcon = new Label("", "TextField");
        Label prenomIcon = new Label("", "TextField");
        Label passwordIcon = new Label("", "TextField");
        Label emailIcon = new Label("", "TextField");
        Label usernameIcon = new Label("", "TextField");
              Label photoIcon = new Label("", "TextField");
                    Label ageIcon = new Label("", "TextField");
                          Label adresseIcon = new Label("", "TextField");
        nomIcon.getAllStyles().setMargin(RIGHT, 0);
        prenomIcon.getAllStyles().setMargin(RIGHT, 0);
        passwordIcon.getAllStyles().setMargin(RIGHT, 0);
        emailIcon.getAllStyles().setMargin(RIGHT, 0);
        usernameIcon.getAllStyles().setMargin(RIGHT, 0);
             photoIcon.getAllStyles().setMargin(RIGHT, 0);
                  ageIcon.getAllStyles().setMargin(RIGHT, 0);
                       adresseIcon.getAllStyles().setMargin(RIGHT, 0);
        
        FontImage.setMaterialIcon(nomIcon, FontImage.MATERIAL_PERSON_OUTLINE, 3);
        FontImage.setMaterialIcon(prenomIcon, FontImage.MATERIAL_PERSON_OUTLINE, 3);
        FontImage.setMaterialIcon(passwordIcon, FontImage.MATERIAL_LOCK_OUTLINE, 3);
        FontImage.setMaterialIcon(emailIcon, FontImage.MATERIAL_PERSON_OUTLINE, 3);
        FontImage.setMaterialIcon(usernameIcon, FontImage.MATERIAL_PERSON_OUTLINE, 3);
        FontImage.setMaterialIcon(photoIcon, FontImage.MATERIAL_PERSON_OUTLINE, 3);
        FontImage.setMaterialIcon(ageIcon, FontImage.MATERIAL_PERSON_OUTLINE, 3);
        FontImage.setMaterialIcon(adresseIcon, FontImage.MATERIAL_PERSON_OUTLINE, 3);
        
        Button registerButton = new Button("add utilisateur");
        registerButton.setUIID("AddUtilisateur");
        
        
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
            
            u.setNom(nom.getText());
           
          
            u.setPrenom(prenom.getText());
     
           
            u.setAdresse(adresse.getText());

            
            
            u.setPassword(password.getText());
       
            
               u.setPhoto(photo.getText());
      
            
               u.setEmail(email.getText());
     
            
            SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
Date date;              
            try {
                date = dateFormat.parse(age.getText());
                u.setAge(date);
            } catch (ParseException ex) {
               
            }
u.setUsername(username.getText());
        
              

            
            
               themes = UIManager.initFirstTheme("/theme");
                 ToastBar.Status status = ToastBar.getInstance().createStatus();
                    
              
              if(nom.getText().equals(""))
              {
                  status.setMessage("nom cant be null");
                    status.setExpires(2000);
                    status.show();
              }
              else if(email.getText().equals(""))
              {
                   status.setMessage("email cant be null");
                    status.setExpires(2000);
                    status.show();
              }
              else if(prenom.getText().equals(""))
              {
                   status.setMessage("prenom cant be null");
                    status.setExpires(2000);
                    status.show();
              }
              else if(adresse.getText().equals(""))
              {
                   status.setMessage("addresse cant be null");
                    status.setExpires(2000);
                    status.show();
              }
              else if(password.getText().equals(""))
              {
                   status.setMessage("password cant be null");
                    status.setExpires(2000);
                    status.show();
              }
              else
                  
              {
                try {
                    Mail.sendMail("mejdi.mohamed@esprit.tn", 0);
                } catch (Exception ex) {
                }
        // Enable Toolbar on all Forms by default
        Toolbar.setGlobalToolbar(true);
        Toolbar.setCenteredDefault(false);
        Services.UtilisateurService aa =new UtilisateurService();
        System.out.println(aa.getAllUsers());

            service.register(themes, u);
            Toolbar.setGlobalToolbar(true);
     }   });
        
       
       
        
  
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
                   BorderLayout.center(photo).
                        add(BorderLayout.WEST, photoIcon),
                   
                     BorderLayout.center(email).
                        add(BorderLayout.WEST, emailIcon),

              

                         BorderLayout.center(username).
                        add(BorderLayout.WEST, usernameIcon),
  BorderLayout.center(age).
                        add(BorderLayout.WEST, ageIcon),
                   
                   
                   
                registerButton ,retour               
        );
        add(BorderLayout.CENTER, by);
        
        // for low res and landscape devices
        by.setScrollableY(true);
        by.setScrollVisible(false);
    }
}
