<?php

use Flextype\Component\Filesystem\Filesystem;

beforeEach(function() {
    filesystem()->directory(PATH['project'] . '/entries')->create();
});

afterEach(function (): void {
    filesystem()->directory(PATH['project'] . '/entries')->delete();
});

test('fields directive', function () {
    entries()->create('field', ['foo' => '@field[id]']);
    $this->assertEquals('field', entries()->fetch('field')['foo']);
});

test('fields directive disabled', function () {
    registry()->set('flextype.settings.entries.directives.fields.enabled', false);
    entries()->create('field', ['foo' => '@field[id]']);
    $this->assertEquals('@field[id]', entries()->fetch('field')['foo']);
    registry()->set('flextype.settings.entries.directives.fields.enabled', true);
});