CREATE DATABASE telecom;

\c telecom;

CREATE TABLE operateur(
   id_operateur SERIAL,
   nom_operateur VARCHAR(55) ,
   PRIMARY KEY(id_operateur)
);
