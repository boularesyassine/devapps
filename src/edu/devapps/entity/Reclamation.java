/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package edu.devapps.entity;

import java.sql.Date;

/**
 *
 * @author THEOLDISBACK
 */
public class Reclamation {
    
    
    
    int id_rec;
    String sujet;
    String email;
    String description;
    String etat;
    Date date;
    int id_utilisateur_id;

    public Reclamation() {
    }

    public Reclamation(int id_rec, String sujet, String email, String description, String etat, Date date, int id_utilisateur_id) {
        this.id_rec = id_rec;
        this.sujet = sujet;
        this.email = email;
        this.description = description;
        this.etat = etat;
        this.date = date;
        this.id_utilisateur_id = id_utilisateur_id;
    }

    public int getId_rec() {
        return id_rec;
    }

    public void setId_rec(int id_rec) {
        this.id_rec = id_rec;
    }

    public String getSujet() {
        return sujet;
    }

    public void setSujet(String sujet) {
        this.sujet = sujet;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getEtat() {
        return etat;
    }

    public void setEtat(String etat) {
        this.etat = etat;
    }

    public Date getDate() {
        return date;
    }

    public void setDate(Date date) {
        this.date = date;
    }

    public int getId_utilisateur_id() {
        return id_utilisateur_id;
    }

    public void setId_utilisateur_id(int id_utilisateur_id) {
        this.id_utilisateur_id = id_utilisateur_id;
    }

    @Override
    public String toString() {
        return "Reclamation{" + "id_rec=" + id_rec + ", sujet=" + sujet + ", email=" + email + ", description=" + description + ", etat=" + etat + ", date=" + date + ", id_utilisateur_id=" + id_utilisateur_id + '}';
    }
    
    
}
