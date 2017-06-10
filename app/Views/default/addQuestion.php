<?php $this->layout('layout', ['title' => 'Ajouter une question']) ?>

<?php $this->start('main_content') ?>

<form method="POST">
    <div class="form-group">
        <label for="test">Norme dans laquelle ajouter la question* :</label>
        <select name="norme" class="form-control" id="test">
            <!-- Valeur par défaut -->
            <?php if ( strlen($norme) == 0 ): ?>
                <option value="" disabled selected>Norme :</option>
            <?php endif; ?>

            <?php foreach ($categories as $category): ?>
                <optgroup label="<?= $category['name'] ?>">
                    <?php foreach ($tests as $key => $test): ?>
                        <?php if ($test['id_category'] == $category['id_category']): ?>
                            <option <?= ($norme == $test['id_test'])? "selected":"";?> value="<?=$test['id_test']?>">
                                <?=$test['name']?>
                                <?php unset($tests[$key]) ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <!-- Ajouter une norme dans une catégorie présente -->
                    <option <?= ($norme == "add ".$category['id_category'])? "selected":"";?> value="add <?= $category['id_category'] ?>">
                        -- Nouvelle norme --
                    </option>
                    <option disabled></option>
                </optgroup>
            <?php endforeach; ?>

            <!-- Ajouter une catégorie et une norme -->
            <option <?= ($norme == "add")? "selected":"";?> value="add">-- Nouvelle categorie --</option>
        </select>
        <?php if ( isset($messages["norme"]) ) echo "<span class=\"text-danger\">".$messages["norme"]."</span>"; ?>
    </div>

    <!-- Hidden input -->
    <div class="form-group" id="newCategoryDiv">
        <label for="newCategory">Nouvelle catégorie :</label>
        <input type="text" class="form-control" id="newCategory" name="newCategory" value="<?= $newCategory ?>">
    </div>
    <div class="form-group" id="newNormeDiv">
        <label for="newNorme">Nouvelle norme :</label>
        <input type="text" class="form-control" id="newNorme" name="newNorme" value="<?= $newNorme ?>">
        <?php if ( isset($messages["addNorme"]) ) echo "<span class=\"text-danger\">".$messages["addNorme"]."</span>"; ?>
        <?php if ( isset($messages["addCategory"]) ) echo "<span class=\"text-danger\">".$messages["addCategory"]."</span>"; ?>
    </div>

    <hr>

    <!-- Question -->
    <div class="form-group">
        <label for="question">Intitulé de la question* :</label>
        <input type="text" class="form-control" id="question" name="question" value="<?= $question ?>">
        <?php if ( isset($messages["question"]) ) echo "<span class=\"text-danger\">".$messages["question"]."</span>"; ?>
    </div>

    <!-- Les réponses -->
    <div class="form-group">
        <label for="answer_1">Réponse 1* :</label>
        <input type="text" class="form-control" id="answer_1" name="answer_1" value="<?= $answer_1 ?>">
    </div>
    <div class="form-group">
        <label for="answer_2">Réponse 2* :</label>
        <input type="text" class="form-control" id="answer_2" name="answer_2" value="<?= $answer_2 ?>">
        <?php if ( isset($messages["answer_2"]) ) echo "<span class=\"text-danger\">".$messages["answer_2"]."</span>"; ?>
    </div>
    <div class="form-group">
        <label for="answer_3">Réponse 3 :</label>
        <input type="text" class="form-control" id="answer_3" name="answer_3" value="<?= $answer_3 ?>">
    </div>
    <div class="form-group">
        <label for="answer_4">Réponse 4 :</label>
        <input type="text" class="form-control" id="answer_4" name="answer_4" value="<?= $answer_4 ?>">
        <?php if ( isset($messages["answer_4"]) ) echo "<span class=\"text-danger\">".$messages["answer_4"]."</span>"; ?>
    </div>

    <!-- La bonne réponse -->
    <?php (empty($rightAnswer)) ? $rightAnswer = 1 : true ; ?>
    <div class="form-group">
        <label>Numéro de la bonne réponse* :</label>
        <?php for ($i=1; $i < 5; $i++): ?>
            <label class="radio-inline">
                <input type="radio" name="optradio" value="<?= $i?>"
                    <?= ($i == $rightAnswer) ? "checked": "" ?>><?= $i ?>
            </label>
        <?php endfor; ?>
        <?php if ( isset($messages["rightAnswer"]) ) echo "<br><span class=\"text-danger\">".$messages["rightAnswer"]."</span>"; ?>
    </div>

    <!-- Champs optionels -->
    <div class="form-group">
        <label for="help">Note d'aide / réference :</label>
        <input type="text" class="form-control" id="help" name="help" value="<?= $help ?>">
    </div>
    <div class="form-group">
        <label for="more_info">Complément de réponse:</label>
        <input type="text" class="form-control" id="more_info" name="more_info" value="<?= $more_info ?>">
    </div>

    <button class="btn btn-default">Ajouter</button>

    <small class="text-muted">(* champs obligatoire)</small>
</form>

<?php if ( isset($messages["success"]) ) echo "<br><span class=\"text-success\">".$messages["success"]."</span>"; ?>

<?php // echo str_replace('%20', ' ', end( explode('/', $_SERVER['REQUEST_URI']) )); ?>
<?php $this->stop('main_content') ?>
