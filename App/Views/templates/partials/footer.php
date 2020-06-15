<section class="newslatter">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 center">
                <div class="newslatter__text">
                    <h3><?= $this->twig->translation('footer.title') ?></h3>
                    <p><?= $this->twig->translation('footer.subtitle') ?></p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 center">
                <a href="<?= $this->router->generate('advert_index') ?>" class="btn btn-round btn-outline-danger"><?= $this->twig->translation('footer.view.adverts') ?></a>
            </div>
        </div>
    </div>
</section>
<footer class="footer">
    <div class="container">
        <div class="row footer__widget">
            <div class="col-md-4 col-6 mb-4">
                <h4 class="bold"><?= $this->twig->translation('footer.text.1') ?></h4>
                <a href="https://www.dentiste-remplacant.com" class="footer-link" target="_blank">Dentiste-Remplacant.com</a><br>
                <a href="https://www.cabinet-dentaire.com" class="footer-link" target="_blank">Cabinet-Dentaire.com</a><br>
                <a href="https://www.assistante-dentaire.com" class="footer-link" target="_blank">Assistante-Dentaire.com</a><br>
                <a href="https://www.consentement-eclaire.fr" class="footer-link" target="_blank">Consentement-Eclaire.fr</a><br>
                <a href="https://www.sites-chirdent.net" class="footer-link" target="_blank">Sites-Chirdent.net</a>
            </div>
            <div class="col-md-4 col-6 mt-4">
                <a href="https://www.occasion-dentaire.com" class="footer-link" target="_blank">Occasion-Dentaire.com</a><br>
                <a href="https://www.mon-site-dentaire.com" class="footer-link" target="_blank">Mon-site-Dentaire.com</a><br>
                <a href="https://www.achat-dentaire.com" class="footer-link" target="_blank">Achat-Dentaire.com</a><br>
                <a href="https://www.web-dentaire.com" class="footer-link" target="_blank">Web-Dentaire.com</a>
            </div>
            <div class="col-md-4 col-6">
                <h4 class="bold"><?= $this->twig->translation('footer.text.2') ?></h4>
                <p class="mb-3"><?= $this->twig->translation('footer.text.3') ?> <a href="https://www.sites-chirdent.net" target="_blank">CHIRDENT SARL</a> </p>
                <h4 class="bold"><?= $this->twig->translation('footer.text.1') ?></h4>
                <p class="mb-0"><?= $this->twig->translation('footer.text.4') ?><br>
                    <a href="https://www.sites-chirdent.net" target="_blank" class="footer-link">Sites-Chirdent.net</a>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__text">
                        <p><?= $this->twig->translation('footer.copyright') ?></p>
                    </div>
                    <div class="footer__copyright__links">
                        <a href="#"><?= $this->twig->translation('footer.terms') ?></a>
                        <a href="#"><?= $this->twig->translation('footer.privacy.policy') ?></a>
                        <a href="#"><?= $this->twig->translation('footer.contact') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="<?= PATH ?>/Public/js/theme/bootstrap.min.js"></script>
<script src="<?= PATH ?>/Public/js/theme/jquery.nice-select.min.js"></script>
<script src="<?= PATH ?>/Public/js/theme/jquery-ui.min.js"></script>
<script src="<?= PATH ?>/Public/js/theme/jquery.nicescroll.min.js"></script>
<script src="<?= PATH ?>/Public/js/theme/jquery.barfiller.js"></script>
<script src="<?= PATH ?>/Public/js/theme/jquery.magnific-popup.min.js"></script>
<script src="<?= PATH ?>/Public/js/theme/jquery.slicknav.js"></script>
<script src="<?= PATH ?>/Public/js/theme/owl.carousel.min.js"></script>
<script src="<?= PATH ?>/Public/js/theme/main.js"></script>
<script src="<?= PATH ?>/Public/js/jquery.rateyo.min.js"></script>
