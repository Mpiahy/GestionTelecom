-- VUE EQUIPEMENT = PHONE
create or replace view view_equipement_phones as 
    select * from equipement where id_type_equipement in (1, 2);
select * from view_equipement_phones;

-- VUE EQUIPEMENT = BOX
create or replace view view_equipement_box as 
    select * from equipement where id_type_equipement = 3;
select * from view_equipement_box;

-- View pour les marques Phone (id_marque commence par 1 ou 2)
CREATE OR REPLACE VIEW view_marque_phone AS
SELECT * 
FROM marque
WHERE id_marque >= 1000 AND id_marque < 3000;

-- View pour les marques Box (id_marque commence par 3)
CREATE OR REPLACE VIEW view_marque_box AS
SELECT * 
FROM marque
WHERE id_marque >= 3000 AND id_marque < 4000;

-- View pour les modèles Phone (id_modele commence par 1 ou 2)
CREATE OR REPLACE VIEW view_modele_phone AS
SELECT * 
FROM modele
WHERE id_modele >= 1000000 AND id_modele < 3000000;

-- View pour les modèles Box (id_modele commence par 3)
CREATE OR REPLACE VIEW view_modele_box AS
SELECT * 
FROM modele
WHERE id_modele >= 3000000 AND id_modele < 4000000;

CREATE or REPLACE VIEW view_element_prix AS
SELECT
    fe.id_forfait,
    e.id_element,
    e.libelle,
    fe.quantite,
    e.unite,
    e.prix_unitaire_element,
    (fe.quantite * e.prix_unitaire_element) AS prix_total_element
FROM
    forfait_element fe
JOIN
    element e ON fe.id_element = e.id_element;

CREATE or REPLACE VIEW view_forfait_prix AS
SELECT
    sub.id_forfait,
    sub.nom_forfait,
    sub.prix_forfait_ht_non_remise,
    sub.droit_d_accise,
    sub.remise_pied_de_page,
    (sub.prix_forfait_ht_non_remise + sub.droit_d_accise - sub.remise_pied_de_page) AS prix_forfait_ht
FROM (
    SELECT
        f.id_forfait,
        f.nom_forfait,
        SUM(fe.quantite * e.prix_unitaire_element) AS prix_forfait_ht_non_remise,
        SUM(fe.quantite * e.prix_unitaire_element) * 0.08 AS droit_d_accise,
        SUM(fe.quantite * e.prix_unitaire_element) * 0.216 AS remise_pied_de_page
    FROM
        forfait f
    JOIN
        forfait_element fe ON f.id_forfait = fe.id_forfait
    JOIN
        element e ON fe.id_element = e.id_element
    GROUP BY
        f.id_forfait, f.nom_forfait
) sub;                

CREATE OR REPLACE VIEW view_ligne_details AS
SELECT 
    ligne.id_ligne,
    ligne.num_ligne,
    ligne.num_sim,
    statut_ligne.statut_ligne,
    ligne.id_type_ligne,
    type_ligne.type_ligne,
    operateur.nom_operateur,
    contact_operateur.email AS contact_email
FROM 
    ligne
LEFT JOIN statut_ligne ON ligne.id_statut_ligne = statut_ligne.id_statut_ligne
LEFT JOIN type_ligne ON ligne.id_type_ligne = type_ligne.id_type_ligne
LEFT JOIN operateur ON ligne.id_operateur = operateur.id_operateur
LEFT JOIN contact_operateur ON ligne.id_operateur = contact_operateur.id_operateur; 
