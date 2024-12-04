<div id="ajouter_forfait" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Ajouter un forfait</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="add_forfait" action="add_forfait" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="add_lib_ue"><strong>Nom du forfait</strong></label><input id="add_bu-1" class="form-control" type="text" placeholder="Entrer le nom du forfait" name="add_bu" /></div>
                                    <div class="mb-3"><label class="form-label" for="add_element-1"><strong>Appel Flotte initial</strong><br /></label>
                                        <div class="input-group"><span class="input-group-text">Quantité</span><input class="form-control" type="number" placeholder="Entrer la quantité" name="add_element-1" min="0" value="0" /><span class="input-group-text">Unité=Heures</span></div>
                                    </div>
                                    <div class="mb-3"><label class="form-label" for="add_element-1"><strong>Appel Flotte supplémentaire</strong><br /></label>
                                        <div class="input-group"><span class="input-group-text">Quantité</span><input class="form-control" type="number" placeholder="Entrer la quantité" name="add_element-1" min="0" value="0" /><span class="input-group-text">Unité=Heures</span></div>
                                    </div>
                                    <div class="mb-3"><label class="form-label" for="add_element-1"><strong>Appel Tout TELMA</strong><br /></label>
                                        <div class="input-group"><span class="input-group-text">Quantité</span><input class="form-control" type="number" placeholder="Entrer la quantité" name="add_element-1" min="0" value="0" /><span class="input-group-text">Unité=Heures</span></div>
                                    </div>
                                    <div class="mb-3"><label class="form-label" for="add_element-1"><strong>Appel Tout MADA</strong><br /></label>
                                        <div class="input-group"><span class="input-group-text">Quantité</span><input class="form-control" type="number" placeholder="Entrer la quantité" name="add_element-1" min="0" value="0" /><span class="input-group-text">Unité=Heures</span></div>
                                    </div>
                                    <div class="mb-3"><label class="form-label" for="add_element-1"><strong>Appel vers Etranger</strong><br /></label>
                                        <div class="input-group"><span class="input-group-text">Quantité</span><input class="form-control" type="number" placeholder="Entrer la quantité" name="add_element-1" min="0" value="0" /><span class="input-group-text">Unité=Heures</span></div>
                                    </div>
                                    <div class="mb-3"><label class="form-label" for="add_element-1"><strong>DATA</strong><br /></label>
                                        <div class="input-group"><span class="input-group-text">Quantité</span><input class="form-control" type="number" placeholder="Entrer la quantité" name="add_element-1" min="0" value="0" /><span class="input-group-text">Unité=15Go</span></div>
                                    </div>
                                    <div class="mb-3"><label class="form-label" for="add_element-1"><strong>SMS</strong><br /></label>
                                        <div class="input-group"><span class="input-group-text">Quantité</span><input class="form-control" type="number" placeholder="Entrer la quantité" name="add_element-1" min="0" value="0" /><span class="input-group-text">Unité=100Sms</span></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-primary" type="submit" form="add_forfait">Ajouter</button></div>
        </div>
    </div>
</div>
<div id="modifier_element" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Modifier cet élément</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="edt_element" action="edt_element" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="edt_forfait"><strong>Forfait</strong></label><input id="edt_forfait" class="form-control" type="text" name="edt_forfait" value="Forfait 0" readonly disabled /></div>
                                    <div class="mb-3"><label class="form-label" for="edt_element"><strong>Elément</strong><br /></label><input id="edt_element" class="form-control" type="text" name="edt_element" value="Appel Flotte Initial" readonly disabled /></div>
                                    <div class="mb-3"><label class="form-label" for="edt_unite"><strong>Unité</strong></label><input id="edt_unite" class="form-control" type="text" name="edt_unite" value="Heures" readonly disabled /></div>
                                    <div class="mb-3"><label class="form-label" for="edt_pu"><strong>Prix Unitaire</strong><br /></label>
                                        <div class="input-group"><input id="edt_pu" class="form-control" type="number" placeholder="Entrer la quantité" name="edt_pu" min="0" value="2160" required /><span class="input-group-text">Ar</span></div>
                                    </div>
                                    <div class="mb-3"><label class="form-label" for="edt_qu"><strong>Quantité</strong></label><input id="edt_qu" class="form-control" type="number" placeholder="Entrer la quantité" name="edt_qu" value="5" required min="0" /></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><button class="btn btn-info" type="submit" form="edt_element">Modifier</button></div>
        </div>
    </div>
</div>
<div id="supprimer_element" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-danger">Voulez vous vraiment supprimer cet élémént?</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div></div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <form id="del_element" action="del_element" method="get" style="color: #a0c8d8;">
                                    <div class="mb-3"><label class="form-label" for="del_forfait"><strong>Forfait</strong></label><input id="del_forfait" class="form-control" type="text" name="del_forfait" value="Forfait 0" readonly disabled /></div>
                                    <div class="mb-3"><label class="form-label" for="del_element"><strong>Elément</strong><br /></label><input id="del_element" class="form-control" type="text" name="del_element" value="Appel Flotte Initial" readonly disabled /></div>
                                    <div class="mb-3"><label class="form-label" for="del_unite"><strong>Unité</strong></label><input id="del_unite" class="form-control" type="text" name="del_unite" value="Heures" readonly disabled /></div>
                                    <div class="mb-3"><label class="form-label" for="del_pu"><strong>Prix Unitaire</strong><br /></label>
                                        <div class="input-group"><input id="del_pu" class="form-control" type="number" placeholder="Entrer la quantité" name="del_pu" min="0" value="2160" required readonly disabled /><span class="input-group-text">Ar</span></div>
                                    </div>
                                    <div class="mb-3"><label class="form-label" for="del_qu"><strong>Quantité</strong></label><input id="del_qu" class="form-control" type="text" placeholder="Entrer la quantité" name="del_qu" value="0" readonly disabled /></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-warning" type="button" data-bs-dismiss="modal">Fermer</button><a class="btn btn-danger" role="button" form="del_element">Supprimer</a></div>
        </div>
    </div>
</div>