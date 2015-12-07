-- Toutes les langues présentes dans le monde
CREATE TABLE languages_world (
  id SERIAL PRIMARY KEY,
  nom_en varchar(100) NOT NULL,
  locale char(2) NOT NULL,
  nom_fr varchar(100)
);

-- Les continents disponibles
CREATE TABLE continent (
  cont_id SERIAL PRIMARY KEY,
  cont_code char(2) UNIQUE NOT NULL,
  cont_name varchar(100)
	);
	
-- Les pays du monde
CREATE TABLE countries (
  id_pays SERIAL PRIMARY KEY,
  code char(2) UNIQUE NOT NULL,
  name_en varchar(100),
  name_fr varchar(100),
  code_continent integer REFERENCES continent(cont_id) NOT NULL
);

-- Les langues qui seront prises en charge par le site
CREATE TABLE lang (
  lang_id SERIAL PRIMARY KEY,
  lang_code integer NOT NULL UNIQUE REFERENCES languages_world(id),
  lang_img varchar(255) NOT NULL
);

-- Les pages qui seront disponibles dans présentation
CREATE TABLE page (
  page_id SERIAL PRIMARY KEY,
  page_code varchar(30)  NOT NULL UNIQUE,
  page_nom varchar(100) NOT NULL
);

-- Les diverses phrases du jour en fonction de la langue
CREATE TABLE phrase_jour (
	phrase_id SERIAL PRIMARY KEY,
	phrase_content text,
	phrase_lang integer NOT NULL REFERENCES lang(lang_id) ON DELETE CASCADE
);


-- Les types d'actualité
CREATE TABLE actualite (
  act_id SERIAL PRIMARY KEY,
  act_type varchar(30) NOT NULL UNIQUE,
  act_img varchar(255) DEFAULT NULL,
  act_nom varchar(100) NOT NULL
);

-- Contenu des actualités (description)
CREATE TABLE actu_content (
  id SERIAL UNIQUE NOT NULL,
  lang integer NOT NULL REFERENCES lang(lang_id) ON DELETE CASCADE,
  actu integer NOT NULL REFERENCES actualite(act_id) ON DELETE CASCADE,
  content text NOT NULL,
  PRIMARY KEY(lang, actu)
);

-- Les coordonnées pour joindre l'association
CREATE TABLE coordonnees (
  coord_adr text,
  coord_mail varchar(100) NOT NULL,
  coord_tel varchar(10) NOT NULL,
  coord_lat real NOT NULL,
  coord_long real NOT NULL,
  coord_num SERIAL PRIMARY KEY
);

-- Les produits disponibles dans la boutique
CREATE TABLE produits(
  pd_num SERIAL PRIMARY KEY,
  pd_prix real NOT NULL,
  pd_img varchar(255) UNIQUE,
  pd_nom_prive varchar(30) NOT NULL UNIQUE, 
  pd_nom_admin varchar(100) NOT NULL,
  CHECK (pd_prix > 0)
);

-- Les informations sur les produits traduites dans différentes langues
CREATE TABLE produits_contenu (
  bt_num SERIAL UNIQUE NOT NULL,
  bt_lang integer NOT NULL REFERENCES lang(lang_id) ON DELETE CASCADE,
  bt_prod integer NOT NULL REFERENCES produits(pd_num) ON DELETE CASCADE,
  bt_content text,
  bt_nom_public varchar(100) NOT NULL,
  PRIMARY KEY(bt_lang, bt_prod)
);

-- Les utilisateurs du site Web
CREATE TABLE tmembre_inscrit (
  id_membre SERIAL PRIMARY KEY,
  pseudo varchar(30) NOT NULL,
  pass_secure varchar(100) NOT NULL,
  niveau integer NOT NULL CHECK (niveau IN (0, 1)),
  email varchar(100) DEFAULT NULL,
  etat_validation integer NOT NULL CHECK (etat_validation IN (0,1)),
  telephone varchar(10) DEFAULT NULL,
  nom varchar(50) NOT NULL,
  prenom varchar(50) NOT NULL,
  adresse text NOT NULL,
  etat_annuaire integer NOT NULL CHECK (etat_annuaire IN (0,1)),
  UNIQUE(pseudo, email)
);

-- Les billets de blog
CREATE TABLE photo (
  id_photo SERIAL PRIMARY KEY,
  adr_photo varchar(255) NOT NULL UNIQUE,
  date_photo timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  description text DEFAULT NULL
);

-- Les commentaires de billets
CREATE TABLE commentaire (
  id_commentaire SERIAL PRIMARY KEY,
  texte text NOT NULL,
  num_photo integer NOT NULL REFERENCES photo(id_photo) ON DELETE CASCADE,
  auteur integer NOT NULL REFERENCES tmembre_inscrit(id_membre) ON DELETE CASCADE
);

-- Les images disponibles pour le slider d'en haut
CREATE TABLE diaporama (
  diapo_id SERIAL PRIMARY KEY,
  diapo_lien varchar(255)  NOT NULL UNIQUE,
  diapo_active char(1) NOT NULL CHECK (diapo_active IN ('A','F'))
);

-- Tous les fichiers hébergés
CREATE TABLE uploaded_file (
  file_num SERIAL PRIMARY KEY ,
  file_adr varchar(255) NOT NULL UNIQUE
);

-- Les partenaires
CREATE TABLE lien_ext(
  lien_num SERIAL PRIMARY KEY,
  lien_url varchar(255) NOT NULL UNIQUE,
  lien_img varchar(255) UNIQUE,
  lien_nom varchar(100) NOT NULL
);

-- Les messages envoyés sur le livre d'or
CREATE TABLE livreor (
  id SERIAL PRIMARY KEY,
  "date" date NOT NULL,
  nom varchar(50) NOT NULL,
  message text NOT NULL,
  validation integer NOT NULL CHECK (validation IN (0,1))
);

-- Les voyages effectués par l'assocation
CREATE TABLE voyage (
  id_voy SERIAL PRIMARY KEY,
  pays integer NOT NULL REFERENCES countries(id_pays),
  titre varchar(100) NOT NULL,
  texte text
);

-- Le planning des évènements à venir
CREATE TABLE planning (
  id_planning SERIAL PRIMARY KEY,
  pl_jour varchar(10) NOT NULL,
  pl_date date NOT NULL,
  pl_lieu varchar(100) NOT NULL,
  pl_musiciens varchar(150) NOT NULL
);


-- Les musiques disponibles pour être jouée par le lecteur
CREATE TABLE playlist (
  music_id SERIAL PRIMARY KEY,
  music_lien varchar(255)  NOT NULL UNIQUE,
  music_nom varchar(100)  NOT NULL,
  music_active char(1)  NOT NULL CHECK (music_active IN ('A','F')),
  music_groupe varchar(100) DEFAULT NULL,
  UNIQUE (music_lien)
);

-- Les revues de presse concernant l'association
CREATE TABLE revue_presse (
  presse_num SERIAL PRIMARY KEY,
  presse_img varchar(255) NOT NULL,
  presse_titre varchar(100) NOT NULL
);

-- Le texte des différentes pages
CREATE TABLE texte (
    txt_num SERIAL UNIQUE NOT NULL,
  txt_page integer NOT NULL REFERENCES page(page_id) ON DELETE CASCADE,
  txt_titre varchar(100) NOT NULL,
  lang integer NOT NULL REFERENCES lang(lang_id) ON DELETE CASCADE,
  texte text NOT NULL,
  PRIMARY KEY (txt_page,lang)
);

-- Les comptes rendus d'assemblée générale
CREATE TABLE compte_rendu (
  cr_num SERIAL PRIMARY KEY,
  cr_text text NOT NULL,
  cr_date date NOT NULL
);

-- Les titres des pages et des menus
CREATE TABLE titre (
  titre_num SERIAL PRIMARY KEY,
  titre_nom varchar(30) NOT NULL, 
  titre_link varchar(30) UNIQUE NOT NULL
);


-- La traduction des titres dans les différentes langues
CREATE TABLE traduction (
  trad_num SERIAL NOT NULL UNIQUE,
  code_lang integer NOT NULL REFERENCES lang(lang_id) ON DELETE CASCADE,
  code_titre integer NOT NULL REFERENCES titre(titre_num) ON DELETE CASCADE,
  content varchar(100) NOT NULL,
  PRIMARY KEY (code_lang,code_titre)
);