<?php $this->layout('layout', ['title' => 'Modifier son profil']) ?>

<?php $this->start('main_content') ?>

    <form method="POST">

        <div class="form-group">
            <label for="lastname">Nom :</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?= $w_user['lastname'] ?>">
        </div>

        <div class="form-group">
            <label for="firstname">Prénom :</label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="<?= $w_user['firstname'] ?>">
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $w_user['email'] ?>">
        </div>

        <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="cfpassword">Confirmer le mot de passe:</label>
            <input type="password" class="form-control" id="cfpassword" name="cfpassword">
        </div>

        <button class="btn btn-default">Modifier</button>
    </form>

    <p><?= isset( $message['error'] ) ? $message['error'] : "" ; ?></p>
<?php $this->stop('main_content') ?>
