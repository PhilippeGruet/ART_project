<?php $this->layout('layout', ['title' => "Norme : " . $test["name"] ]) ?>

<?php $this->start('main_content') ?>

<div id="displayed-question">
    <?php if (empty($progression)): ?>
        <button type="button" id="start-test" class="btn btn-default">Commencer</button>
    <?php else: ?>
        <button type="button" id="start-test" class="btn btn-default">Recommencer</button>
        <button type="button" id="continue-test" class="btn btn-default">Continuer</button>
    <?php endif; ?>
</div>

<?php foreach ($questions as $key => $question): ?>
<div id="question_<?=$question["id_question"]?>" class="row question hidden <?=(!$key)?"first-question":"";?>">
    <h3 class="question-title"><?=$question["question"]?></h3>
    <?php for ($i = 1; $i < 5; $i++): ?>
        <?php if ( !empty($question['answer_'.$i]) ): ?>
            <div class="radio">
                <label><input type="radio" name="radio" value="answer_<?=$i?>"><?=$question["answer_$i"]?></label>
            </div>
        <?php endif; ?>
    <?php endfor; ?>
</div>
<?php endforeach; ?>

<div id="controler" class="control hidden">
    <button class="btn btn-default disabled btn-test" id="previous">Précédent</button>
    <button class="btn btn-default btn-test" id="validate">Valider</button>
    <button class="btn btn-default btn-test" id="next">Suivant</button>
</div>

<?php var_dump($test) ?>
<?php var_dump($questions) ?>


<?php $this->stop('main_content') ?>
