<?php namespace Flextype ?>
<?php use Flextype\Component\{Http\Http, Registry\Registry, Filesystem\Filesystem, Token\Token, Text\Text} ?>
<?php use function Flextype\Component\I18n\__; ?>
<?php Themes::view('admin/views/partials/head')->display() ?>
<?php Themes::view('admin/views/partials/navbar')
    ->assign('links', [
                            'entries' => [
                                            'link' => Http::getBaseUrl() . '/admin/entries',
                                            'title' => __('admin_entries'),
                                            'attributes' => ['class' => 'navbar-item active']
                                        ]
                        ])
    ->assign('buttons', [
                            'entries' => [
                                            'link' => Http::getBaseUrl() . '/admin/entries/add?entry=' . Http::get('entry'),
                                            'title' => __('admin_create_new_entry'),
                                            'attributes' => ['class' => 'float-right btn']
                                        ]
                        ])
    ->display()
?>
<?php Themes::view('admin/views/partials/content-start')->display() ?>

<?php if (count($entries_list) > 0): ?>
<table class="table no-margin">
    <thead>
        <tr>
            <th><?= __('admin_entry') ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($entries_list as $entry): ?>
        <tr>
            <td>
                <?php $count = count(Entries::fetchAll($entry['slug'], 'slug', 'ASC')) ?>
                <a href="<?php if ($count > 0): ?><?= Http::getBaseUrl() ?>/admin/entries/?entry=<?= $entry['slug'] ?><?php else: ?><?= Http::getBaseUrl() ?>/admin/entries/edit?entry=<?= $entry['slug'] ?><?php endif ?>">
                    <?php if (isset($entry['fieldset'])): ?>
                        <?php if (Filesystem::has(PATH['themes'] . '/' . Registry::get('settings.theme') . '/fieldsets/' . $entry['fieldset'] . '.yaml')): ?>
                            <?php $fieldset = YamlParser::decode(Filesystem::read(PATH['themes'] . '/' . Registry::get('settings.theme') . '/fieldsets/' . $entry['fieldset'] . '.yaml')) ?>
                            <?php if (isset($fieldset['default_field'])): ?>
                                <?= $entry[$fieldset['default_field']] ?>
                            <?php else: ?>
                                <?= $entry['slug'] ?>
                            <?php endif ?>
                        <?php else: ?>
                            <?= $entry['slug'] ?>
                        <?php endif ?>
                    <?php else: ?>
                        <?= $entry['slug'] ?>
                    <?php endif ?>
                </a>
                <?php if ($count > 0): ?>
                    (<?= $count ?>)
                <?php endif ?>
            </td>
            <td class="text-right">
                <div class="btn-group">
                  <a class="btn btn-default" href="<?= Http::getBaseUrl() ?>/admin/entries/edit?entry=<?= $entry['slug'] ?>"><?= __('admin_edit') ?></a>
                  <button type="button" class="btn btn-default dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= Http::getBaseUrl() ?>/admin/entries/add?entry=<?= $entry['slug'] ?>"><?= __('admin_add') ?></a>
                    <a class="dropdown-item" href="<?= Http::getBaseUrl() ?>/admin/entries/duplicate?entry=<?= $entry['slug'] ?>&token=<?= Token::generate() ?>"><?= __('admin_duplicate') ?></a>
                    <a class="dropdown-item" href="<?= Http::getBaseUrl() ?>/admin/entries/rename?entry=<?= $entry['slug'] ?>"><?= __('admin_rename') ?></a>
                    <a class="dropdown-item" href="<?= Http::getBaseUrl() ?>/admin/entries/move?entry=<?= $entry['slug'] ?>"><?= __('admin_move') ?></a>
                    <a class="dropdown-item" href="<?= Http::getBaseUrl() ?>/<?= $entry['slug'] ?>" target="_blank"><?= __('admin_preview') ?></a>
                    <a class="dropdown-item" href="<?= Http::getBaseUrl() ?>/admin/entries/type?entry=<?= $entry['slug'] ?>"><?= __('admin_type') ?></a>
                  </div>
                </div>
                <a class="btn btn-default" href="<?= Http::getBaseUrl() ?>/admin/entries/delete?entry=<?= $entry['slug'] ?>&entry_current=<?= Http::get('entry') ?>&token=<?= Token::generate() ?>"><?= __('admin_delete') ?></a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
<?php else: ?>

<?php endif ?>

<?php Themes::view('admin/views/partials/content-end')->display() ?>
<?php Themes::view('admin/views/partials/footer')->display() ?>
