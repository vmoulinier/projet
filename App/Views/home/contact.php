<div class="container user-container">
    <h2 class="center mb-4"><?= $this->twig->translation('contact.title') ?></h2>
    <br />
    <div class="row">
        <div class="col-md-6">
            <h5><?= $this->twig->translation('contact.subtitle.left') ?></h5>
            <br />
            <form method="post">
                <?= $form->input('name', $this->twig->translation('contact.name'), ['type' => 'text']); ?>
                <?= $form->input('email', $this->twig->translation('contact.email'), ['type' => 'email']); ?>
                <?= $form->input('subject', $this->twig->translation('contact.subject'), ['type' => 'text']); ?>
                <?= $form->input('message', $this->twig->translation('contact.message'), ['type' => 'textarea']); ?>
                <?= $form->submit($this->twig->translation('contact.submit')); ?>
            </form>
        </div>
        <div class="col-md-6">
            <h5><?= $this->twig->translation('contact.subtitle.right') ?></h5>
            <br />
            <p><?= $this->twig->translation('contact.content.right') ?></p>
        </div>
    </div>
</div>
