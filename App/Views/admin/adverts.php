<h2 class="center"><?= $this->twig->translation('admin.users') ?></h2>
<div class="row mt-4">
    <div class="col-12">
        <table class="table table-bordered">
            <thead class="thead-light">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Titre</th>
                <th scope="col">Prix</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php /** @var $advert \App\Entity\Advert */
            foreach($adverts as $advert): ?>
                <tr>
                    <td><?= $advert->getId() ?></td>
                    <td><?= $advert->getTitle() ?></td>
                    <td><?= $advert->getPrice()/100 ?></td>
                    <td class="w-25">
                        <div class="form-inline">
                            <a class="btn btn-primary mr-1" href="<?= $this->router->generate("advert_view", ["id" => $advert->getId()]) ?>" target="_blank">
                                <i class="fa fa-search"></i>
                            </a>
                            <a class="btn btn-primary mr-1" href="<?= $this->router->generate("edit_advert", ["id" => $advert->getId(), "admin" => "admin"]) ?>" target="_blank">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <div class="btn btn-success mr-1 validate" data-id="<?= $advert->getId() ?>">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="btn btn-danger mr-1 delete" data-id="<?= $advert->getId() ?>">
                                <i class="fa fa-trash"></i>
                            </div>
                            <form method="POST" class="mb-0">
                                <button type="submit" class="btn btn-secondary" value="<?= $advert->getUser()->getId() ?>" name="user-login">
                                    <i class="fa fa-user-circle"></i>
                                </button>
                            </form>
                        </div>

                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        $('.validate').click(function(){
            if (confirm('Valider cette annonce ?')) {
                let id = $(this).data('id');
                $.ajax
                ({
                    data: {"validate": id},
                    method: 'post'
                });
                $(this).parent().parent().hide();
            }
        });
        $('.delete').click(function(){
            if (confirm('Supprimer cette annonce ?')) {
                let id = $(this).data('id');
                $.ajax
                ({
                    data: {"delete": id},
                    method: 'post'
                });
                $(this).parent().parent().hide();
            }
        });
    </script>
</div>
