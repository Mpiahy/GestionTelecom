-- VUE EQUIPEMENT = PHONE
create or replace view forPhones as 
    select * from equipement where id_type_equipement in (1, 2);
select * from forPhones;

-- VUE EQUIPEMENT = PHONE
create or replace view forBox as 
    select * from equipement where id_type_equipement = 3;
select * from forBox;

-- View pour les marques Phone (id_marque commence par 1 ou 2)
CREATE OR REPLACE VIEW marquePhone AS
SELECT * 
FROM marque
WHERE id_marque >= 1000 AND id_marque < 3000;

-- View pour les marques Box (id_marque commence par 3)
CREATE OR REPLACE VIEW marqueBox AS
SELECT * 
FROM marque
WHERE id_marque >= 3000 AND id_marque < 4000;

-- View pour les modèles Phone (id_modele commence par 1 ou 2)
CREATE OR REPLACE VIEW modelePhone AS
SELECT * 
FROM modele
WHERE id_modele >= 1000000 AND id_modele < 3000000;

-- View pour les modèles Box (id_modele commence par 3)
CREATE OR REPLACE VIEW modeleBox AS
SELECT * 
FROM modele
WHERE id_modele >= 3000000 AND id_modele < 4000000;
