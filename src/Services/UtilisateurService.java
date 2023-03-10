/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Services;

import Entities.Utilisateur;
import com.codename1.components.ToastBar;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.util.Resources;
import com.mycompany.myapp.UtilisateursForm;
import com.codename1.io.CharArrayReader;
import com.mycompany.myapp.UtilisateurssearchForm;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Date;
import java.util.Map;
import java.util.List;


public class UtilisateurService {
    
    
    public static Utilisateur currentUtilisateurc=new Utilisateur();
     public ArrayList<Utilisateur> getAllUsers() {
        ArrayList<Utilisateur> listTasks = new ArrayList<>();
        ConnectionRequest con = new ConnectionRequest();
        con.setUrl("http://127.0.0.1:8000/Utilisateurlist");
        con.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                //listTasks = getListTask(new String(con.getResponseData()));
                JSONParser jsonp = new JSONParser();
                
                try {
                    Map<String, Object> tasks = jsonp.parseJSON(new CharArrayReader(new String(con.getResponseData()).toCharArray()));
                    //System.out.println(tasks);
                    //System.out.println(tasks);
                    List<Map<String, Object>> list = (List<Map<String, Object>>) tasks.get("root");
                    System.out.println(list.toString());
                    System.out.println("list end here");
                    for (Map<String, Object> obj : list) {
                        Utilisateur utilisateur = new Utilisateur();
                        /*if (obj.get("image")!=null)*/
                        utilisateur.setAdresse(obj.get("adresse").toString());
                        utilisateur.setNom(obj.get("nom").toString());
                        utilisateur.setPrenom(obj.get("prenom").toString());
                        utilisateur.setEmail(obj.get("email").toString());
                        utilisateur.setPassword((( obj.get("password").toString())));
                        utilisateur.setUsername(obj.get("username").toString());
                        utilisateur.setPhoto(obj.get("photo").toString());
                        utilisateur.setId((( (int)(double)obj.get("id"))));
                        utilisateur.setRole((String) obj.get("role"));
                     //   user.setId((int)((double) obj.get("id")));
                     //   user.setRole(obj.get("role").toString());
                       
                        
                        /*if (obj.get("confirmationToken")!=null)*/
                      
                        
                        
                        
                        listTasks.add(utilisateur);
                    }
                } catch (IOException ex) {
                }

            }
        });
        NetworkManager.getInstance().addToQueueAndWait(con);
        return listTasks;
    }
     
    
     
     
      public void searchuser(Resources res ,String s) {
        ArrayList<Utilisateur> listTasks = new ArrayList<>();
        ConnectionRequest con = new ConnectionRequest();
        con.setUrl("http://127.0.0.1:8000/searched?search="+s);
        con.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                //listTasks = getListTask(new String(con.getResponseData()));
                JSONParser jsonp = new JSONParser();
                
                try {
                    Map<String, Object> tasks = jsonp.parseJSON(new CharArrayReader(new String(con.getResponseData()).toCharArray()));
                    //System.out.println(tasks);
                    //System.out.println(tasks);
                    List<Map<String, Object>> list = (List<Map<String, Object>>) tasks.get("root");
                    System.out.println(list.toString());
                    System.out.println("list end here");
                    for (Map<String, Object> obj : list) {
                        Utilisateur utilisateur = new Utilisateur();
                        /*if (obj.get("image")!=null)*/
                        utilisateur.setAdresse(obj.get("adresse").toString());
                        utilisateur.setNom(obj.get("nom").toString());
                        utilisateur.setPrenom(obj.get("prenom").toString());
                        utilisateur.setEmail(obj.get("email").toString());
                        utilisateur.setPassword((( obj.get("password").toString())));
                        utilisateur.setUsername(obj.get("username").toString());
                        utilisateur.setPhoto(obj.get("photo").toString());
                        utilisateur.setId((( (int)(double)obj.get("id"))));
                        utilisateur.setRole((String) obj.get("role"));
                     //   user.setId((int)((double) obj.get("id")));
                     //   user.setRole(obj.get("role").toString());
                       
                        
                        /*if (obj.get("confirmationToken")!=null)*/
                      
                        
                        
                        
                        listTasks.add(utilisateur);
                    }
                } catch (IOException ex) {
                }

            }
        });
        NetworkManager.getInstance().addToQueueAndWait(con);
        new  UtilisateurssearchForm(res,s).show();
    }
 
       
     /***************************************************************************/
     public void register(Resources res,Utilisateur u){
       
                 
                ConnectionRequest r = new ConnectionRequest();
                 String url =  "http://127.0.0.1:8000/registerUtilisateur?nom="+u.getNom()+
               "&prenom="+u.getPrenom()+
               "&password="+u.getPassword()+
               "&email="+u.getEmail()+
               "&adresse="+u.getAdresse()+
                "&username="+u.getUsername()+
               "&photo="+u.getPhoto()+
               "&age="+u.getAge();

            r.setUrl(url);
           
            
            r.setPost(true);
             r.addArgument("encoding", "json");
            r.setContentType("application/json");
            r.addResponseListener(resp -> {
                JSONParser jsonp = new JSONParser();
                
                try {
                    Map<String, Object> tasks = jsonp.parseJSON(new CharArrayReader(new String(r.getResponseData()).toCharArray()));
                    System.out.println("tasks :"+tasks);
                        try{
                           
                          
                        
                        
                        currentUtilisateurc.setId((int)((double) tasks.get("id")));
                         
                         
                        
                        
                         
                        }
                        catch(ArrayIndexOutOfBoundsException exs)
                        {
                            ToastBar.Status status = ToastBar.getInstance().createStatus();
                    status.setShowProgressIndicator(true);
                     
                    status.setMessage("no user found");
                    status.setExpires(2000);
                    status.show();
                        return ;
                        }
                } catch (IOException | NumberFormatException | NullPointerException | ArrayIndexOutOfBoundsException ex) {
                    ToastBar.Status status = ToastBar.getInstance().createStatus();
                    status.setShowProgressIndicator(true);
                     
                    status.setMessage("no internet.... ");
                    status.setExpires(3000);
                     
                    
                }
            });
            ToastBar.Status status = ToastBar.getInstance().createStatus();
            status.setShowProgressIndicator(true);
            status.setMessage("progress.... ");
            status.show();
            NetworkManager.getInstance().addToQueueAndWait(r);
            new  UtilisateursForm(res).show();
             
         
     }
    
     public void update(Resources res ,Utilisateur u){
          
            System.out.println(u.getId());
                 
                ConnectionRequest r = new ConnectionRequest();
                 String url =  "http://127.0.0.1:8000/updateUtilisateur?id="+u.getId()+
                 "&nom="+u.getNom()+
               "&prenom="+u.getPrenom()+
               "&password="+u.getPassword()+
               "&email="+u.getEmail()+
                "&adresse="+u.getAdresse()+
               "&username="+u.getUsername()+
               "&photo="+u.getPhoto();
            r.setUrl(url);
           
            
            r.setPost(true);
             r.addArgument("encoding", "json");
            r.setContentType("application/json");
            NetworkManager.getInstance().addToQueueAndWait(r);
            r.addResponseListener(resp -> {
           new UtilisateursForm(res).show();
            });
            ToastBar.Status status = ToastBar.getInstance().createStatus();
            status.setShowProgressIndicator(true);
            status.setMessage("progress.... ");
            status.show();
         new UtilisateursForm(res).show();

             
             
            }
    
}
