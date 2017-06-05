<?php $this->layout('layout', ['title' => 'Accueil']) ?>

<?php $this->start('main_content') ?>

<!-- Affichage des domaines/categories -->
<ul>
	<?php foreach ($categories as $category): ?>
		<li>
			<a class="category" href="#"><?= $category['name'] ?></a>

			<!-- Affichage des tests/normes -->
			<ul class="tests-list">
				<?php $elmDisplayed = 0; ?>
				<?php foreach ($tests as $key => $test): ?>
					<?php if ( $test['id_category'] == $category['id_category']): ?>
						<li class="test">
							<a href="<?= $this->url('default_test', ['idTest'=>$test['id_test']]) ?>"><?= $test['name']; ?></a>
						</li>
						<?php unset($tests[$key]); $elmDisplayed++; ?>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php if ($elmDisplayed == 0): ?>
					<p>Aucun test.</p>
				<?php endif; ?>
			</ul>
		</li>
	<?php endforeach; ?>
</ul>

<?php var_dump($categories) ?>
<?php var_dump($tests) ?>
<?php $this->stop('main_content') ?>
