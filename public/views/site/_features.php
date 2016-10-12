<?php foreach ($features as $feature): ?>
    <?= $feature->type; ?> 
    <?= $feature->mainLanguageFeature->value; ?>
<?php endforeach; ?>