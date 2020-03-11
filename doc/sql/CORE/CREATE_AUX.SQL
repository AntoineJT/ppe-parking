-- things not at the conceptual level
CREATE TABLE LIEN_RESET(
   lien CHAR(20) NOT NULL
   , id_utilisateur INT NOT NULL
   , PRIMARY KEY(lien)
) ENGINE=InnoDB;

ALTER TABLE LIEN_RESET ADD
    CONSTRAINT FK_LNK_COM
    FOREIGN KEY(id_utilisateur)
    REFERENCES UTILISATEURS(id)
;
