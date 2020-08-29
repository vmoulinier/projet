<h2 class="center"><?= $this->twig->translation('profil.title') ?></h2>
<br />
<p><?= $this->twig->translation('profil.infos.name', ['name' =>  $user->getName()]) ?></p>
<p><?= $this->twig->translation('profil.infos.email', ['email' =>  $user->getEmail()]) ?></p>
<?php if($user->getType() === 'ROLE_ADMIN'): ?>
    <p><?= $this->twig->translation('profil.infos.admin') ?></p>
<?php endif; ?>
<br />
<a href="#" class="primary-btn btn-profil"><?= $this->twig->translation('profil.edit.password') ?></a>
<br />
<a href="<?= $this->router->generate("edit_profil") ?>" class="primary-btn btn-profil"><?= $this->twig->translation('profil.edit.informations') ?></a>
<br />
<p class="text-center mt-4">
    <a href="#" class="text-dark"><?= $this->twig->translation('profil.newsletter.on') ?></a>
</p>

