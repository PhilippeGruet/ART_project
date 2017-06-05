<?php $this->layout('layout', ['title' => 'Inscription']) ?>

<?php $this->start('main_content') ?>

    <form method="POST">
        <div class="form-group">
            <label for="lastname">Nom :</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?= $lastname ?>">
        </div>

        <div class="form-group">
            <label for="firstname">Prénom :</label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="<?= $firstname ?>">
            <?php if ( isset($messages["firstname"]) ) echo "<span class=\"text-danger\">".$messages["firstname"]."</span>"; ?>
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
            <?php if ( isset($messages["email"]) ) echo "<span class=\"text-danger\">".$messages["email"]."</span>"; ?>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input type="password" class="form-control" id="password" name="password">
            <?php if ( isset($messages["password"]) ) echo "<span class=\"text-danger\">".$messages["password"]."</span>"; ?>
        </div>

        <div class="form-group">
            <label for="cfpassword">Confirmer le mot de passe:</label>
            <input type="password" class="form-control" id="cfpassword" name="cfpassword">
            <?php if ( isset($messages["cfpassword"]) ) echo "<span class=\"text-danger\">".$messages["cfpassword"]."</span>"; ?>
        </div>

        <button class="btn btn-default">Inscription</button>
    </form>
    <?php if ( isset($messages["success"]) ) echo "<span class=\"text-success\">".$messages["success"]."</span>"; ?>
    
<?php $this->stop('main_content') ?>
