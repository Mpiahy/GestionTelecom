CREATE INDEX idx_type_equipement ON equipement (id_type_equipement);

CREATE INDEX idx_equipement_id_modele ON equipement (id_modele);
CREATE INDEX idx_equipement_id_statut ON equipement (id_statut_equipement);
CREATE INDEX idx_equipement_modele_statut ON equipement (id_modele, id_statut_equipement);

-- Index pour les id_marque qui commencent par 1 ou 2 (Phone)
CREATE INDEX idx_marque_phone ON marque (id_marque)
WHERE id_marque >= 1000 AND id_marque < 3000;

-- Index pour les id_marque qui commencent par 3 (Box)
CREATE INDEX idx_marque_box ON marque (id_marque)
WHERE id_marque >= 3000 AND id_marque < 4000;

-- Index pour les id_modele qui commencent par 1 ou 2 (Phone)
CREATE INDEX idx_modele_phone ON modele (id_modele)
WHERE id_modele >= 1000000 AND id_modele < 3000000;

-- Index pour les id_modele qui commencent par 3 (Box)
CREATE INDEX idx_modele_box ON modele (id_modele)
WHERE id_modele >= 3000000 AND id_modele < 4000000;

-- Index pour optimiser les sous-requêtes sur id_marque
CREATE INDEX idx_marque_id ON marque (id_marque);

-- Index pour optimiser les sous-requêtes sur id_modele
CREATE INDEX idx_modele_id ON modele (id_modele);
