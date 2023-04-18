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
public class Reponse_rec {
    int id_reponse;
    String sujet;
    String etat;
    Date date;
    int id_reclamation;

    public Reponse_rec() {
    }

    public Reponse_rec(int id_reponse, String sujet, String etat, Date date, int id_reclamation) {
        this.id_reponse = id_reponse;
        this.sujet = sujet;
        this.etat = etat;
        this.date = date;
        this.id_reclamation = id_reclamation;
    }

    public int getId_reponse() {
        return id_reponse;
    }

    public void setId_reponse(int id_reponse) {
        this.id_reponse = id_reponse;
    }

    public String getSujet() {
        return sujet;
    }

    public void setSujet(String sujet) {
        this.sujet = sujet;
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

    public int getId_reclamation() {
        return id_reclamation;
    }

    public void setId_reclamation(int id_reclamation) {
        this.id_reclamation = id_reclamation;
    }

    @Override
    public String toString() {
        return "Reponse_rec{" + "id_reponse=" + id_reponse + ", sujet=" + sujet + ", etat=" + etat + ", date=" + date + ", id_reclamation=" + id_reclamation + '}';
    }
    
    
    
    
    
    
    
}
