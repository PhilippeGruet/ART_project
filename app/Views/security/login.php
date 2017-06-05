<?php $this->layout('layout', ['title' => 'Connexion']) ?>

<?php $this->start('main_content') ?>

    <div class="col-md-6">
  
        <form method="POST">
            <div class="form-group">
                <label for="username">Email :</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $username ?>">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <button class="btn btn-default">Connexion</button>
            <a href="<?= $this->url('security_forget'); ?>">Mot de passe oublié</a>
        </form>

        <p><?= isset( $message['error'] ) ? $message['error'] : "" ; ?></p>

    </div>

<?php $this->stop('main_content') ?>
